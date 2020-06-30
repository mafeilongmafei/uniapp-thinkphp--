<?php

namespace app\lib\exception;


class EmailException  extends BaseException
{
    public $code = 200;
    public $msg = "邮件发送失败";
    public $errorCode = 20000;
}
