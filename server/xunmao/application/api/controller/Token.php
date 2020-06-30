<?php

namespace app\api\controller;

use app\api\service\UserToken;
use app\api\validate\TokenValidate;
use think\facade\Request;


class Token
{
    public function getToken()
    {
        (new TokenValidate())->getCheck();
        $id = intval(Request::param("id"));
        $token = (new UserToken($id))->grantToken();
        return json($token);
       
    }
}
