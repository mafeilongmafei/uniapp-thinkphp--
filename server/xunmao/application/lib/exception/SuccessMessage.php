<?php

namespace app\lib\exception;


class SuccessMessage extends BaseException {
    public $code = 200;
    public $msg = "ok";
    public $errorCode = 0;
}