<?php
/**
 * Cache.php
 *
 * @author ZhangHan <zhanghan@thefair.net.cn>
 * @version 1.0
 * @copyright 2015-2025 TheFair
 */
namespace TheFairLib\DB\Redis;

use TheFairLib\Db\Exception;
use TheFairLib\Config\Config;

class Cache extends Base
{
    public static function config($name){
        $config = Config::load(self::_getConfigPath());
        $conf   = $config->cache;
        if(isset($conf[$name])){
            throw new Exception('Redis Conf Error');
        }else{
            return $conf[$name];
        }
    }
}