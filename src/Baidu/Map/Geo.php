<?php
/**
 * Api.php
 *
 * @author liumingzhij26@gmail.com
 * @version 1.0
 * @copyright 2015-2025
 */
namespace TheFairLib\Baidu\Map;

use TheFairLib\Utility\Utility;

class Geo extends Base{
    protected function _getApiUrl(){
        return 'http://api.map.baidu.com/geocoder/v2/';
    }

    public function getLocationByAddress($address){
        return $this->_sendRequest(['address' => $address = Utility::utf8SubStr($address, 33)]);
    }

    public function getAddressByLocation($lat, $lng){
        return $this->_sendRequest(['location' => "{$lat},{$lng}"]);
    }
}