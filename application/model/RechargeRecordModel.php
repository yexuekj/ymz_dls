<?php

namespace app\model;

class RechargeRecordModel extends BaseModel
{
    public $table = 'recharge_record';

    public $indexAjaxParams = [
        'alias' => 're_record',
        'join' => [
        ],
        'order' => 're_record.create_time desc',
        'field' => 're_record.*',
        'where' => [

        ],
        'count' => true,
        'page_status' => true,
        'select' => true,
    ];

    public $listField = [
        'ID' => [
            'name'=>'编号',
            'width'=>'100',
            'fixed'=> true,
        ],
        'host' => [
            'name'=>'域名',
            'width'=>'200',
            'fixed'=> true,
        ],
        'minutes' => [
            'name'=>'分钟数',
            'width'=>'200',
            'fixed'=> true,
        ],
        'type' => [
            'name'=>'类型',
            'width'=>'200',
            'fixed'=> true,
            'templet'=>true
        ],
        'create_time' => [
            'name'=>'创建时间',
            'width'=>'250',
            'templet'=> true
        ],
    ];
}