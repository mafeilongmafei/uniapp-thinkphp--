<?php

namespace app\api\model;

use think\facade\Cache;
use GatewayClient\Gateway;
use app\api\validate\SocketValidate;
use app\api\service\Token;
class Users extends BaseModel
{
  public function items()
  {
    return $this->hasOne("UserAuths", "user_id", "id");
  }


  public  function saveData($data)
  {
    if (isLoginType($data)) {
      $data['creadential'] = md5($data['creadential']);
    }
    $this->allowField(true)->save($data);
    $result = $this->allowField(true)->items()->save($data);
    // 没有添加成功 删除前面的user记录 保持事务一致性
    if (!$result) {
      $this->delete();
    }
    return $result;
  }
  // 昵称重复不
  public  static  function isNicknameRepeat($data)
  {
    if (isset($data['nickname'])) {
      $result = self::hasWhere("items" , function($query) use($data){
        $query->where([
          "nickname" => $data['nickname'],
          "identity_type" => ["email", "phone"]
        ]);
      })->select();


      return count($result) ? true : false;
    }
  }
  // 查询用户信息
  public static function ByIdUserInfo($arr) {
    return self::where("id", "in" ,$arr)->select();
  }

  // 验证code
  public static function validateEmailCode($data)
  {
    $key = $data['identitfier'].$data['code'];
    $code = Cache::get($key);
    return $code;
  }
  public static function  bindUidAndClinetId ($data){
    $socketValida = new SocketValidate();
    $uid = Token::getCurrentTokenVar("uid") - 0;
    switch ($data['type']) {
      // 初始化
      case 'init':
        $socketValida->getCheck("BindClientandUid");
        Gateway::bindUid($data['client_id'] , $uid);
        //向所有人发送上线  这里我是做只有要人上线 所有人第一时间知道,不然不需要
        Gateway::sendToAll(json_encode(array(
            "type" => "sconnect"
        )));
        break;
        // 加入群组
      case 'group':
        $socketValida->getCheck("BindClientandGroupId");
        Gateway::joinGroup($data['client_id'] , $data["group_id"]);
        break;
      case "toMsg":
        $socketValida->getCheck("ToUserMsg");
        $user = self::ByIdUserInfo([$uid]);
        $data['user'] = $user;
        Gateway::sendToUid($data["touid"], json_encode($data));
      break;
      default:
        # code...
        break;
    }

  }  
  // 获取所有在线用户
  public static function getOnlineAllUser() {
    $arr = array_values(Gateway::getAllUidList());
    $len = count($arr);
    // if($len > 0 ){
    //   $onlineArr = array_keys($arr);
    // }else {
    //   $onlineArr = [];
    // }
    
    return $len ? self::ByIdUserInfo($arr) : [];
  }
}
