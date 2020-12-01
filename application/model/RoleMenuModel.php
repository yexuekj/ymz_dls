<?php

namespace app\model;

class RoleMenuModel extends BaseModel
{
    public $table = 'menu';

    public $indexAjaxParams = [
        'alias' => 'menu',
        'join' => [
            ['role_menu role_m','role_m.menu_id = menu.id ','inner'],
            ['role','role.role_id = role_m.role_id ','inner'],
        ],
        'order' => 'role_m.role_id desc',
        'field' => 'menu.*,role_m.role_id,role.name role_name',
        'where' => [
            ['is_show','eq','0']
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
        'role_name' => [
            'name'=>'角色名称',
            'width'=>'200',
            'fixed'=> true,
        ],
        'menu_name' => [
            'name'=>'菜单名',
            'width'=>'200',
            'fixed'=> true,
        ],
        'url' => [
            'name'=>'菜单路径',
            'width'=>'200',
            'fixed'=> true,
        ],
        'is_show' => [
            'name'=>'是否显示',
            'width'=>'100',
            'templet'=> true
        ],
    ];
}