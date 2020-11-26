<?php

namespace app\model;

class AgentModel extends BaseModel
{
    public $table = 'user_host';


    public $indexAjaxParams = [
        'alias' => '',
        'join' => [

        ],
        'order' => '',
        'field' => '',
        'where' => [

        ],
        'count' => true,
        'page_status' => true,
        'select' => true,
    ];

    public $listField = [
        'ID' => [
            'name'=>'编号',
            'width'=>'120',
        ],
        'host' => [
            'name'=>'域名',
            'width'=>'120',
        ],
        'open_num' => [
            'name'=>'开通数量',
            'width'=>'250',
        ],
        'open_time' => [
            'name'=>'开通日期',
            'width'=>'250',
        ],
    ];
}