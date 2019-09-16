<?php

namespace TheFairLib\Utility\ParseTools;

use PHPHtmlParser\Dom\HtmlNode;
use TheFairLib\Utility\Utility;

/**
 * Created by xiangc
 * Date: 2018/6/13
 * Time: 20:26
 */
class ParseUtils
{
    private static $instance;

    /**
     * @return ParseUtils
     */
    public static function Instance()
    {
        $class = get_called_class();
        if (empty(self::$instance[$class])) {
            self::$instance[$class] = new $class();
        }
        return self::$instance[$class];
    }


    /**
     * 生成hash
     * @param $content
     * @return string
     */
    public function genHash($content)
    {
        $crc = crc32($content);
        $hashcode = base_convert($crc, 10, 26);
        return $hashcode;
    }

    /**
     * 获取长度 by utf8
     * @param $str
     * @return int
     */
    public function s_strlen($str)
    {
        return mb_strlen($str, 'utf8');//6
    }

    /**
     * 截取子串 by utf8
     * @param $base
     * @param $start
     * @param $len
     * @return string
     */
    public function s_subStr($base, $start, $len = null)
    {
        return mb_substr($base, $start, $len, 'utf8');
    }

    /**
     * 获取在子串中的位置 by utf8
     * @param $str
     * @param $searchStr
     * @param int $offset
     * @return false|int
     */
    public function s_strpos($str, $searchStr, $offset = 0)
    {
        return mb_strpos($str, $searchStr, $offset, 'utf8');
    }


    /**
     * 清理html内容
     * @param $text
     * @return string
     */
    public function trimContent($text)
    {
        $text = str_replace('&nbsp;', '', $text);
        return trim(html_entity_decode($text));
    }


    /**
     * @param $str
     * @param $searchStr
     * @return array
     */
    public function findAll($str, $searchStr)
    {
        $lastPos = 0;
        $positions = array();

        while (($lastPos = $this->s_strpos($str, $searchStr, $lastPos)) !== false) {
            if ($lastPos > $this->s_strlen($str)) {
                break;
            }
            $positions[] = $lastPos;
//            echo $this->s_subStr($str, $lastPos, 4) . "\n";
            $lastPos = $lastPos + $this->s_strlen($searchStr);
        }

        return $positions;
    }


    /**
     * 从节点中获取style的属性
     * @param HtmlNode $item
     * @param $styleName
     * @return string
     */
    public function getCssValueFromItem($item, $styleName)
    {
        $styleStr = strtolower($item->getAttribute('style'));
        $styleName = strtolower($styleName);
        $cssArray = explode(";", $styleStr);

        $mValue = '';
        foreach ($cssArray as $cssItem) {
            $cssItemArray = explode(":", $cssItem);
            if (sizeof($cssItemArray) > 1) {
                if (strtolower($cssItemArray[0]) == $styleName) {
                    $mValue = trim($cssItemArray[1]);
                }
            }
        }
        if ($mValue == 'null' || empty($mValue)) {//兼容null值，第一次知道还有null值
            $mValue = $this->getDefaultAttributeValue($styleName);
        }

        return $mValue;
    }

    /**
     * 获取id
     * @param HtmlNode $item
     * @return string
     */
    public function getDataId($item)
    {
        return strtolower($item->getAttribute('dataid'));
    }

    private $_defaultAttributes = [
        'color' => '#333',
        'text-align' => 'left',
    ];

    /**
     * 设置默认属性
     * @param array $attrs
     */
    public function setDefaultAttributeValues($attrs)
    {
        $this->_defaultAttributes = $attrs;
    }

    /**
     * 获取默认值
     * @param $key
     * @return string
     */
    public function getDefaultAttributeValue($key)
    {
        return Utility::arrayGet($this->_defaultAttributes, $key, '');
    }
}
