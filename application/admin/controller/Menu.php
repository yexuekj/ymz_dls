<?php

namespace app\admin\controller;

use app\common\mongo\MongoDb;
use app\model\MenuModel;
use app\model\UserModel;
use think\App;
use think\Db;
use think\Request;

class Menu extends Base
{
    public function __construct(Request $app)
    {
        $this->model = MenuModel::class;
        parent::__construct($app);
    }

    public function index()
    {
       if($this->role_id == 2){
           $user = Db::table('user')->where('id',$this->uid)->find();
           $this->assign('user',$user);
       }

        $this->assign('adminInfo',$this->adminInfo);

       $role_menu = Db::table('role_menu')->where('role_id',$this->role_id)->select();
       $role_menu = array_column($role_menu,'menu_id','menu_id');

       $info = Db::table('menu')->where('is_show',0)->whereIn('id',$role_menu)->order('list_order desc')->select();
       $list = $info;
       foreach ($info as $index => $item){
            $menu = [];
            foreach ($list as $k =>$v){
                if($v['menu_id'] > 0){
                    if($item['id'] == $v['menu_id']){
                        $menu[] = $v;
                    }
                }
            }
           $info[$index]['action'] = $menu;
            if($item['menu_id'] > 0){
                unset($info[$index]);
            }
        }

       // 移动余额
//       $redis = initRedis();
//       $balance = $redis->get('move_balance');
       $balance = 1;
       $balance= $balance ? $balance : 0;
       $this->assign('balance',$balance);

       $this->assign('info',$info);
       return view();
    }

    public function main()
    {
        $data = [
            'user_count' => 1,
            'user_msg_count' => 1,
            'group_count' => 1,
            'group_msg_count' => 2,
        ];

        $this->assign('data',$data);
        return view();
    }

    public function table()
    {
        return 'hello world';
    }

    // 修改密码
    public function changePwd(){
        if($this->request->isPost()){
            $id = $this->uid;
            $param = $_REQUEST;
            $usertable =new UserModel();
            $where = array('id'=>$id);
            $adminInfo = $usertable->where($where)->find();
            if(md5($param['old_password']) != $adminInfo['password']){
                return $this->error([],'旧密码填写错误',500);
            }else{
                $new_password = md5($param['new_password']);
                $res = $usertable->where($where)->update(['password'=>$new_password]);
                if($res !== false){
                    return $this->success([],'修改密码成功',200);
                }
            }
        }else{
          return view();
        }
    }

}