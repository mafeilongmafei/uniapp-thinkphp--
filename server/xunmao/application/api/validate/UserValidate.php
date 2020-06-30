<?php
namespace app\api\validate;


class UserValidate extends BaseValidate {
    protected $rule = [
        "identitfier" => "require",//手机号 第三方应用的唯一标识
        "creadential" => "require",//密码凭证
        "identity_type" => "require"//登录类型
      
    ];
    // 手机号 邮箱登录 
    public function sceneLogin() {
       return  $this->only(["identitfier" , "creadential" , "identity_type"]);
    }
    // 第三方登录例如:微信 qq
    public function sceneNoth5() {
       return  $this->only(["identitfier", "identity_type"]);
    }
    

}