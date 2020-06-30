<?php
namespace app\api\service;

use app\api\model\Users;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ParamException;
use app\lib\exception\TokenExcepction;


class UserToken extends Token {
    public $uid;
    function __construct($id)
    {
        $this->uid = $id;
    }
    public function grantToken() {
        //拿到用户id 到数据库中查看有没
        // 有 根据uid 生成 token 加入缓存  没有报错
        $uInfo = Users::find($this->uid);
        if(!$uInfo) {
            throw new ParamException(['msg' => "用户id无效"]);
        }
        $catchValue = $this->prepareCacheValue();
        $token = $this->saveToCatch($catchValue);
        return $token;

    }
    //生成value
    private function prepareCacheValue() {
        $catchValue = [];
        $catchValue['uid'] = $this->uid;
        $catchValue['scope'] = ScopeEnum::User;
        return $catchValue;
    }
    private function saveToCatch($catchValue) {
        $key = parent::generdateToken();
        $value = json_encode($catchValue);
        $expire_in = config("secure.token_expire_in");
        $request = cache($key , $value , $expire_in);
        if(!$request) {
            throw new TokenExcepction(['msg' => "服务器缓存异常" , "errorCode" => 10005]);
        }
        return $key; 

    }


}