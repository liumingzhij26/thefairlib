<?php
/**
 * Push.php
 *
 * @author liumingzhij26@gmail.com
 * @version 1.0
 * @copyright 2015-2025
 */
namespace TheFairLib\Mobile\Push;

use TheFairLib\Mobile\Push\Ext\Getui\GeTui;
use TheFairLib\Mobile\Push\Ext\Jpush\Jpush;

class Push
{
    public static $instance;

    /**
     *
     * @param string $pushService
     * @param string $configLabel
     * @return Jpush|GeTui
     * @throws \Exception
     */
    public function getPushWork($pushService = 'getui', $configLabel = 'system_conf')
    {
        switch ($pushService) {
            case 'getui':
                $class = new GeTui($configLabel);
                break;
            case 'jpush':
                $class = new Jpush($configLabel);
                break;
            default:
                throw new \Exception('push service not exist');
        }
        return $class;
    }

    public static function Instance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

//    public function sendPushToSingle
}
