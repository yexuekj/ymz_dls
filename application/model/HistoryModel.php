<?php

namespace app\model;

class HistoryModel extends BaseModel
{
    public $table = 'mx_tel_call_record';

    public $db = true;

    public $db_config = [

    ];


    public $indexAjaxParams = [
        'alias' => 'ua',
        'join' => [
            ['mx_user','mx_user.user_id=ua.owner_user_id','left']
        ],
        'order' => '',
        'field' => 'ua.*,mx_user.full_name',
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
        'full_name' => [
            'name'=>'坐席',
            'width'=>'250',
        ],
        'caller_id_number' => [
            'name'=>'主叫号码',
            'width'=>'150',
        ],
        'destination_number' => [
            'name'=>'被叫号码',
            'width'=>'150',
        ],
        'is_connected' => [
            'name'=>'呼叫状态',
            'width'=>'150',
            'templet'=> true
        ],
        'duration' => [
            'name'=>'通话时长（秒）',
            'width'=>'150',
        ],
        'created_time' => [
            'name'=>'呼叫时间',
            'width'=>'250',
        ],
        'file_path' => [
            'name'=>'录音',
            'width'=>'150',
            'templet'=> true
        ],
//        'call_type' => [
//            'name'=>'拨打方式',
//            'width'=>'150',
//            'templet'=> true
//        ],
    ];
}