<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use app\lib\exception\EmailException;

function getRandChar($max) {
    $str = "";
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $len = strlen($strPol) -1;
    for($i = 0 ; $i < $max ; $i++){
        $str .= $strPol[rand(0 , $len)];
    }
    return $str;

}



// 是email和phone return true  还是第三方登录  false
function isLoginType($data) {
    if ($data['identity_type'] == "email" ||  $data['identity_type'] == "phone") {
        return true;
    } else {
        return false;
    }
}



function mailto($to, $title, $content)
{
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //服务器配置
        $mail->CharSet = "UTF-8";                     //设定邮件编码
        $mail->SMTPDebug = 0;                        // 调试模式输出
        $mail->isSMTP();                             // 使用SMTP
        $mail->Host = '';                // SMTP服务器
        $mail->SMTPAuth = true;                      // 允许 SMTP 认证
        $mail->Username = '';                // SMTP 用户名  即邮箱的用户名
        $mail->Password = '';             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
        $mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议
        $mail->Port = 465;                            // 服务器端口 25 或者465 具体要看邮箱服务器支持

        $mail->setFrom('', 'Mailer');  //发件人
        $mail->addAddress($to);  // 收件人
        //Content
        $mail->isHTML(true);                                  // 是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
        $mail->Subject = $title;
        $mail->Body    = $content;
        $mail->AltBody = '如果邮件客户端不支持HTML则显示此内容';

        return $mail->send();
    } catch (Exception $e) {
        // exception($mail->ErrorInfo, 1001);
        throw new EmailException([
            "msg" => $mail->ErrorInfo,
        ]);
    }
    return true;
}

/**
 * 
 */
function toKey($data ,  $rdata = []) {
    
    foreach ($data as $key => $value) {
       if(is_array($value)){
           toKey($value ,$rdata);
       }else {
           $rdata[$key] = $data[$key];
       }
    }

    return   $rdata;
}