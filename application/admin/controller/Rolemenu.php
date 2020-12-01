<?php

namespace app\admin\controller;

use app\model\RoleMenuModel;
use think\Db;
use think\Request;

class Rolemenu extends Base
{
    public function __construct(Request $app)
    {
        parent::__construct($app);
        $this->model = RoleMenuModel::class;
    }

    public function  index(){
        return parent::index();
    }

    public function afterIndexAjax($data)
    {
        foreach($data as $key=>&$val){
            $val['url'] =  $val['controller_name'].'/'.$val['action_name'];
        }
        return parent::afterIndexAjax($data); // TODO: Change the autogenerated stub
    }

    public function edit()
    {
        // 一级菜单
        $info = Db::name('menu')->where('menu_id =0')->select();
        $this->assign('info',$info);

//        //二级菜单
//        $info_two = Db::name('menu')->alias('m_1')->join('menu m_2','m_1.menu_id = m_2.id')->field('m_1.*')->where('m_1.menu_id !=0 and m_2.menu_id =0')->select();
//        $this->assign('info_two',$info_two);

        $role_info = Db::name('role')->select();
        $this->assign('role_info',$role_info);
        return parent::edit(); // TODO: Change the autogenerated stub
    }

    public function  editData()
    {
        return parent::editData(); // TODO: Change the autogenerated stub
    }

   public function beforeAdd($data){
        $params = $data;
        $ex_name = explode('/',$params['url']);
        $p_id =$params['p_id'];
        $params['menu_id'] = $p_id;
        if(count($ex_name) == 2 && $p_id != 0){
            $params['controller_name'] = $ex_name[0];
            $params['action_name'] = $ex_name[1];
        }
       return parent::beforeAdd($params); // TODO: Change the autogenerated stub
   }

    public function afterAdd($param, $id)
    {
        $save=array(
                'role_id'=>$param['role_id'],
                'menu_id'=>$id
            );
        Db::name('role_menu')->insert($save);
        parent::afterAdd($param, $id); // TODO: Change the autogenerated stub
    }


    public function editDataBeforeAssign($data){
        $data['url'] =  $data['controller_name'].'/'.$data['action_name'];
        return parent::editDataBeforeAssign($data);
    }

    public function queryWhere()
    {
        if(!empty($this->param['menu_name'])){
            $this->param[] = ['menu.menu_name','like','%'.trim($this->param['menu_name']).'%'];
        }
        return parent::queryWhere();
    }






}