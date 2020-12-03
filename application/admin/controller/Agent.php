<?php

namespace app\admin\controller;

use app\model\AgentModel;
use app\model\UserModel;
use think\App;
use think\Db;
use think\Exception;
use think\Request;

class Agent extends Base
{
    public function __construct(Request $app)
    {
        parent::__construct($app);
        $this->model = AgentModel::class;
    }

    public function index(){
        $select_id = isset($_GET['selectid']) ? $_GET['selectid']:'';
        $this->assign('select_id',$select_id);
        return parent::index();
    }


    /**
     * 查看坐席开通记录
     */
    public function indexAjax()
    {
        $param = $this->request->param();
        $all_arr=[];
        $adminInfo = session('adminInfo');
        $login_id = $adminInfo['id'];
        $user_id = isset($param['select_id']) &&  $param['select_id'] ? $param['select_id'] :$login_id;
        $where = [];
        if(isset($param['host'])){
            $host_name  = $param['host'];
            $where=[
                array('host','like',"%$host_name%")
            ];
        }
        $host = Db::table('user_host')->where('user_id',$user_id)->where($where)->order('host desc')->select();
        foreach ($host as $v) {
            $config = $this->getDataBaseConfig('', $v);
            $host = explode('.',$v['host']);
            $sql = "SELECT COUNT(user_id) as open_num,FROM_UNIXTIME(`reg_time`,'%Y-%m-%d') as open_time ,0 as ID,'".$host[0]."'as host"." FROM `mx_user` WHERE `role_id` != 1 AND `category_id` != 1 GROUP BY open_time order by open_time desc";
            $list = Db::connect($config)->table('mx_user')->query($sql);
            if (is_array($list)) {
                $all_arr = array_merge($list, $all_arr);
            }
        }
        $count = count($all_arr);
        $limit = $param['limit'];
        $page = $param['page'];
        $offset = $limit*($page - 1);
        $all_arr = array_slice($all_arr,$offset,$limit);
        if($count>0){
            return $this->success($all_arr,'',0,['count' => $count]);
        }else{
            return $this->success([],'',0,['count' => 0]);
        }
    }


    public function queryWhere()
    {
        if(!empty($this->param['host'])){
            $this->param[] = ['host','like','%'.$this->param['host'].'%'];
        }
        return parent::queryWhere();
    }








}