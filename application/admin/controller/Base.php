<?php

namespace app\admin\controller;

use think\App;
use think\Controller;
use think\Db;
use think\Exception;
use think\Request;
use think\Session;

class Base extends Controller
{
    protected $role_id;

    protected $adminInfo;

    protected $uid;

    protected $param;

    protected $model;

    protected $controller;

    protected $action;

    protected $db;
    /**
     * 当前操作id
     * @var null
     */
    protected $id = null;

    protected $pk = 'id';

    public function __construct(Request $app)
    {
        parent::__construct();
        $this->controller = ($this->request->controller());
        $this->action = ($this->request->action());
        $allow = $this->allowUrl($this->action,$this->controller);
        $this->checkLogin($allow);
        $param = $this->request->param();
        $this->authenticate($this->action,$this->controller,$allow);
        if(!empty($param[$this->pk])){
            $this->id = $param[$this->pk];
            unset($param[$this->pk]);
        }
        $this->param = $param;

        $this->assign('project_name',config('project_name')) ;

    }

    /**
     * 登录检查
     */
    protected function checkLogin($allow)
    {
        $adminInfo =  Session('adminInfo');
        if(is_null($adminInfo) && !$allow){
            echo "<script>alert('登录凭证过期 请重新登录!');window.location.href='/admin/login/index'</script>";
        }else{
            $this->adminInfo = $adminInfo;
            $this->uid = $adminInfo['id'];
            $this->role_id = $adminInfo['role_id'];
            $this->assign('role_id',$adminInfo['role_id']);
        }
    }

    /**
     * 通用列表页面
     * @return mixed
     */
    public function index()
    {
        $this->assign('index','/admin/'.($this->controller).'/indexAjax');
        $this->assign('edit','/admin/'.strtolower($this->controller).'/edit');
        $this->assign('del','/admin/'.$this->controller.'/del');

        $data = array_merge($this->fetchTemplate(),['list'=> (new $this->model)->listField]);
        if(!empty($data)){
            foreach ($data as $k => $v){
                $this->assign($k,$v);
            }
        }
        $this->controller = strtolower($this->controller);
        return $this->fetch(($this->controller).'/'.$this->action);
    }

    /**
     * 模板渲染参数
     * @return array
     */
    public function fetchTemplate()
    {
        return [];
    }


    /**
     * where 查询前置
     * @return mixed
     */
    public function queryWhere()
    {
        foreach ($this->param as $k => $v){
            if(in_array($k,['page','limit'])){
                continue;
            }
            if(!is_array($v)){
                unset($this->param[$k]);
            }
        }
        return $this->param = array_filter($this->param,function ($index){
            return !empty($index);
        });
    }

    /**
     * 列表接口数据返回
     * @return \think\response\Json
     */
    public function indexAjax()
    {
        $this->queryWhere();
        list($count,$data) = (new $this->model)->indexAjax($this->param);
        return $this->success($this->afterIndexAjax($data),'',0,['count' => $count]);
    }

    /**
     * 返回前数据操作
     * @param $data
     * @return mixed
     */
    public function afterIndexAjax($data)
    {
        foreach ($data as &$v){
            if(!empty($v['created_at'])){
                $v['created_at'] = date('Y-m-d H:i:s',$v['created_at']);
            }
            if(!empty($v['updated_at'])){
                $v['updated_at'] = date('Y-m-d H:i:s',$v['updated_at']);
            }
            if(!empty($v['created_time'])){
                $v['created_time'] = date('Y-m-d H:i:s',$v['created_time']);
            }
        }
        return $data;
    }


    /**
     * 编辑页面
     * @return mixed
     */
    public function edit()
    {
        if($this->id){
            $model = (new $this->model);
            $model->indexAjaxParams['page_status'] = false;
            $model->indexAjaxParams['select'] = false;
            $model->indexAjaxParams['count'] = false;
            $model->indexAjaxParams['where'][] = [$model->table.'.'.$this->pk ,'=', $this->id];
            $data = $model->indexAjax([]);
            $this->assign('data',$this->editDataBeforeAssign($data[0]));
        }
        $info = $this->editData();
        if(!empty($info)){
            foreach ($info as $k => $v){
                $this->assign($k,$v);
            }
        }
        $this->assign('url','/admin/'.$this->controller.'/editAjax');
        return $this->fetch(strtolower($this->controller).'/'.$this->action);
    }

    /**
     * 编辑页面传输数据前
     * @param $data
     * @return mixed
     */
    public function editDataBeforeAssign($data)
    {
        return $data;
    }




    /**
     * 编辑页面数据
     * @return array
     */
    public function editData()
    {
        return [];
    }

    /**
     * 编辑页面处理
     * @return \think\response\Json
     */
    public function editAjax()
    {
        if(empty($this->id)){
            try{
                Db::startTrans();
                $data = $this->beforeAdd($this->param);
                $model = new $this->model;
                foreach ($data as $k => $v){
                    $model->$k = $v;
                }
                $model->save();
                $this->afterAdd($data,$model->id);
                Db::commit();
                return $this->success();
            }catch (Exception $e){
                Db::rollback();
                return $this->error([],$e->getMessage());
            }
        }else{
            try{
                Db::startTrans();
                $model = (new $this->model)->where($this->pk,$this->id)->find();
                $data = $this->beforeUpdate($this->param,$this->id);
                foreach ($data as $k => $v){
                    $model->$k = $v;
                }
                $model->save();
                $this->afterUpdate($data,$this->id);
                Db::commit();
                return $this->success();
            }catch (Exception $e){
                Db::rollback();
                return $this->error([],$e->getMessage());
            }
        }
    }

    /**
     * 添加前置操作
     * @param $param
     * @return mixed
     */
    public function beforeAdd($param)
    {
        $param['created_at'] = time();
        return $param;
    }

    /**
     * 修改前置操作
     * @param $param
     * @param $id
     * @return mixed
     */
    public function beforeUpdate($param,$id)
    {
        $param['updated_at'] = time();
        return $param;
    }

    /**
     * 添加后置操作
     * @param $param
     * @param $id
     */
    public function afterAdd($param,$id){}

    /**
     * 修改后置操作
     * @param $param
     * @param $id
     */
    public function afterUpdate($param,$id){}


    public function del()
    {
        try{
            Db::startTrans();
            $data = $this->beforeDel($this->param,$this->id);
            $model = (new $this->model)->where($this->pk,$this->id)->find();;
            if($data['del']){
                $model->delete();
            }else{
                unset($data['del']);
                foreach ($data as $k => $v){
                    $model->$k = $v;
                }
                $model->save();
            }
            $this->afterDel($data,$model->id);
            Db::commit();
            return $this->success();
        }catch (Exception $e){
            Db::rollback();
            return $this->error([],$e->getMessage());
        }
    }


    public function beforeDel($param,$id)
    {
        $param['del'] = false;
        return $param;
    }

    public function afterDel($param,$id){}



    public function getDataBaseConfig($id,$data = [])
    {
        if(empty($data)){
            $info = Db::table('user_host')->where('id',$id)->find();
            $database = explode('.',$info['host']);
            $ip  = gethostbyname($info['host']);
            return $config = [
                'type'            => 'mysql',
                'hostname'        => $ip,
                'database'        => $database[0],
                'username'        => 'mtcrm',
                'password'        => 'ymz2020crm',
                'hostport'        => '3306',
            ];
        }else{
            $database = explode('.',$data['host']);
            $ip  = gethostbyname($data['host']);
            return $config = [
                'type'            => 'mysql',
                'hostname'        => $ip,
                'database'        => $database[0],
                'username'        => 'mtcrm',
                'password'        => 'ymz2020crm',
                'hostport'        => '3306',
            ];
        }

    }

    // 权限判断
    public function  authenticate($action,$controller,$allow){
        $role_id  = $this->role_id;
        $url = strtolower($controller.'/'.$action);
        $request = $this->request->method();
        // 非管理员权限配置
        if($role_id != 1 && !$allow){
            $info = Db::name('permission')->alias('per')
                ->join('role_permission role_per','per.id = role_per.permission_id','left')
                ->where(['per.url'=>$url,'role_per.role_id'=>$role_id])
                ->cache(true)
                ->find();
            if(isset($_SERVER['HTTP_REFERER'])){
                $ref_url = $_SERVER['HTTP_REFERER'];
            }else{
                $ref_url = '/admin/menu/index';
            }
            if(!$info){
                if(in_array(strtolower($request),['post','ajax'])){
                    $error_data['data'] = '';
                    $error_data['msg'] = '您没有此权限！';
                    $error_data['code'] = 500;
                    echo json_encode($error_data);die();
                }else{
                    echo "<script>alert('您没有此权限');window.location.href='$ref_url'</script>";
                }
            }
        }
    }

    // 不需要判断权限的接口
    public function allowUrl($action,$controller){
        $url = $controller.'/'.$action;
        if (in_array(strtolower($url),['rechargerecord/recordlist','menu/index','menu/build','menu/main','userhost/gethostlist','userhost/getuser'])) {
            return true;
        }else{
            return false;
        }
    }
}