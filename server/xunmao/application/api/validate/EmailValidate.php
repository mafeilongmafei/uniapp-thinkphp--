<?php

namespace app\api\validate;


class EmailValidate extends BaseValidate
{
    protected $rule = [
        "identitfier" => "email",
    ];
    public function  sceneToEmail() {
        return $this->only(["identitfier"]);
    }
}
