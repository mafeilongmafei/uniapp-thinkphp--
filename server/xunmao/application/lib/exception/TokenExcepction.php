<?php

namespace app\lib\exception;


class TokenExcepction extends BaseException
{
    public $code = 401;
    public $msg = "token已过期,无效token";
    public $errorCode = 10006;
}
