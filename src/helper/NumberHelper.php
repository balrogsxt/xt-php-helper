<?php
namespace xt\helper;

class NumberHelper{

    /**
     * 浮点类型转换
     * @param $number
     * @param int $decimals
     * @return string
     */
    public static function floatFormat($number,$decimals = 2){
        return number_format($number,$decimals,".","");
    }

}
