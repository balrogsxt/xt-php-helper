<?php
namespace xt\exceptions;
/**
 * 业务异常
 * @author 幻音い
 * Class BaseException
 * @package Xt\Exception
 */
class BaseException extends \Exception{

    protected $message;
    protected $code;
    public function __construct($message = "", $code = 1, \Throwable $previous = null) {
        $this->message = $message;
        $this->code = $code;
    }

}
