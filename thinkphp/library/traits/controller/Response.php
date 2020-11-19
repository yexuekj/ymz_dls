<?php
namespace traits\controller;

Trait Response
{
    public function success($data = [],$msg = 'success',$code = 200,$param = [])
    {
        $result = ['code' => $code,'msg' => $msg,'data' => $data ?? [] ];
        if(!empty($param)){
            return json(array_merge($result,$param));
        }
        return json($result);
    }

    public function error($data = [],$msg = 'error',$code = 500)
    {
        return json(['code' => $code,'msg' => $msg,'data' => $data ?? [] ]);
    }
}