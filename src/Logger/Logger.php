<?php
/**
 * Logger.php
 *
 * @author liumingzhij26@gmail.com
 * @version 1.0
 * @copyright 2015-2025
 */

namespace TheFairLib\Logger;

use Exception;
use TheFairLib\Utility\Utility;
use TheFairLib\Dingxiang\DingxingClient;

class Logger
{
    private $_name = null;
    private static $instance = null;
    private $_type = null;
    public $path = '/tmp/logs/www/';

    public function __construct($appName)
    {
        if (!empty($appName)) {
            $this->_name = $appName;
        }
    }

    public static function Instance($appName = '')
    {
        if (empty($appName) && defined('APP_NAME')) {
            $appName = APP_NAME;
        }
        if (empty(self::$instance)) {
            self::$instance = new static($appName);
        }
        return self::$instance;
    }

    public function setPath($path)
    {
        if (!is_dir($path)) {
            throw new Exception('empty dir');
        }
        $this->path = $path;
    }

    public function info($s)
    {
        $this->_type = 'info';
        $this->output("[INFO]\t$s");
    }

    public function error($s)
    {
        $this->_type = 'error';
        $this->output("[ERROR]\t$s");
    }


    /**
     * 记录风控日志
     *
     * @param array $message
     */
    public function risk(array $message)
    {
        $log = [];
        $this->_type = 'risk';
        $riskFields = DingxingClient::$riskFields;
        foreach ($riskFields as $field) {
            if (!empty($message[$field])) {
                $log[$field] = $message[$field];
            } else {
                $log[$field] = '--';
            }
        }
        if (!empty($log)) {
            $log['create_time'] = microtime(true);
            if ($log['act_time'] == '--') {
                $log['act_time'] = $log['create_time'];
            } else {
                $log['act_time'] = is_numeric($log['act_time']) ? $log['act_time'] : strtotime($log['act_time']);
            }
            $log['log_type'] = '[' . strtoupper($this->_type) . ']';
            $log = implode('||', $log);
            $this->output($this->format($log));
        }
    }


    private function output($s)
    {
        $s = date("Y-m-d H:i:s +u") . ": $s\n";

        $dir = $this->path . str_replace('.', '/', strtolower($this->_name));
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        file_put_contents($dir . '/' . date("Y-m-d") . '_' . $this->_type . '.log', $s, FILE_APPEND | LOCK_EX);
    }


    private function format($s)
    {
        return str_replace(["\n", "\t", '"', "'", '“', '”'], "", $s) . "\n";
    }


    /**
     * 请求时间||数据类型||事件类型||响应时间||出错码||客户端IP||请求URI||请求参数||服务端IP||数据信息
     * @param $dateTime
     * @param $logType
     * @param $eventType
     * @param int $responseTime
     * @param string $serverIp
     * @param string $clientIp
     * @param string $url
     * @param array $param
     * @param int $code
     * @param string $msg
     * @return bool
     */
    public function access($dateTime, $logType, $eventType, $responseTime = 0, $serverIp = '127.0.0.1', $clientIp = '127.0.0.1', $url = 'null', array $param = [], $code = 0, $msg = '')
    {
        if (empty($msg)) {
            $msg = 'null';
        }
        if (empty($dateTime) || empty($logType) || empty($eventType)) {
            return false;
        }
        if (!in_array($logType, ['error', 'info'])) {
            return false;
        }
        $this->_type = $logType;
        $param = Utility::encode($param);
        $responseTime = round($responseTime, 4);
        $logType = '[' . strtoupper($logType) . ']';
        $log = "{$dateTime}||{$logType}||{$eventType}||{$responseTime}||{$code}||{$clientIp}||{$url}||{$param}||{$serverIp}||{$msg}";
        $this->output($this->format($log));
        return true;
    }
}
