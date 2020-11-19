<?php

namespace app\admin\controller;

use app\common\exception\BaseException;
use app\common\mongo\MongoDb;
use app\model\AdminModel;
use app\model\UserHostModel;
use app\model\UserModel;
use think\App;
use think\Config;
use think\Db;
use think\Exception;
use think\Request;

class Userhost extends Base
{
    public function __construct(Request $app)
    {
        parent::__construct($app);
        $this->model = UserHostModel::class;
    }


    public function index()
    {
        $role = $this->role_id;
        $uid = $this->uid;
        if($role == 2){
            $this->assign('user_id',$uid);
            $info  = Db::table('user')->where('id',$uid)->select();
        }else{
            $info  = Db::table('user')->where('status',1)->select();
        }
        $this->assign('info',$info);
        return parent::index(); // TODO: Change the autogenerated stub
    }


    public function queryWhere()
    {
        $role = $this->role_id;
        $uid = $this->uid;
        if($role == 2){
            $this->param[] = ['user_host.user_id','eq',$uid];
        }else{
            if(!empty($this->param['user_id']) && $this->param['user_id'] > 0){
                $this->param[] = ['user_host.user_id','eq',$this->param['user_id']];
            }
        }

        if(!empty($this->param['user_name'])){
            $this->param[] = ['user_host.host','like','%'.$this->param['user_name'].'%'];
        }
        return parent::queryWhere();
    }


    public function beforeAdd($param)
    {
        $res = Db::table('user_host')->where('ipdata_id',$param['ipdata_id'])->find();
        if($res) throw new Exception('该域名已被使用');

        if(!empty($param['ipdata_id'])){
            $host = Db::connect(\config('data_base_3'))->table('ipdata')->where('id',$param['ipdata_id'])->find();
            $param['ip'] = $host['ip'];
            $param['host'] = $host['domain_name'];
        }
        return parent::beforeAdd($param); // TODO: Change the autogenerated stub
    }


    public function beforeUpdate($param, $id)
    {
        if(!empty($param['ipdata_id'])){
            $host = Db::connect(\config('data_base_3'))->table('ipdata')->where('id',$param['ipdata_id'])->find();
            $param['ip'] = $host['ip'];
            $param['host'] = $host['domain_name'];
        }
        return parent::beforeUpdate($param, $id); // TODO: Change the autogenerated stub
    }


    public function editData()
    {
        $info = Db::table('user')->where('status',1)->select();
        $data['info'] = $info;
        $ipdata = [];
        if(!empty($this->id)){
            $ipdata = Db::table('user_host')->select();
            $ipdata = array_column($ipdata,'ipdata_id','ipdata_id');
            unset($ipdata[$this->id]);
        }
        $host = Db::connect(\config('data_base_3'))->table('ipdata')->where('status',1)->where('type',1)->whereNotIn('id',$ipdata)->select();

        $data['host'] = $host;
        return $data;
    }


    public function afterIndexAjax($data)
    {
        foreach ($data as &$v){
            $v['user_total'] = Db::table('user_host')->where('user_id',$v['id'])->count();
        }
        return parent::afterIndexAjax($data); // TODO: Change the autogenerated stub
    }



    /**
     * 修改密码和充值
     * @return mixed|\think\response\Json
     * @throws Exception
     * @throws \think\exception\PDOException
     */
    public function input()
    {
        $param = $this->request->param();
        if($this->request->isAjax()){
            $res = true;
            if(isset($param['total_set'])){
                if($param['total_set'] <= 0){
                    return $this->error([],'坐席数量必须大于0');
                }
                $res = Db::table('user_host')->where('id',$param['id'])->update([
                    'updated_at' => time(),
                    'total_set' => ($param['total_set'])
                ]);
            }

            if(isset($param['number'])){
                if($param['number'] <= 0){
                    return $this->error([],'充值数量必须大于0');
                }
                $info = Db::table('user_host')->where('id',$param['id'])->find();

                $user = Db::table('user')->where('id',$info['user_id'])->find();

                if($user['price'] < $param['number']){
                    return $this->error([],'用户剩余不足');
                }
                $config = $this->getDataBaseConfig($info['id']);
                $res1 = Db::connect($config)->table('mx_config')->where('name','remain_minutes')->setInc('value',$param['number']);
                $res = Db::table('user')->where('id',$info['user_id'])->setDec('price',$param['number']);
                $res = ($res1 && $res);

            }
            if($res){
                return $this->success();
            }else{
                return $this->error();
            }
        }else{
            $this->assign('id',$param['id'] ?? null);
            $this->assign('type',$param['type'] ?? null);
            $this->assign('url','/admin/userhost/input');
            return $this->fetch('userhost/input');
        }
    }




    public function look_type()
    {
        $param = $this->request->param();
        $config = $this->getDataBaseConfig($param['id']);
        if($param['type'] == 1){
            $info = Db::connect($config)->table('mx_config')->where('name','remain_minutes')->find();
            $arr = [
                'num' => $info['value']
            ];
        }else{
            $number = Db::connect($config)->table('mx_user')->count();
            $arr = [
                'num' => $number
            ];
        }
        return $this->success($arr);

    }

}