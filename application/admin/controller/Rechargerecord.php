<?php

namespace app\admin\controller;

use think\Db;
use think\Request;

class Rechargerecord extends Base
{
    public function __construct(Request $app)
    {
        parent::__construct($app);
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
        $field = 'id,host,minutes,from_unixtime(create_time,"%Y-%m-%d %H:%i:%s") create_time';
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