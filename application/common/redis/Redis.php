<?php
namespace app\common\redis;


class Redis
{
    public $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1',6379);
    }

    public function set($key,$val)
    {
        return $this->redis->set($key, $val);
    }

    public function get($key)
    {
        return $this->redis->get($key);
    }

    /**
     * 无序集合设置
     * @param $key
     * @param $val
     * @return bool
     */
    public function sAdd($key , $val)
    {
        if(!$this->redis->sAdd($key,$val)){
            return false;
        }
        return true;
    }

    /**
     * 判断集合当中元素是否存在
     * @param $key
     * @param $val
     * @return bool
     */
    public function isSetExits($key , $val)
    {
        return $this->redis->sismember($key, $val);
    }

    /**
     * 设置key失效时间
     * @param $key
     * @param $time
     * @return bool
     */
    public function expire($key ,$time)
    {
        if(!$this->redis->expire($key,$time)){
            return false;
        }
        return true;
    }



}