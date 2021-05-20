<?php
namespace xt\helper;

class ValidateEntity implements \ArrayAccess{
    private $params = [];

    public function getParam($name,$default = null,$filter = ''){
        if(!isset($this->params[$name])) return $default;
        $value = $this->params[$name];
        if(function_exists($filter)) return $filter($value);
        return $value;
    }

    public function getInt($name) : int{
        return $this->getParam($name,0,'intval');
    }
    public function getString($name) : string{
        return $this->getParam($name,'');
    }

    public function getFloat($name) : float{
        return $this->getParam($name,0,'floatval');
    }

    public function __set($name, $value)
    {
        $this->params[$name] = $value;
    }
    public function __get($name)
    {
        return $this->params[$name];
    }
    public function offsetExists($offset){
        return isset($this->params[$offset]);
     }
     
     public function offsetGet($offset){
        return $this->params[$offset];
     }
     
     public function offsetSet($offset, $value){
        $this->params[$offset] = $value;
     }
     
     public function offsetUnset($offset){
        unset($this->params[$offset]);
     }

}