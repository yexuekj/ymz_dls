<?php

namespace app\model;

class PermissionModel extends BaseModel
{
    public $table = 'permission';

    public $indexAjaxParams = [
        'alias' => 'per',
        'join' => [
            ['menu','per.menu_id = menu.id ','inner'],
            ['role_permission role_per','role_per.permission_id = per.id ','inner'],
            ['role','role.role_id = role_per.role_id ','left'],
        ],
        'order' => '',
        'field' => 'per.*,menu.menu_name,role.name role_name',
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
        'menu_name' => [
            'name'=>'菜单',
            'width'=>'200',
            'fixed'=> true,
        ],
        'title' => [
            'name'=>'操作名称',
            'width'=>'200',
            'fixed'=> true,
        ],
        'url' => [
            'name'=>'操作路径',
            'width'=>'200',
            'fixed'=> true,
        ],
    ];
}