<?php
/**
 * Storage.php
 *
 * @author liumingzhij26@gmail.com
 * @version 1.0
 * @copyright 2015-2025
 */
namespace TheFairLib\DB\Redis;

use TheFairLib\Db\Exception;
use TheFairLib\Config\Config;

class Storage extends Base
{
    public function config($name){
        $config = Config::get_db_redis();
        $conf   = $config['storage'];
        if(!isset($conf[$name])){
            throw new Exception('Redis Conf Error');
        }else{
            return $conf[$name];
        }
    }

//    public static function getInstance($name = 'default'){
//        if (!isset(self::$instance[$name])) {
//            $base = new self();
//            self::$instance[$name] = $base->getRedisInstance($name);
//        }
//
//        return self::$instance[$name];
//    }

    protected function _init(){

    }
}