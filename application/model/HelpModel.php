<?php

namespace app\model;

class HelpModel extends BaseModel
{
    public $table = 'help';

    public $indexAjaxParams = [
        'alias' => 'help',
        'join' => [
        ],
        'order' => 'help.created_at desc',
        'field' => 'help.*',
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
        'title' => [
            'name'=>'标题',
            'width'=>'250',
        ],
        'created_at' => [
            'name'=>'创建时间',
            'width'=>'180',
        ],
    ];
}