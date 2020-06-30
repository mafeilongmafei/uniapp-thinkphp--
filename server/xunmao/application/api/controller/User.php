<?php

namespace app\api\controller;

use app\api\model\UserAuths;
use app\api\model\Users as ModelUsers;
use app\api\service\UserToken;
use app\api\validate\EmailValidate;
use app\lib\exception\AddDataException;
use app\lib\exception\ParamException;
use app\lib\exception\SuccessMessage;
use app\api\validate\UserValidate;
use app\lib\exception\EmailException;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenExcepction;
use think\facade\Cache;


class User
{
    /**
     * 注册
     */
    public function registered()
    {
        $data = input("post.");
        // 查询用户存在不
        $result = UserAuths::isAccountPresence($data);
        if (count($result)) {
            // h5重复注册 返回消息
            if (isLoginType($data)) {
                throw new ForbiddenException(["msg" => "该账号已存在"]);
            } else {
                // 第三方登录如果该用户存在 返回用户信息
                $uid = $result[0]['user_id'];
                $token = (new UserToken($uid))->grantToken();
                $result[0]['token'] = $token;
                return json($result[0]);
            }
        }
        // 昵称重复不
        $isPrenscen = ModelUsers::isNicknameRepeat($data);
        if ($isPrenscen) {
            throw new ForbiddenException(["msg" => "该昵称已存在"]);
        }
        // h5端验证码正确吗?
        if (isLoginType($data)) {
            $isCode = ModelUsers::validateEmailCode($data);
            if (!$isCode) {
                throw new TokenExcepction(['msg' => "验证码已过期"]);
            }
        }
        //    保存数据到数据库
        $user = new ModelUsers();
        $result = $user->saveData($data);
        if ($result == false) {
            throw new AddDataException();
        } else {
            // 第三方登录  注册即登录   h5 跳转到登录页
            if (isLoginType($data)) {
                throw new SuccessMessage(['errorCode' => 10006, "msg" => "去登陆"]);
            }
            $id = $result->user_id;
            // 获取token
            $token = (new UserToken($id))->grantToken();
            $data['id'] = $id;
            $data['token'] = $token;
            return json($data);
        }
    }
    /**
     * 登录
     */
    public function login()
    {
        (new UserValidate)->getCheck("Login");
        $data = input("post.");
        $result = UserAuths::getByKeyUserInfo([
            "identitfier" => $data['identitfier']
        ]);
        if (!count($result)) {
            throw new ParamException(['msg' => "该用户不存在"]);
        }
        $isPas = $result[0]['creadential'] == md5($data['creadential']);
        if (!$isPas) {
            throw new ParamException(['msg' => "账号或者密码错误"]);
        }
        $id = $result[0]['user_id'];
        // 获取token
        $token = (new UserToken($id))->grantToken();
        $result[0]['token'] = $token;
        return json($result[0]);
    }
    // 发送email
    public function toEmail()
    {
        (new EmailValidate())->getCheck("ToEmail");
        $data = input("post.");
        $code = getRandChar(6);
        $key = $data['identitfier'] . $code;
        $expire_in = config("secure.code_expire_in");
        $isCache = Cache::set($key, $code, $expire_in);
        $title = "账号:{$data['identitfier']}正在进行注册操作";
        $body = "<p>验证码:<strong>{$code}</strong></p></br>将在5分钟后过期,请及时注册</p>";
        $to = $data['identitfier'];
        $fa = mailto($to , $title , $body);
        if ($isCache && $fa) {
            throw new SuccessMessage(['msg' => "发送成功"]);
        } else {
            throw new EmailException();
        }
    }
   
  
}
