<?php

namespace app\common\mongo;

use think\Db;
use think\mongo;
use think\mongo\Query;

class MongoDb extends mongo\Connection
{
    public $db ;

    /**
     * MongoDb constructor.
     * @throws \think\Exception
     */
    public function __construct()
    {
        $this->connectDb();
    }

    /**
     * @throws \think\Exception
     */
    protected function connectDb()
    {
       $this->db = Db::connect(config('app.mongo_db'));
    }

    public function findOne($table,$where,$order)
    {
        return $this->db->table($table)->where($where)->order($order)->find();
    }
}