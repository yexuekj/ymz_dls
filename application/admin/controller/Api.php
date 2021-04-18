<?php

namespace app\admin\controller;

use app\common\exception\BaseException;
use app\common\mongo\MongoDb;
use app\model\AdminModel;
use app\model\HelpModel;
use app\model\UserModel;
use think\App;
use think\Db;
use think\Exception;
use think\Request;

class Api extends Base
{
    public function __construct(Request $app)
    {
        parent::__construct($app);
    }


   public function index()
   {
       $param = $this->request->param();
       $title = '';
       switch ($param['type']){
           case 1:
               $title = '移动AXB';
               break;
           case 2:
               $title = '电信回拨';
               break;
           case 3:
               $title = '联通AXB';
               break;
           case 4:
               $title = '移动回拨';
               break;
           case 5:
               $title = '';
               break;
       }
       $this->assign('title',$title);
       $this->assign('type',$param['type']);
       return view();
   }

}
