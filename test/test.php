<?php
require './../vendor/autoload.php';

use \xt\helper\ValidateHelper;

// $d = [
//     'a'=>[
//         'b'=>[
//             'Bbbb'=>'xxx'
//         ]
//     ]
// ];
// var_dump(\xt\helper\ArrayHelper::get($d,'','默认值','.',true));



//print_r([
//    'getMonthFirst'=>\xt\helper\TimeHelper::getMonthFirst(true),
//    'getMonthLast'=>\xt\helper\TimeHelper::getMonthLast(true),
//    'getTodayFirst'=>\xt\helper\TimeHelper::getTodayFirst(true),
//    'getTodayLast'=>\xt\helper\TimeHelper::getTodayLast(true),
//    'getYesterdayFirst'=>\xt\helper\TimeHelper::getYesterdayFirst(true),
//    'getYesterdayLast'=>\xt\helper\TimeHelper::getYesterdayLast(true),
//    'getTomorrowFirst'=>\xt\helper\TimeHelper::getTomorrowFirst(true),
//    'getTomorrowLast'=>\xt\helper\TimeHelper::getTomorrowLast(true),
//]);

//自定义类测试
try{
    $data = [
//        'in'=>'a',
//        'email'=>'i@xxx.com',
//        'name'=>'aa',
        'string'=>'',
//        'md5'=>'11111111111111111111111111111112',
//        'value'=>'test',
//        'regex'=>'a',
//        'def'=>'123'
        //    'template'=>'123'
    ];

    $validate = new ValidateHelper([
        'string'=>['字符串','number|require|cn_min:5|cn_max:10',[
            'cn_min'=>'%s长度不足%s',
            'require'=>'为空'
        ]],
//        'in'=>['不可选的内容值',['a','b','c']],
//        'email'=>['email邮箱格式不正确',ValidateHelper::EMAIL],
//        'name'=>['name不能为空',ValidateHelper::REQUIRED],
//        'int'=>['int非数字',ValidateHelper::INT],
//        //    'regex'=>['不处于正则验证规则中','/[0-9]+/'],
//        'md5'=>['自定义抛出错误',function($value){
//            if(!preg_match("/^[a-zA-Z0-9]{32}$/",$value)){
//                throw new Exception('md5格式错误');
//            }
//        }],
//        'template'=>['template not found',ValidateHelper::REQUIRED]
    ]);
    $data = $validate->validate($data);
    var_dump($data->getParam('string'));
//    var_dump($data->in);
}catch(\xt\exceptions\BaseException $e){
    echo '验证规则错误 -> '.$e->getMessage().PHP_EOL;
}