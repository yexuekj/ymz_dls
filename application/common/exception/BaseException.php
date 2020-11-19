<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/4/004
 * Time: 16:43
 */

namespace app\common\exception;

use Exception;
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\ThrowableError;
use think\exception\ValidateException;
use think\Response;

class BaseException extends Handle
{
    use \traits\controller\Response;

    public function render(Exception $e)
    {

        // 参数验证错误
        // if ($e instanceof ValidateException) {
        //     return $this->error([],$e->getError(),$e->getCode());
        // }
        //
        //
        // // 请求异常
        // if ($e instanceof HttpException && request()->isAjax()) {
        //     return $this->error([],$e->getMessage(),$e->getCode());
        // }
        //
        // // 抛出异常
        // if ($e instanceof ThrowableError ) {
        //     return $this->error([],$e->getMessage(),$e->getCode());
        // }


        //TODO::开发者对异常的操作
//        if($e->getCode()=='404'){
//            return $this->error([],$e->getMessage(),$e->getCode());
//        }
//         return $this->error([],$e->getMessage(),503);
        //可以在此交由系统处理
        return parent::render($e);

    }
}