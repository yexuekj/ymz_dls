<?php

namespace app\model;

class RoleModel extends BaseModel
{
    public $table = 'role';

    public $indexAjaxParams = [
        'alias' => 'role',
        'join' => [

        ],
        'order' => 'role.role_id desc',
        'field' => 'role.*',
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
            'sort'=>'number'
        ],
        'name' => [
            'name'=>'角色名称',
            'width'=>'200',
            'fixed'=> true,
        ],
    ];
}