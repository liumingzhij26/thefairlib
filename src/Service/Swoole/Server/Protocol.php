<?php
namespace TheFairLib\Service\Swoole\Server;

interface Protocol
{
    public function onStart($server, $workerId);

    public function onConnect($server, $client_id, $from_id);

    public function onReceive($server, $client_id, $from_id, $data);

    public function onClose($server, $client_id, $from_id);

    public function onShutdown($server, $worker_id);

    public function onTask($serv, $task_id, $from_id, $data);

    public function onFinish($serv, $task_id, $data);

    public function onTimer($serv, $interval);
}
