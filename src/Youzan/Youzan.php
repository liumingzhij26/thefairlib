<?php
/**
 * Youzan.php
 *
 * @author liumingzhi
 * @version 1.0
 * @copyright 2015-2015
 * @date 16/4/28 下午2:30
 */
namespace TheFairLib\Youzan;

use TheFairLib\Config\Config;
use TheFairLib\Youzan\lib\KdtApiClient;
use Yaf\Exception;

class Youzan
{
    public static $instance;

    private static $client = null;

    /**
     * @return Youzan
     * @throws Exception
     */
    public static function Instance()
    {
        $class = get_called_class();
        if (empty(self::$instance)) {
            self::$instance = new $class();
            $config = Config::get_api_youzan();
            if (empty($config)) {
                throw new Exception('error youzan appKey');
            }
            self::$client = new KdtApiClient($config['app_id'], $config['secret']);
        }
        return self::$instance;
    }

    public function get($method, $params = [])
    {
        return self::$client->get($method, $params);
    }

    public function post($method, $params = [], $files = [])
    {
        return self::$client->post($method, $params, $files);
    }
}
