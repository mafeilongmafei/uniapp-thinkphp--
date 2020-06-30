<?php
namespace app\api\controller;
use app\api\validate\SocketValidate;
use app\api\model\Users;


class Socke {
    // 处理用户初始化和加入群组
    public function addUserGroup() {
        $socketVali = new SocketValidate();
        $socketVali->getCheck("Type");
        $data = input("post.");
        Users::bindUidAndClinetId($data);
    }
    // 得到在线用户信息
    public function ByTokenOnlineUser() {
         $data = Users::getOnlineAllUser();
         return json($data);

    }
    // 判断用户是否在线
        

}