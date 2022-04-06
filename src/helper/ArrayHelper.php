<?php
namespace xt\helper;
use xt\exceptions\BaseException;

/**
 * Class ArrayHelper
 * @author 幻音い　
 * @package xt\helper
 */
class ArrayHelper{

    /**
     * 按照字符串分割获取数组值
     * @param array $oldArray 原始数组
     * @param string $path 路径
     * @param null $default 默认值
     * @param string $split 分割字符
     * @param bool $tolowerCase 是否转小写判断
     * @return array|mixed|null
     * @author 幻音い
     */
    public static function get(array $oldArray,string $path,$default = null,$split = '.',$tolowerCase = true){
        try{
            $array = $oldArray;
            if($tolowerCase){
                $path = StringHelper::tolower($path);//转小写
                $array = array_change_key_case($oldArray,CASE_LOWER);//数组转小写
            }
            $pathList = explode($split,$path);
            $tmpValue = $array;
            $oldValue = $oldArray;
            foreach($pathList as $f){
                if(isset($tmpValue[$f])){
                    $oldValue = $tmpValue = $tmpValue[$f];
                    if(is_array($tmpValue) && $tolowerCase){ //子数组转小写
                        $tmpValue = array_change_key_case($tmpValue,CASE_LOWER);//数组转小写
                    }
                }else{
                    $oldValue = $tmpValue = $default;
                    break;
                }
            }
            return $oldValue;
        }catch(\Exception $e){
            return $default;
        }
    }

    /**
     * 判断是否有这个键
     * @param array $array
     * @param string $path
     * @param string $split
     * @return bool
     * @author 幻音い
     */
    public static function has(array $array,string $path,$split = '.'){
        if(!is_null(self::get($array,$path,null,$split,true))){
            return true;
        }else{
            return false;
        }
    }



}