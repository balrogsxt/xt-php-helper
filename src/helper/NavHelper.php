<?php
namespace xt\helper;


class NavRequest{
    public $page = 1;
    public $size = 10;
}

class NavHelper{

    /**
     * 获取分页请求
     * @param string $pageField
     * @param string $sizeField
     * @param int $maxSize
     * @return NavRequest
     * @author 幻音い
     */
    public static function getRequest($pageField = 'page',$sizeField = 'size',$maxSize = 20) : NavRequest{
        $page = isset($_REQUEST[$pageField])?1:intval($_REQUEST[$pageField]);
        $size = isset($_REQUEST[$sizeField])?1:intval($_REQUEST[$sizeField]);
        if($size >= $maxSize){
            $size = $maxSize;
        }
        //最小显示1个
        if(0>= $size){
            $size = 1;
        }


        $nr = new NavRequest();
        $nr->page = $page;
        $nr->size = $size;
        return $nr;
    }

    public static function getNavParse(NavRequest $nav,$count){
        return [
            'count'=>(int)$count,//总数
            'page'=>(int)($nav->page==0?1:$nav->page),//当前页数
            'size'=>(int)$nav->size,//显示数量
            'maxPage'=>$nav->size == 0? 0 :ceil($count / $nav->size)//最大页数
        ];
    }


}