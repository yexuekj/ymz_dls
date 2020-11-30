<?php

namespace app\admin\controller;

use app\model\PublishModel;
use think\Controller;
use think\Cookie;
use think\Db;
use think\Request;
use think\Session;

class Publish extends Base
{

    public function __construct(Request $app)
    {
        parent::__construct($app);
        $this->model = PublishModel::class;
    }

    public function index()
    {
      return parent::index();
    }

    public function add(){


    }

    public function queryWhere()
    {
        if(!empty($this->param['date']) && !empty($this->param['date'])){
            $this->param[] = ['created_at','between',strtotime($this->param['date'].' 00:00:00').','. strtotime($this->param['date'].' 24:00:00') ];
        }
        return parent::queryWhere();
    }



}