<?php

namespace app\admin\controller;

use think\Controller;
use think\Cookie;
use think\Db;
use think\Session;

class Login extends Controller
{
    public function index()
    {
        return view();
    }


    public function login()
    {
        $param = $this->request->param();

        if(isset($param['is_true']) && !empty($param['is_true'])){
            $adminInfo = Db::table('admin')->where('login_number',$param['login'])->find();
            $adminInfo['role_id'] = 1;
        }else{
            $adminInfo = Db::table('user')->where('login_number',$param['login'])->find();
            $adminInfo['role_id'] = 2;
        }
        if($adminInfo){
            if(md5($param['pwd']) == $adminInfo['password']){
                if($adminInfo['status']  != 1){
                    return $this->error([],'账号已停用');
                }else{

                    Session('adminInfo',$adminInfo);
                    return $this->success([],'登录成功');
                }
            }else{
                return $this->error([],'账号或密码错误');
            }
        }else{
            return $this->error([],'账号不存在');
        }

    }


    public function loginOut()
    {
        Session('adminInfo',null);
        echo "<script>alert('退出成功');window.location.href='/admin/login/index'</script>";
    }



}