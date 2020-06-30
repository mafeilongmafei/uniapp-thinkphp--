<?php

/**
 * User: jung
 * Date: 2018/6/25
 * Time: 10:54
 */

namespace app\api\behavior;

use think\Response;
use think\Request;
class Header
{
    /**
     * @param $dispatch
     * 设置跨域请求【暂时设置为全部都可以请求】
     */
    public  function run($response)
    {
        // 简单请求直接返回 'Access-Control-Allow-Origin' => $hotName,
        // 复杂请求需要多设置一个header  Access-Control-Allow-Methods
        
        $hotName = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN']: "*";
        // 设置响应头
        $headers = [
            'Access-Control-Allow-Origin' => $hotName,
            "Access-Control-Allow-Methods"=> "POST, GET, OPTIONS, DELETE",
            'Access-Control-Allow-Credentials' => 'true',
            // 实际请求中允许携带的首部字段。
            'Access-Control-Allow-Headers' => '*'

        ];
        if($response instanceof Response) {
            return $response->header($headers);
         
        }

        // if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        //     return Response::create()->send();
        // }
       


           
    }
    
}
