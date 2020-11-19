<?php

namespace app\model;

class UserModel extends BaseModel
{
    public $table = 'user';

    public $indexAjaxParams = [
        'alias' => 'user',
        'join' => [
        ],
        'order' => 'user.created_at desc',
        'field' => 'user.*',
        'where' => [
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
        'user_name' => [
            'name'=>'代理商名称',
            'width'=>'150',
        ],
        'login_number' => [
            'name'=>'账号',
            'width'=>'150',
        ],
        'price' => [
            'name'=>'代理商余额',
            'width'=>'150',
        ],
        'user_total' => [
            'name'=>'账户数量',
            'width'=>'150',
        ],
        'user_set_total' => [
            'name'=>'已开通坐席数量',
            'width'=>'150',
            'templet'=> true
        ],
        'created_at' => [
            'name'=>'创建时间',
            'width'=>'240',
        ],
        'status' => [
            'name'=>'状态',
            'width'=>'100',
            'templet'=> true
        ],
    ];
}