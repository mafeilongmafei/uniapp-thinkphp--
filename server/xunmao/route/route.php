<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::rule("login" , "api/User/login" , "post|options")->allowCrossDomain();
Route::rule("registered" , "api/User/registered" , "post|options")->allowCrossDomain();
Route::rule("getToken" , "api/Token/getToken" , "post|options")->allowCrossDomain();
Route::rule("index" , "api/User/index" , "post|get|delete|options")->allowCrossDomain();
Route::rule("toEmail" , "api/User/toEmail" , "post|get|delete|options")->allowCrossDomain();
Route::rule("addUserGroup" , "api/Socke/addUserGroup" , "post|get|delete|options")->allowCrossDomain();
Route::rule("ByTokenOnlineUser" , "api/Socke/ByTokenOnlineUser" , "post|get|delete|options")->allowCrossDomain();
