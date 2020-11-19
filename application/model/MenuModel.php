<?php

namespace app\model;

class MenuModel extends BaseModel
{
    protected $table = 'menu';

    public $indexAjaxParams = [
        'alias' => 'admin',
        'join' => [],
        'order' => '',
        'field' => '',
        'where' => [
            'status' => 1
        ],
        'count' => true,
        'page_status' => true,
        'select' => true,
    ];

    public $listField = [
        'id' => [
            'name'=>'编号',
            'width'=>'100',
            'fixed'=> true,
        ],
        'admin_name' => [
            'name'=>'管理员名称',
            'width'=>'150',
        ],
        'login_number' => [
            'name'=>'登录账号',
            'width'=>'150',
        ],
        'status' => [
            'name'=>'状态',
            'width'=>'100',
            'templet'=> true
        ],
        'created_at' => [
            'name'=>'创建时间',
            'width'=>'240',
        ],
    ];
}