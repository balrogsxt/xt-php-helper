<?php
namespace xt\helper;

use xt\exceptions\BaseException;

/**
 * 字段验证器
 * Class ValidateHelper
 * @author 幻音い　
 * @package Xt\Helper
 */
class ValidateHelper{
    const NONE = 'none';//不做验证
    const URL = 'url';//http/httpsurl判断
    const EMAIL = 'email';//邮箱验证规则
    const REQUIRED = 'required';//必填
    const INT = 'int';//整数验证
    const FLOAT = 'float';//带小数的验证
    const JSON = 'json';//JSON字符串验证
    const BASE64 = 'base64';//Base64验证
    const IP = 'ip';//ipv4格式验证
    const PHONE = 'phone';//手机号码格式验证
    const DateTime = 'datetime';//Y-m-d H:i:s验证器
    const Date = 'date';//Y-m-d验证器
    const DateMonth = 'datemonth';//Y-m 验证器
    const Number = 'number';//支持验证负数数字、浮点的验证码

    /**
     * 字段=>[异常描述,验证类型(支持自定义函数)]
     * 验证如果返回false则触发异常
     * @var array
     * @author 幻音い
     */
    private $rule = [];

    /**
     * ValidateHelper constructor.
     * @param array $rule
     */
    public function __construct(array $rule = []){
        $this->rule = $rule;
    }

    /**
     * 开始验证
     * @param array $data 验证数据
     * @return ValidateEntity
     * @throws BaseException
     * @author 幻音い
     */
    public function validate(array $data) : ValidateEntity{
        try{
            $validateValue = new ValidateEntity();
            //验证指定规则
            foreach($this->rule as $field=>$item){
                if(isset($validateValue[$field]))continue;
                if(!is_array($item))throw new BaseException('验证器参数错误,第二个参数应为Array');
                if(!(count($item) >= 2))throw new BaseException('验证器参数错误,第二个参数参数不足');
                $errMsg = $item[0];
                $validate = $item[1];
                $validateMessage = [];//特定字符串验证器自定义文字
                if(count($item) >= 3){
                    $validateMessage = is_array($item[2])?$item[2]:[];
                }
                $value = Verify::isEmpty($data[$field]??'') ? '':$data[$field];
                $this->verify($data,$field,$value,$validate,$errMsg,$validateMessage);
                $validateValue->$field = $value;
            }
            //验证直接的数据
            foreach($data as $field=>$value){
                if(isset($validateValue[$field]))continue;
                //判断是否有验证规则
                if(!isset($this->rule[$field])){
                    //跳过验证
                    $validateValue->$field = $value;
                    continue;
                }
                $item = $this->rule[$field];
                if(!is_array($item))throw new BaseException('验证器参数错误,第二个参数应为Array');
                if(!(count($item) >= 2))throw new BaseException('验证器参数错误,第二个参数参数不足');
                $validateMessage = [];//特定字符串验证器自定义文字
                if(count($item) >= 3){
                    $validateMessage = is_array($item[2])?$item[2]:[];
                }
                $errMsg = $item[0];
                $validate = $item[1];

                $this->verify($data,$field,$value,$validate,$errMsg,$validateMessage);

                //记录验证成功的数据
                $validateValue->$field = $value;
            }
            return $validateValue;
        }catch(\Exception $e){
            echo $e->getMessage().$e->getLine().$e->getFile().$e->getTraceAsString();
            return null;
        }
    }

    private function verify($data,$field,$value,$validate,$errMsg,$validateMessage = []){
        if(!isset($data[$field])) {
            if(Verify::isEmpty($errMsg)) $errMsg = "缺少「{$field}」参数";
            throw new BaseException($errMsg);
        }else{
            if(Verify::isEmpty($errMsg)){
                if(is_string($validate)){
                    $errMsg = "{$field}不是有效的{$validate}";
                }else{
                    $errMsg = "{$field}参数验证无效";
                }
            }
        }


        $value = Verify::isEmpty($data[$field]) ? '':$data[$field];

        //自定义验证器
        if(is_callable($validate)){
            try{
                if($validate($value) === false){//如果返回false则抛出错误
                    throw new BaseException($errMsg);
                }
            }catch(\Exception $e){//抛出异常则可自定义描述
                throw new BaseException($e->getMessage());
            }
        }

        //根据指定类型已定义验证器
        switch($validate){
            case self::REQUIRED://验证字段值是否如果为空则抛出异常
                if(Verify::isEmpty($value))throw new BaseException($errMsg);
                break;
            case self::EMAIL://验证字段值如果不是邮箱则抛出错误
                if(!Verify::isEmail($value))throw new BaseException($errMsg);
                break;
            case self::FLOAT://如果不是整数或不是带小数数字则抛出错误
                if(Verify::isEmpty($value) || !preg_match("/^([0-9]+)\.?([0-9]+)?$/",$value))throw new BaseException($errMsg);
                break;
            case self::INT://如果不是整数,则抛出错误
                if(Verify::isEmpty($value) || !preg_match("/^[0-9]+$/",$value))throw new BaseException($errMsg);
                break;
            case self::Number:
                if(!is_numeric($value))throw new BaseException($errMsg);
                break;
            case self::URL:
                if(!Verify::isUrl($value))throw new BaseException($errMsg);
                break;
            case self::BASE64:
                if(!Verify::isBase64($value))throw new BaseException($errMsg);
                break;
            case self::JSON:
                if(!Verify::isJson($value))throw new BaseException($errMsg);
                break;
            case self::IP:
                if(!Verify::isIP($value))throw new BaseException($errMsg);
                break;
            case self::PHONE:
                if(!Verify::isPhone($value))throw new BaseException($errMsg);
                break;
        }

        //根据验证数据类型定义的验证器
        if(is_array($validate)){
            //in array 验证器
            if(!in_array($value,$validate))throw new BaseException($errMsg);
        }else if(is_string($validate) && strlen($validate) >= 2 && substr($validate,0,1) == '/' && substr($validate,-1)){ //正则验证器
            if(!preg_match($validate,$value)) throw new BaseException($errMsg);
        }else if(is_string($validate)){
            //特定验证器,多个以|隔开
            //最小英文字母: min:整数数字
            //最大英文字母: max:整数数字
            //最小中文字数: cn_min:整数数字
            //最大中文字数: cn_max:整数数字
            $validateList = explode("|",$validate);
            foreach($validateList as $rule){
                $ruleArr = explode(":",$rule);
                $param = 'null';
                if(count($ruleArr) == 0)continue;
                if(count($ruleArr) >= 1) $ruleType = $ruleArr[0];
                if(count($ruleArr) >= 2) $param = $ruleArr[1];
                $ruleErrMsg = $validateMessage[$ruleType]??"";
                switch($ruleType){
                    case 'require':
                        if(Verify::isEmpty($value)){
                            if(Verify::isEmpty($ruleErrMsg)) $ruleErrMsg = "%s不能为空";
                            throw new BaseException(sprintf($ruleErrMsg,$errMsg));
                        }
                        break;
                    case 'min':
                        if($param > strlen($value)){
                            if(Verify::isEmpty($ruleErrMsg)){
                                $ruleErrMsg = "%s最少%d个字符";
                            }
                            throw new BaseException(sprintf($ruleErrMsg,$errMsg,$param));
                        }
                        break;
                    case 'max':
                        if(strlen($value) > $param){
                            if(Verify::isEmpty($ruleErrMsg)){
                                $ruleErrMsg = "%s最多%d个字符";
                            }
                            throw new BaseException(sprintf($ruleErrMsg,$errMsg,$param));
                        }
                        break;
                    case 'cn_min':
                        if($param > mb_strlen($value)){
                            if(Verify::isEmpty($ruleErrMsg)){
                                $ruleErrMsg = "%s最少%d个文字或字符";
                            }
                            throw new BaseException(sprintf($ruleErrMsg,$errMsg,$param));
                        }
                        break;
                    case 'cn_max':
                        if(mb_strlen($value) > $param){
                            if(Verify::isEmpty($ruleErrMsg)){
                                $ruleErrMsg = "%s最多%d个文字或字符";
                            }
                            throw new BaseException(sprintf($ruleErrMsg,$errMsg,$param));
                        }
                        break;
                }
            }
        }
    }

}
