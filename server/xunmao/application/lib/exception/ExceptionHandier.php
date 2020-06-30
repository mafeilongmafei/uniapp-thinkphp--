<?php
namespace app\lib\exception;
use think\exception\Handle;
use think\facade\Request;

class ExceptionHandier extends Handle {
    private $code;
    private $msg;
    private $errorCode;
    public function render(\Exception $e) {
        if ($e instanceof BaseException) {
            // 如果是自定义的异常类
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }else {
            //不是异常类 那就是运行过程中产生的错误
            if(config("app_debug")) {
                return parent::render($e);
            }else {
                $this->code = 500;
                $this->msg = "服务器内部错误";
                $this->errorCode = 999;
            }
        }
        $result = [
            "msg" => $this->msg,
            "error_code" =>  $this->errorCode,
            "request_url" => Request::url()
        ];
        return json($result);

    }

}

