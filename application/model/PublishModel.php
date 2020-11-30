<?php

namespace app\model;

class PublishModel extends BaseModel
{
    public $table = 'publish';

    public $indexAjaxParams = [
        'alias' => '',
        'join' => [
        ],
        'order' => 'created_at desc',
        'field' => '*',
        'where' => [
            ['status','eq',1]
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
        'content' => [
            'name'=>'内容',
            'width'=>'150',
        ],
        'title' => [
            'name'=>'标题',
            'width'=>'150',
        ],
        'created_at' => [
            'name'=>'创建时间',
            'width'=>'240',
        ],
    ];
}