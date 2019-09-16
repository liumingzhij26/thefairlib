<?php
/**
 * Interface.php
 *
 * @author liumingzhij26@gmail.com
 * @version 1.0
 * @copyright 2015-2025
 */
namespace TheFairLib\Mobile\Push\Ext;

interface PushInterface
{
    public function sendPushToSingleDevice($deviceToken, $platform, $title, $message, $link, $badge);

    public function sendPushToDeviceList($deviceTokenList, $platform, $title, $message, $link, $badge);
}
