<?php
// class A {
//     // http 状态码
//     public $code = 400;
//     // 错误消息
//     public $msg = "参数错误";
//     // 错误码
//     public $errorCode  = 10000;
//     function __construct($param)
//     {
//         var_dump($param);
//     }
// }



// class B extends A {
//     public $code = 403;
//     public $msg = "权限不足";
//     public $errorCode =  10001;
//     function __construct($param)
//     {
//         parent::__construct($param);
//     }
// }

// $b = new B(['code' => 5 , "msg" => 6]); 


// function toKey($data ,&$rdata = [])
// {
//     foreach ($data as $key => $value) {
//         if (is_array($value)) {
//             toKey($value , $rdata);
//         } else {
//             $rdata[$key] = $data[$key];
//         }
//     }

//     return   $rdata;
// }



$arr = [
    "name" => "mafeilong",
    "age" => 23,
    "arr" => [
        "gengder" => "男",
        "live" => "小说"
    ],
    "aa" => "555",
    "bbb" => [
        "l" => 666,
        "ddd" => [
            "mafeil" =>"555"
        ]
    ]
];
// var_dump(toKey($arr));
// $a = 10;
// echo "666{$arr['name']}666";

var_dump([]);



