<?php
/**
 * DataModel.php
 *
 * @author ZhangHan <zhanghan@thefair.net.cn>
 * @version 1.0
 * @copyright 2015-2025 TheFair
 */
namespace TheFairLib\Model;

use Illuminate\Database\Capsule\Manager;
use TheFairLib\Config\Config;
use TheFairLib\DB\Redis\Cache;
use TheFairLib\DB\Redis\Storage;
use TheFairLib\Utility\Utility;

abstract class DataModel
{

    protected $server = 'default';

    static protected $instance;

    static protected $cache;

    static protected $db = [];

    static protected $dbName = 'default';

    protected static $_params;

    /**
     * 不含前缀和sharding后缀的表名
     * 例如taoo_user_0:
     * $_tableName = 'user';
     *
     * @var string
     */
    protected $_tableName = null;

    protected $_shardingKey = null;

    protected $_shardingNum = null;

    /**
     * @var Manager
     */
    static protected $capsule;

    static public function Instance()
    {
        $class = get_called_class();
        if (empty(self::$instance[$class])) {
            self::$instance[$class] = new $class();
        }
        self::$_params = Utility::get_requset_params();
        return self::$instance[$class];
    }


    /**
     * 存储
     * @return \Redis
     */
    protected function Storage()
    {
        return Storage::getInstance($this->server);
    }

    /**
     * 缓存
     * @return \Redis
     */
    protected function Cache()
    {
        return Cache::getInstance($this->server);
    }

    /**
     * @param $type
     * @param $dataType
     * @return string
     * @throws Exception
     */
    protected function getPrefix($type, $dataType)
    {
        $productPrefix = '';
        if(defined('PRODUCT_NAME')){
            $productPrefix = PRODUCT_NAME.'#';
        }
        if (!in_array($type, ['Cache', 'Storage']) || !in_array($dataType, ['key', 'hash', 'set', 'zset', 'list', 'string'])) {
            throw new Exception('Redis cahce prefix config error!');
        }
        return $productPrefix.$type . '#' . Config::get_app('phase') . '#' . $dataType . '#';
    }

    /**
     * @param $dbName
     * @return \Illuminate\Database\Connection
     * @throws Exception
     */
    protected function db($dbName = '')
    {
        if (empty($dbName)) {
            $dbName = static::$dbName;
        }

        if (empty(self::$capsule)) {
            self::$capsule = new Manager();
            self::$capsule->setAsGlobal();
        }

        if (!in_array($dbName, self::$db)) {
            $conf = Config::get_db_mysql($dbName);
            if (empty($conf)) {
                throw new Exception('sys_db:' . $dbName);
            }

            self::$capsule->addConnection($conf, $dbName);
            self::$capsule->setAsGlobal();
            self::$db[] = $dbName;
        }
        $tmp = self::$capsule;
        return $tmp::connection($dbName);
    }

    /**
     * 获取辅库连接
     *
     * @param string $dbName
     * @return \PDO
     * @throws Exception
     */
    protected function readDb($dbName = ''){
        return $this->db($dbName)->getReadPdo();
    }

    /**
     * 获取主库连接
     *
     * @param string $dbName
     * @return \PDO
     * @throws Exception
     */
    protected function writeDb($dbName = ''){
        return $this->db($dbName)->getPdo();
    }

    /**
     * 获取数据库uuid
     *
     * @return int uuid
     * @throws Exception
     */
    protected function _getUuid()
    {
        $ret = $this->db('default')->select('select uuid_short() as uuid');
        $uuid = $ret[0]['uuid'];
        if (!empty($uuid)) {
            return $uuid;
        } else {
            throw new Exception('uuid error', [], 50000);
        }
    }

    protected function _getTableName($shardingKey = null, $tableName = '')
    {
        $tableName = !empty($tableName) ? $tableName : $this->_tableName;
        if (empty($tableName) || ($shardingKey !== null && empty($this->_shardingNum))) {
            throw new Exception('M Conf Err');
        }
        return $this->_tableName . ($shardingKey !== null ? '_' . $this->_getShardingTableNum($shardingKey) : '');
    }

    private function _getShardingTableNum($shardingKey)
    {
        return (int)$shardingKey % $this->_shardingNum;
    }

    /**
     * 分页获取数据的方法
     *
     * @param string $dbName 数据库名称
     * @param string $tableName 表名
     * @param string|array $where where子句
     * @param array $fields 需要查询的数据库字段数组
     * @param int $page 当前请求页数
     * @param string $order 排序规则，如：'uid desc'
     * @param int $itemPerPage 每页返回多少行数据
     * @return array 结果集
     * @throws Exception
     */
    protected function _getItemListByPage($dbName, $tableName, $where, $fields, $page = 1, $order = '', $itemPerPage = 20)
    {
        $shardingKey = $this->_shardingKey === null ? '*' : $this->_shardingKey;
        $sqlObj = $this->db($dbName)->table($tableName);
        if (!empty($where)) {
            $sqlObj = is_array($where) && count($where) == 2 ? $sqlObj->whereRaw($where[0], $where[1]) : $sqlObj->whereRaw($where);
        }
        $total = $sqlObj->count($shardingKey);
        $itemPerPage = min(50, $itemPerPage);
        $pageCount = ceil($total / $itemPerPage);
        if (!empty($total)) {
            $sqlObj = $this->db($dbName)->table($tableName);
            if (!empty($where)) {
                $sqlObj = is_array($where) && count($where) == 2 ? $sqlObj->whereRaw($where[0], $where[1]) : $sqlObj->whereRaw($where);
            }
            if (!empty($order)) {
                $sqlObj = $sqlObj->orderByRaw($order);
            }
            $ret = $sqlObj->limit($itemPerPage)->offset(($page - 1) * $itemPerPage)->get($fields);
        } else {
            $ret = [];
        }

        return [
            'item_list' => $ret,
            'item_count' => $total,
            'item_per_page' => $itemPerPage,
            'page' => $page,
            'page_count' => $pageCount,
        ];
    }

    /**
     * 从缓存中获取数据列表
     *
     * @param $listCacheKey
     * @param $lastItemId
     * @param string $order
     * @param int $itemPerPage
     * @param bool $withScores
     * @return array
     */
    protected function _getItemListByPageFromCache($listCacheKey, $lastItemId, $order = 'desc', $itemPerPage = 20, $withScores = false)
    {
        $total = $this->Storage()->zCard($listCacheKey);
        $itemPerPage = min(50, $itemPerPage);
        $pageCount = ceil($total / $itemPerPage);
        $list = [];
        if($total){
            if(!empty($lastItemId)){
                $start = $order == 'desc' ? $this->Storage()->zRevRank($listCacheKey, $lastItemId) : $this->Storage()->zRank($listCacheKey, $lastItemId);
                $start += 1;
            }else{
                $start = $lastItemId;
            }

            $end = $start + $itemPerPage - 1;
            $funcName = $order == 'desc' ? 'zRevRange' : 'zRange';

            if($withScores === true){
                $list = $this->Storage()->$funcName($listCacheKey, $start, $end, 'WITHSCORES');
            }else{
                $list = $this->Storage()->$funcName($listCacheKey, $start, $end);
            }
            if(!empty($list)){
                $lastItemId = end($list);
                if($withScores === true){
                    $lastItemId = key($list);
                }
            }
        }

        return [
            'item_list' => $list,
            'item_count' => $total,
            'item_per_page' => $itemPerPage,
            'page_count' => $pageCount,
            'last_item_id' => (string)$lastItemId,
        ];
    }

    /**
     * 从缓存中获取随机数据列表
     *
     * @param $listCacheKey
     * @param int $itemPerPage
     * @return array
     */
    protected function _getRandomItemListByPageFromCache($listCacheKey, $itemPerPage = 20)
    {
        $total = $this->Storage()->sCard($listCacheKey);
        $itemPerPage = min(50, $itemPerPage);
        $pageCount = ceil($total / $itemPerPage);
        $list = [];
        if($total){
            $list = $this->Storage()->sRandMember($listCacheKey, $itemPerPage);
        }

        return [
            'item_list' => $list,
            'item_count' => $total,
            'item_per_page' => $itemPerPage,
            'page_count' => $pageCount,
        ];
    }

    /**
     * 获取单条数据
     *
     * @param $dbName
     * @param $tableName
     * @param $where
     * @param array $fields
     * @return mixed|static
     * @throws Exception
     */
    protected function _getItem($dbName, $tableName, $where, $fields = ['*'])
    {
        return $this->db($dbName)->table($tableName)->whereRaw($where)->first($fields);
    }

    /**
     * 生成唯一标识
     *
     * @param string $tag
     * @return string
     */
    public function getUniqid($tag)
    {
        return md5(uniqid($tag, true));
    }

    /**
     * @param $shardingKeys
     * @param string $order
     * @param array $fields
     * @param string $extWhere
     * @param bool $useShardingKeyMerge
     * @return array
     * @throws Exception
     */
    public function batchGetByShardingKeys($shardingKeys, $order = '', $fields = ['*'], $extWhere = '', $useShardingKeyMerge = true)
    {
        $ret = [];
        $search = [];
        if ($fields != ['*'] && !in_array($this->_shardingKey, $fields)) {
            $fields[] = $this->_shardingKey;
        }
        if (!empty($shardingKeys)) {
            foreach ($shardingKeys as $key) {
                $search[$this->_getTableName($key)][] = $key;
            }

            foreach ($search as $tableName => $keys) {
                $where = "{$this->_shardingKey} in ('" . implode("','", $keys) . "')" . (!empty($extWhere) ? ' and ' . $extWhere : '');
                $tmpSqlObj = $this->db(static::$dbName)->table($tableName)->whereRaw($where);
                if (!empty($order)) {
                    $tmpSqlObj = $tmpSqlObj->orderByRaw($order);
                }
                $tmpRet = $tmpSqlObj->get($fields);
                if (!empty($tmpRet)) {
                    if ($useShardingKeyMerge === true) {
                        foreach ($tmpRet as $tmpItem) {
                            $ret[$tmpItem[$this->_shardingKey]] = $tmpItem;
                        }
                    } else {
                        $ret = array_merge($ret, $tmpRet);
                    }
                }
            }
        }

        return $ret;
    }

    /**
     * 设置当次会话静态缓存数据
     *
     * @param $prefix
     * @param $key
     * @param array $data
     */
    public function setSessionCache($prefix, $key, $data = [])
    {
        $set_keys = "set_{$prefix}_{$key}";
        Utility::$set_keys($data);
    }

    /**
     * 获取当次会话缓存数据
     *
     * @param $prefix
     * @param $key
     * @return mixed
     */
    public function getSessionCache($prefix, $key)
    {
        $get_keys = "get_{$prefix}_{$key}";
        return Utility::$get_keys();
    }

    /**
     * 关闭数据库连接
     */
    public static function closeDb(){
        if(!empty(self::$capsule)){
            $tmp = self::$capsule;
            $connections = $tmp->getDatabaseManager()->getConnections();
            if(!empty($connections)){
                foreach($connections as $dbName => $connection){
                    $tmp->getDatabaseManager()->disconnect($dbName);
                }
            }
        }
        //redis关闭
        Storage::closeConnection();
        Cache::closeConnection();
    }
}