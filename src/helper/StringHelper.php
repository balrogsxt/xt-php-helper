<?php
namespace xt\helper;

use xt\exceptions\BaseException;
use xt\helper\Verify;

class StringHelper{
    /**
     * 安全的转换成小写字符串
     * @param $str
     * @return string
     */
    public static function tolower($str){
        if(Verify::isEmpty($str)){
            return $str;
        }
        return strtolower($str);
    }

    /**
     * 安全的转换为大写
     * @param $str
     * @return string
     */
    public static function toupper($str){
        if(Verify::isEmpty($str)){
            return $str;
        }
        return strtoupper($str);
    }

    /**
     * 是否包含某个字符串
     * @param $searchStr
     * @param $string
     * @return bool
     * @author 幻音い
     */
    public static function contains($searchStr,$string){
        if(strpos($string,$searchStr) !==false){
            return true;
        }else{
            return false;
        }
    }



    /**
     * 创建随机字符串
     * @param int $size
     * @return string
     */
    public static function createRandomStr($size = 16,$isMd5 = false){
        $char='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
        $text='';
        $StrLen=strlen($char)-1;
        for($i=0;$i<$size;$i++){
            $rand=rand(0,$StrLen);
            $text=$text.substr($char, $rand,1);
        }
        return $isMd5?md5($text):$text;
    }



    /**
     * 隐藏邮箱地址
     * @param $email
     * @return string
     */
    public static function hiddenEmail($email){
        if(Verify::isEmpty($email))return '';
        if(!Verify::isEmail($email))return $email;
        $email_array = explode("@", $email);
        $prevfix = (strlen($email_array[0]) < 4) ? "" : substr($email, 0, 3); //邮箱前缀
        $count = 0;
        $str = preg_replace('/([\d\w+_-]{0,100})@/', '***@', $email, -1, $count);
        return $prevfix . $str;
    }

    /**
     * 隐藏手机地址
     * @param $phone
     * @return mixed
     */
    public static function hiddenPhone($phone){
        if(!Verify::isPhone($phone)){
            return $phone;
        }
        return str_replace(substr($phone,3,4),'****',$phone);
    }

    /**
     * 隐藏身份证号
     * @param $idcard
     * @author 幻音い
     * @date: 2022/4/6 3:01 下午
     */
    public static function hiddenIdCard($idcard){
        if(strlen($idcard) != 18){
            return "******************";
        }
        return substr($idcard,0,6)."*********".substr($idcard,-3);
    }

}