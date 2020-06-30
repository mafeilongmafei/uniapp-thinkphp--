<?php
namespace app\lib\exception;

use think\Exception;

class BaseException extends Exception {
    // http 状态码
    public $code = 400;
    // 错误消息
    public $msg = "参数错误";
    // 错误码
    public $errorCode  = 10000;
    function __construct($params = []) {
        if (!is_array($params)) {
            throw new Exception("参数必须是数组");
        }else {
            if(array_key_exists("code" , $params)) {
                $this->code = $params['code'];
            }
            if (array_key_exists("msg", $params)) {
                $this->msg =  $params['msg'];
            }
            if (array_key_exists("errorCode", $params)) {
                $this->errorCode =  $params['errorCode'];
            }
        }
    }


}



