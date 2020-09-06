<?php
namespace xt\helper;
/**
 * Class FileHelper
 * @author 幻音い　
 * @package xt\helper
 */
class FileHelper{

    /**
     * KB为单位的转字符串
     * @param int $kb
     * @return string
     */
    public static function computeSize($kb=0){
        $kb = round($kb,2);

        $mb = 1024;
        $gb = $mb*1024;
        $tb = $mb*1024;
        if($mb>$kb){
            return "{$kb}KB";
        }else if($kb>=$mb&&$gb>$kb){
            return number_format(($kb/$mb),2,'.','')."MB";
        }else if($kb>=$gb&&$tb>$kb){
            return number_format(($kb/$gb),2,'.','')."GB";
        }else if($kb>$tb){
            return number_format(($kb/$tb),2,'.','')."TB";
        }else{
            return number_format(($kb/$mb),2,'.','')."MB";
        }
    }
}