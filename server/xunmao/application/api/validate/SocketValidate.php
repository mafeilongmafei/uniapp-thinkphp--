<?php
namespace app\api\validate;




class SocketValidate  extends BaseValidate {
    public $rule = [
        "type" => "require",
        "token" => "require",
        "group_id" => "require",
        "msg" => "require",
        "client_id" => "require",
        "touid" => "require"
    ];
    // 验证type 基础类型
    public function sceneType() {
        return $this->only(['type']);
    }
    // 验证初始化的时候,将client_id和uid绑定
    public function sceneBindClientandUid() {
        return $this->only([  "client_id"]);
    }
    // 将client_id和group绑定
    public function sceneBindClientandGroupId()
    {
        return $this->only(["client_id" , "group_id"]);
    }
    // 给某个用户或者群组发送消息
    public function sceneToUserMsg() {
        return $this->only(['msg' , "touid"]);
    }
    

}