<?php
namespace xt\helper;
class Verify{
    /**
     * @param $json
     * @return bool
     */
    public static function isJson($json){
        try{
            if(self::isEmpty($json))return false;
            if(is_null($json))return false;
            if(is_array($json))return false;
            if(is_numeric($json))return false;
            if(is_bool($json))return false;
            if(is_array(json_decode($json,true)))return true;return false;
        }catch(\Exception $e){
            return false;
        }
    }
    /**
     * 判断是否是IP地址
     */
    public static function isIP($ip){
        if(preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/",$ip)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $number
     * @return bool|false|int
     */
    public static function isInt($number){
        return self::isRegex($number,"/^[0-9]+$/");
    }

    /**
     * @param $number
     * @return bool
     */
    public static function isFloat($number){
        if(self::isEmpty($number))return false;
        return is_numeric($number);
    }

    /**
     * @param $base64
     * @return bool
     */
    public static function isBase64($base64){
        if(!self::isEmpty($base64)){
            $base64 = strtr($base64,array(' '=>'+','\r\n'=>'','\n'=>'','\r'=>''));
            if ($base64==base64_encode(base64_decode($base64)))return true;return false;
        }else{
            return false;
        }
    }
    /**
     * @param $url
     * @return bool
     */
    public static function isUrl($url){
        if(preg_match("/^((https|http|ftp|rtsp|mms)?:\/\/)[^\s]+$/",$url))return true;return false;
    }

    /**
     * @param $filePath
     * @return bool
     */
    public static function isFile($filePath){
        if(self::isEmpty($filePath))return false;
        return is_file(".".$filePath);
    }
    /**
     * @param $str
     * @return bool
     */
    public static function isEmpty($str){
        if(is_string($str) || is_numeric($str)){
            if(strlen($str) > 0)return false;
        }
        if(empty($str))return true;
        if($str=="")return true;
        if(is_string($str)){
            if(strlen($str)==0)return true;
        }
        return false;
    }

    /**
     * 是否属于mongodb的objectid格式
     * @param $data
     * @return bool
     * @author 幻音い
     */
    public static function isMongoObjectId($data){
        if(self::isEmpty($data)){
            return false;
        }
        if(preg_match("/^[a-zA-z0-9]{24}$/",$data)){
            return true;
        }else{
            return false;
        }
    }
    public static function toString($data){
        if(self::isEmpty($data))return "";
        return $data;
    }

    /**
     * @param $str
     * @return bool
     */
    public static function isNumber($str){
        try{
            if(is_null($str))return false;
            if(preg_match("/^[0-9]+$/",$str)){
                return true;
            }
            return false;
        }catch(\Exception $e){
            return false;
        }
    }


    /**
     * @param $mobile
     * @return string
     */
    public static function isPhone($mobile) {
        if(self::isEmpty($mobile))return false;
        return preg_match('/^1[3457869]\d{9}$/', $mobile ? $mobile : '') ? $mobile : '';
    }

    /**
     * @param $email
     * @return bool
     */
    public static function isEmail($email){
        if(self::isEmpty($email))return false;
        if(preg_match("/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\\.[a-zA-Z0-9_-]+)+$/",$email))return true;return false;
    }

    /**
     * @param $str
     * @param $regex
     * @return bool|false|int
     */
    public static function isRegex($str,$regex){
        if($str==null)return false;
        try{
            return preg_match($regex,$str);
        }catch(\Exception $e){
            return false;
        }
    }

    /**
     * @param $data
     * @return string
     */
    public static function filter($data){
        return htmlspecialchars($data);
//        return addslashes(strip_tags(trim($data)));
    }
    public static function filterDecode($data){
        return htmlspecialchars_decode($data);
    }



}
