<?php
namespace app\api\validate;
use think\Validate;
use app\lib\exception\ParamException;

use think\facade\Request;
class BaseValidate extends Validate {
    /**
     * 验证  
     * @param 场景名
     */
    public function getCheck($name = "") {
        $param = Request::param();
        if($name) {
            $result =
            $this->batch()->scene($name)->check($param);
        }else {
            $result = $this->batch()->check($param);
        }
        if(!$result) {
            throw new ParamException();
        }else {
            return true;
        }
        
    }

}