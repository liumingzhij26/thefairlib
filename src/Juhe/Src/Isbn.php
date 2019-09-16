<?php
/**
 * Weather.php
 *
 * @author liumingzhij26@gmail.com
 * @version 1.0
 * @copyright 2015-2025
 */
namespace TheFairLib\Juhe\Src;

use TheFairLib\Config\Config;

class Isbn extends API
{
    private $_queryUrl = 'http://feedback.api.juhe.cn/ISBN';

    /**
     * @return Isbn
     */
    public static function Instance()
    {
        return parent::Instance();
    }

    protected function _getAppKey()
    {
        return Config::get_api_juhe('isbn.app_key');
    }

    public function getBookInfo($sub)
    {
        $param = [
            'sub' => $sub,
        ];
        return $this->_sendRequest($this->_queryUrl, $param);
    }
}
