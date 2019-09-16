<?php
namespace TheFairLib\Service\Swoole\Server;

interface Driver
{
    public function run($setting);

    public function send($client_id, $data);

    public function close($client_id);

    public function setProtocol($protocol);
}
