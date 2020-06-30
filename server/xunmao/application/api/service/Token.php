<?php
namespace app\api\service;

use think\Exception;
use think\facade\Cache;
use think\facade\Request;
use app\lib\exception\TokenExcepction;
use app\lib\exception\ForbiddenException;
use app\lib\enum\ScopeEnum;


class Token {
    public static function generdateToken() {
        $randChars = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //盐
        $tokenSalt = config('secure.token_salt');
        return md5($tokenSalt . $randChars . $timestamp);
        
    }
    // 从缓存中获取token value对应的信息
    public static function getCurrentTokenVar($key) {
        $token = Request::header("token");
        $vars = Cache::get($token);
        if(!$vars) {
            throw new TokenExcepction();
        }
        $vars = json_decode($vars , true);
        if(!isset($vars[$key])) {
            throw new  Exception("尝试获取的token变量不存在");
            
        }
        return $vars[$key];
    }
    public static function getCurrentUid()
    {
        $uid = self::getCurrentTokenVar("uid");
        return $uid;
    }

    //用户和cms管理员可以访问的权限  在需要管理访问的地方加上这个方法
    public static function needPrimaryScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope >= ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }
    //只有用户可以访问的权限
    public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope == ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }
    

}