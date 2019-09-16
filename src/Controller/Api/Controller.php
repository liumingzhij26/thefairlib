<?php
/**
 * Controller.php
 *
 * @author liumingzhij26@gmail.com
 * @version 1.0
 * @copyright 2015-2025
 */
namespace TheFairLib\Controller\Api;

use TheFairLib\Controller\Base;
use TheFairLib\Http\Response;
use TheFairLib\Http\Response\Api;

class Controller extends Base
{
    /**
     * @var Api
     */
    protected static $_responseObj = false;
    protected function init()
    {
        if (self::$_responseObj === false) {
            self::$_responseObj = new Api(new \stdClass());
        }
    }

    public function showResult($result, $msg = '', $code = '0')
    {
        self::$_responseObj->setCode($code);
        self::$_responseObj->setMsg($msg);
        self::$_responseObj->setResult($result);
        $this->_setResponse(self::$_responseObj->send());
    }

    public function showError($error, $result = array(), $code = '40001')
    {
        $this->showResult($result, $error, $code);
    }

    public function showSuccess($msg = '')
    {
        $this->showResult(['state' => true], (!empty($msg) ? $msg : 'success'));
    }
}