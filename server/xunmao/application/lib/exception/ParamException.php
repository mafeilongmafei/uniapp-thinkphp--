<?php
namespace app\lib\exception;


class ParamException extends BaseException {
    public $code = 400;
    public $msg = "请求参数有误";
    public $errorCode = 10000;
    

}