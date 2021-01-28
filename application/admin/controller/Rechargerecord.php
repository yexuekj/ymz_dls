<?php

namespace app\admin\controller;

use app\model\RechargeRecordModel;
use think\Db;
use think\Request;

class Rechargerecord extends Base
{
    public function __construct(Request $app)
    {
        parent::__construct($app);
        $this->model = RechargeRecordModel::class;
    }

    public function index(){
        return parent::index();
    }

    /**
     * 返回前数据操作
     * @param $data
     * @return mixed
     */
    public function afterIndexAjax($data)
    {
        foreach ($data as &$v){
            if(!empty($v['create_time'])){
                $v['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
            }
        }
       return  parent::afterIndexAjax($data);
    }

    public function queryWhere()
    {
        $role = $this->role_id;
        $uid = $this->uid;
        // 代理商查看自己的充值记录
        if($role == 2){
            $info  = Db::table('user_host')->where('user_id',$uid)->select();
            $allHost = array_column($info,'host');
            $this->param[] = ['re_record.host','in',$allHost];
        }

        if(!empty($this->param['host'])){
            $this->param[] = ['re_record.host','like','%'.trim($this->param['host']).'%'];
        }
        return parent::queryWhere();
    }


    /**
     * 充值记录
     */
    public function  recordList(){
        $type = input('type','');
        $page = input('nowpage',1,'trim');   // 当前页数
        $limit = input('limit',10,'trim');   // 每页显示数
        $date = input('selectmonth','','trim');   // 选择的时间
        $host = input('host','');                  // 搜索的域名
        $api_type = input('api_type','');          // 接口是否导出
        $where = [];
        if($host){
            $where['host'] = $host;
        }
        $wheresql = '1=1';
        if($date){
            $wheresql = 'from_unixtime(create_time,"%Y-%m") ='."'$date'";
        }
        $rechargeModel =  Db::name('recharge_record');
        $orderby = 'id desc';
        $field = 'id,host,minutes,from_unixtime(create_time,"%Y-%m-%d %H:%i:%s") create_time,type';
        if($type == 'export'){
            // 导出
            $resdata = $rechargeModel->where($wheresql)->where($where)->field($field)->order($orderby)->select();
            return  $resdata;
        }else{
            if($api_type == 'all'){
                // 接口导出
                $resdata = $rechargeModel->where($wheresql)->where($where)->field($field)->order($orderby)->select();
            }else{
                $resdata = $rechargeModel->where($wheresql)->where($where)->page($page,$limit)->field($field)->order($orderby)->select();
            }
        }
        $count = $rechargeModel->where($wheresql)->where($where)->count();
        return returnAjax(1,'获取成功',['data'=>$resdata,'total'=>$count]);
    }

}
