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
       'in'=>'a',
       'email'=>'i@xxx.com',
       'name'=>'aa',
       'int'=>'1',
       'md5'=>'11111111111111111111111111111112',
       'value'=>'test'
   ];

   $validate = new ValidateHelper([
       'in'=>['不可选的内容值',['a','b','c']],
       'email'=>['email邮箱格式不正确',ValidateHelper::EMAIL],
       'name'=>['name不能为空',ValidateHelper::REQUIRED],
       'int'=>['int非数字',ValidateHelper::INT],
       'md5'=>['自定义抛出错误',function($value){
           if(!preg_match("/^[a-zA-Z0-9]{32}$/",$value)){
               throw new Exception('md5格式错误');
           }
       }]
   ]);
   $data = $validate->validate($data);
   var_dump($data->getParam('md5'));
//    var_dump($data->in);
}catch(\xt\exceptions\BaseException $e){
   echo 'error -> '.$e->getMessage();
}