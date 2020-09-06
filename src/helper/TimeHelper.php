<?php
namespace xt\helper;

use xt\helper\Verify;

/**
 * Class TimeHelper
 * @author 幻音い　
 * @package xt\helper
 */
class TimeHelper{


    /**
     * 将任意格式时间转换为时间戳
     * @return int
     */
    public static function toTimeStamp($time):int{
        if(is_numeric($time)){
            return intval($time);
        }else{
            return strtotime($time)==false?0:strtotime($time);
        }
    }

    /**
     * 计算时间距离
     * @param int $time
     * @param string $def
     * @return false|string
     */
    public static function toRtime($time=0,$def="暂无时间"){
        if(Verify::isEmpty($time)){
            return $def;
        }
        if(!Verify::isNumber($time)){
            return $def;
        }
        //时间转换
        $rtime = date('Y-m-d',$time);
        $diffTime = time()-$time;
        if(0>$diffTime){
            $rtime = date('Y-m-d',$time);
        }else if(60>$diffTime){
            if($diffTime == 0){
                $rtime = "刚刚";
            }else{
                //计算短时间距离当前时间过了多久,7天后直接显示日期
                $rtime = $diffTime."秒前";
            }
        }else if(60*60>$diffTime){
            $rtime = floor($diffTime/60)."分钟前";
        }else if(60*60*24>$diffTime){
            $rtime = floor($diffTime/60/60)."小时前";
        }else if(60*60*24*7>$diffTime){
            $rtime = floor($diffTime/60/60/24)."天前";
        }
        return $rtime;
    }

    /**
     * 格式化时间戳
     * @param $time
     * @param string $format
     * @param string $def
     * @return false|string
     */
    public static function formatTime($time = 'DEFAULT_CURRENT_TIME',$format='Y-m-d H:i:s',$def='暂无时间'){
        $time = $time=='DEFAULT_CURRENT_TIME'?time():$time;
        if($time==0){
            return $def;
        }
        if(Verify::isEmpty($time)){
            return $def;
        }
        if(Verify::isNumber($time)){
            return date($format,$time);
        }else{
            return date($format,strtotime($time));
        }
    }
    public static function computedTime($time){
        $m = 60;
        $h = 60 * 60;
        $d = 60 * 60 * 24;

        if ($m > $time) {
            return "{$time}秒";
        } else if ($time >= $m && $h > $time) {
            $mm = floor($time / $m);
            $ss = $time % $m;
            $sss = ($ss == 0 ? "" : $ss ."秒");
            return "{$mm}分钟{$sss}";
        } else if ($time >= $h) {
            $hh = floor($time / $h);
            $ss = ($time % $h);
            $mm = floor($ss / $m);
            $ss = ($ss % $m);

            $mmm = ($mm == 0 ? "" : $mm ."分钟");
            $sss = ($ss == 0 ? "" : $ss ."秒");
            return "{$hh}小时{$mmm}{$sss}";
        }
        return "{$time}秒";
    }

}