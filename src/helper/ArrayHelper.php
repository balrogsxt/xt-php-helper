<?php
namespace xt\helper;
/**
 * Class ArrayHelper
 * @author 幻音い　
 * @package xt\helper
 */
class ArrayHelper{


    public static function arrayResult($array,$callback){
        return $callback($array);
    }
    public static function arrayCallback($array,$callback){
        $data = [];
        foreach($array as $k=>$v){
            $data[$k] = $callback($k,$v);
        }
        return $data;
    }


    public static function hasArrayPath($array,$path,$split='.'){
        if(self::getPath($array,$path,null,$split)==null){
            return false;
        }else{
            return true;
        }
    }

    /**
     * 点结构分割查询数组
     * @param $array
     * @param $path
     * @param null $default
     * @param string $split
     * @return array|null
     */
    public static function getArrayPath($array,$path,$default=null,$split='.'){
        $Config = array_change_key_case($array,CASE_LOWER);
        if(is_null($path))return $Config;
        if(empty($path))return $Config;
        $name = strtolower($path);
        if(is_null($split))$split=".";
        if(empty($split))$split=".";
        if(!strpos($name,$split)){
            if(array_key_exists($name,$Config)){
                if(!isset($Config[$name]))return $default;
                return $Config[$name];
            }
            return $default;
        }
        $Config = array_change_key_case($Config,CASE_LOWER);
        //支持数组 . 分割获取
        $list = explode($split,$name);
        $field = current($list);
        if(!array_key_exists($field,$Config)){
            return $default;
        }
        /**
         * ??????? nmd wdnm あれ
         */
        $tmpData = $data = $default;
        $array = $Config[current($list)];//得到数组
        if(is_array($array)){
            $array = array_change_key_case($array,CASE_LOWER);
            foreach($list as $key){
                if(empty($key))break;
                if(strtolower(current($list))!=strtolower($key)){
                    if(!isset($array[strtolower($key)])) {
                        break;
                    }else if(is_array($array[strtolower($key)])){
                        $data = array_change_key_case($array[strtolower($key)],CASE_LOWER);
                        $tmpData = true;
                        $array = array_change_key_case($array[strtolower($key)],CASE_LOWER);
                    }else{
                        $data = $array[strtolower($key)];
                        $tmpData = true;
                        $array = $array[strtolower($key)];
                        break;
                    }
                }
            }
        }
        if(is_null($tmpData)){
            return $default;
        }else{
            return $data;
        }
    }



}