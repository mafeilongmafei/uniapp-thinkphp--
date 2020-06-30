<?php
namespace app\lib\exception;


class AddDataException extends BaseException {
   public $code = 500;
   public $msg = "新增失败";
   public $errorCode = 10007;

} 