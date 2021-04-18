<?php

namespace app\model;

class WorkOrderModel extends BaseModel
{
    public $table = 'work_order';

    public $indexAjaxParams = [
        'alias' => 'work_order',
        'join' => [
            ['user','user.id=work_order.user_id','left']
        ],
        'order' => 'work_order.created_at desc',
        'field' => 'user.user_name,work_order.*',
        'where' => [
            ['work_order.status','neq',3]
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
        'title' => [
            'name'=>'标题',
            'width'=>'250',
        ],
        'type' => [
            'templet' => true,
            'name'=>'类型',
            'width'=>'120',
        ],
        'status' => [
            'templet' => true,
            'name'=>'状态',
            'width'=>'80',
        ],
        'created_at' => [
            'name'=>'创建时间',
            'width'=>'180',
        ],
    ];
}