<?php
/**
 * Base.php
 *
 * @author liumingzhi
 * @version 1.0
 * @copyright 2015-2015
 * @date 16/4/14 下午2:23
 */

namespace TheFairLib\Queue;

use TheFairLib\Queue\Kafka\Kafka;

class Queue
{
    public static $instance;

    private $_server = 'kafka';

    /**
     * @return Queue
     */
    public static function Instance()
    {
        $class = get_called_class();
        if (empty(self::$instance)) {
            self::$instance = new $class();
        }
        return self::$instance;
    }

    /**
     * @return Kafka
     * @throws \Exception
     */
    public function getApplication()
    {
        switch ($this->_server) {
            case 'kafka':
                return Kafka::Instance();
                break;
        }
        throw new \Exception('error ', $this->_server);
    }
}
