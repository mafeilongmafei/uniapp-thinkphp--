<?php

namespace app\api\model;

use app\api\validate\UserValidate;


class UserAuths extends BaseModel
{
    public $hidden = ["update_time", "delete_time", "identity_type", "creadential"];
    public function fid()
    {
        return $this->belongsTo("Users", "user_id", "id");
    }

    public static function getByKeyUserInfo($whereYU)
    {
        return self::with("fid")->where($whereYU)->select();
    }
    // 账号是否存在
    public static  function  isAccountPresence($data)
    {
        $isType = isLoginType($data);
        $userValidate = new UserValidate();
        if ($isType) {
            $userValidate->getCheck();
        } else {
            $userValidate->getCheck("Noth5");
        }
        $result = self::getByKeyUserInfo([
            "identitfier" => $data['identitfier'],
            "identity_type" => $data['identity_type']
        ]);
        return $result;

    }
}
