<?php
namespace app\api\validate;


class TokenValidate extends BaseValidate {
    protected $rule = [
        "id" => "require"
    ];
}