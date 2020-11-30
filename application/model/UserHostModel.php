<?php

namespace app\model;

class UserHostModel extends BaseModel
{
    public $table = 'user_host';

    public $indexAjaxParams = [
        'alias' => 'user_host',
        'join' => [
            ['user','user.id=user_host.user_id','left']
        ],
        'order' => 'user_host.created_at desc',
        'field' => 'user_host.*,user.user_name',
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
        'host' => [
            'name'=>'域名',
            'width'=>'180',
        ],
        'key_1' => [
            'name'=>'回拨余额',
            'width'=>'180',
            'templet'=> true
        ],
        'key_0' => [
            'name'=>'axb余额',
            'width'=>'180',
            'templet'=> true
        ],
        'key_2' => [
            'name'=>'已开通坐席数量',
            'width'=>'180',
            'templet'=> true
        ],
        'total_set' => [
            'name'=>'可开通坐席数量',
            'width'=>'180',
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