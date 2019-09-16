<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-8-23
 * Time: 下午4:56
 */
class ApnsUtils
{
    public static function validatePayloadLength($locKey, $locArgs, $message, $actionLocKey, $launchImage, $badge, $sound, $payload, $contentAvailable)
    {
        $json = ApnsUtils :: processPayload($locKey, $locArgs, $message, $actionLocKey, $launchImage, $badge, $sound, $payload, $contentAvailable);
        return strlen($json);
    }

    public static function processPayload($locKey, $locArgs, $message, $actionLocKey, $launchImage, $badge, $sound, $payload, $contentAvailable)
    {
        $isValid = false;
        $pb = new Payload();
        if ($locKey != null && strlen($locKey) > 0) {
            // loc-key
            $pb->setAlertLocKey(($locKey));
            // loc-args
            if ($locArgs != null && strlen($locArgs) > 0) {
                $pb->setAlertLocArgs(explode(',', ($locArgs)));
            }
            $isValid = true;
        }

        // body
        if ($message != null && strlen($message) > 0) {
            $pb->setAlertBody(($message));
            $isValid = true;
        }

        // action-loc-key
        if ($actionLocKey!=null && strlen($actionLocKey) > 0) {
            $pb->setAlertActionLocKey($actionLocKey);
        }

        // launch-image
        if ($launchImage!=null && strlen($launchImage) > 0) {
            $pb->setAlertLaunchImage($launchImage);
        }

        // badge
        $badgeNum = -1;
        if (is_numeric($badge)) {
            $badgeNum = (int)$badge;
        }
        if ($badgeNum >= 0) {
            $pb->setBadge($badgeNum);
            $isValid = true;
        }

        // sound
        if ($sound != null && strlen($sound) > 0) {
            $pb->setSound($sound);
        } else {
            $pb->setSound("default");
        }

        //contentAvailable
        if ($contentAvailable == 1) {
            $pb->setContentAvailable(1);
            $isValid = true;
        }

        // payload
        if ($payload != null && strlen($payload) > 0) {
            $pb->addParam("payload", ($payload));
        }

        if ($isValid == false) {
            throw new Exception("one of the params(locKey,message,badge) must not be null or contentAvailable must be 1");
        }
        $json = $pb->toString();
        if ($json == null) {
            throw new Exception("payload json is null");
        }
        return $json;
    }
}

class Payload
{
    public $APS = "aps";
    public $params;
    public $alert;
    public $badge;
    public $sound = "";

    public $alertBody;
    public $alertActionLocKey;
    public $alertLocKey;
    public $alertLocArgs;
    public $alertLaunchImage;
    public $contentAvailable;

    public function getParams()
    {
        return $this->params;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function addParam($key, $obj)
    {
        if ($this->params == null) {
            $this->params = array();
        }
        if ($this->APS == strtolower($key)) {
            throw new Exception("the key can't be aps");
        }
        $this->params[$key] = $obj;
    }

    public function getAlert()
    {
        return $this->alert;
    }

    public function setAlert($alert)
    {
        $this->alert = $alert;
    }

    public function getBadge()
    {
        return $this->badge;
    }

    public function setBadge($badge)
    {
        $this->badge = $badge;
    }

    public function getSound()
    {
        return $this->sound;
    }

    public function setSound($sound)
    {
        $this->sound = $sound;
    }

    public function getAlertBody()
    {
        return $this->alertBody;
    }

    public function setAlertBody($alertBody)
    {
        $this->alertBody = $alertBody;
    }

    public function getAlertActionLocKey()
    {
        return $this->alertActionLocKey;
    }

    public function setAlertActionLocKey($alertActionLocKey)
    {
        $this->alertActionLocKey = $alertActionLocKey;
    }

    public function getAlertLocKey()
    {
        return $this->alertLocKey;
    }

    public function setAlertLocKey($alertLocKey)
    {
        $this->alertLocKey = $alertLocKey;
    }

    public function getAlertLaunchImage()
    {
        return $this->alertLaunchImage;
    }

    public function setAlertLaunchImage($alertLaunchImage)
    {
        $this->alertLaunchImage = $alertLaunchImage;
    }

    public function getAlertLocArgs()
    {
        return $this->alertLocArgs;
    }

    public function setAlertLocArgs($alertLocArgs)
    {
        $this->alertLocArgs = $alertLocArgs;
    }

    public function getContentAvailable()
    {
        return $this->contentAvailable;
    }

    public function setContentAvailable($contentAvailable)
    {
        $this->contentAvailable = $contentAvailable;
    }

    public function putIntoJson($key, $value, $obj)
    {
        if ($value != null) {
            $obj[$key] = $value;
        }
        return $obj;
    }

    public function toString()
    {
        $object = array();
        $apsObj = array();
        if ($this->getAlert() != null) {
            $apsObj["alert"] = urlencode($this->getAlert());
        } else {
            if ($this->getAlertBody() != null || $this->getAlertLocKey() != null) {
                $alertObj = array();
                $alertObj = $this->putIntoJson("body", ($this->getAlertBody()), $alertObj);
                $alertObj = $this->putIntoJson("action-loc-key", ($this->getAlertActionLocKey()), $alertObj);
                $alertObj = $this->putIntoJson("loc-key", ($this->getAlertLocKey()), $alertObj);
                $alertObj = $this->putIntoJson("launch-image", ($this->getAlertLaunchImage()), $alertObj);
                if ($this->getAlertLocArgs() != null) {
                    $array = array();
                    foreach ($this->getAlertLocArgs() as $str) {
                        array_push($array, ($str));
                    }
                    $alertObj["loc-args"] = $array;
                }
                $apsObj["alert"] = $alertObj;
            }
        }
        if ($this->getBadge() != null) {
            $apsObj["badge"] = $this->getBadge();
        }
        // 判断是否静音
        if ("com.gexin.ios.silence" != ($this->getSound())) {
            $apsObj = $this->putIntoJson("sound", ($this->getSound()), $apsObj);
        }
        if ($this->getContentAvailable() == 1) {
            $apsObj["content-available"]=1;
        }
        $object[$this->APS] = $apsObj;
        if ($this->getParams() != null) {
            foreach ($this->getParams() as $key => $value) {
                $object[($key)] = ($value);
            }
        }
        return Util::json_encode($object);
    }
}

class Util
{
    public static function json_encode($input)
    {
        // 从 PHP 5.4.0 起, 增加了这个选项.
        if (defined('JSON_UNESCAPED_UNICODE')) {
            return json_encode($input, JSON_UNESCAPED_UNICODE);
        }
        if (is_string($input)) {
            $text = $input;
            $text = str_replace("\\", "\\\\", $text);
            //$text = str_replace('/', "\\/",   $text);
            $text = str_replace('"', "\\".'"', $text);
            $text = str_replace("\b", "\\b", $text);
            $text = str_replace("\t", "\\t", $text);
            $text = str_replace("\n", "\\n", $text);
            $text = str_replace("\f", "\\f", $text);
            $text = str_replace("\r", "\\r", $text);
            //$text = str_replace("\u", "\\u", $text);
            return '"' . $text . '"';
        } elseif (is_array($input) || is_object($input)) {
            $arr = array();
            $is_obj = is_object($input) || (array_keys($input) !== range(0, count($input) - 1));
            foreach ($input as $k=>$v) {
                if ($is_obj) {
                    $arr[] = self::json_encode($k) . ':' . self::json_encode($v);
                } else {
                    $arr[] = self::json_encode($v);
                }
            }
            if ($is_obj) {
                return '{' . join(',', $arr) . '}';
            } else {
                return '[' . join(',', $arr) . ']';
            }
        } else {
            return $input . '';
        }
    }
}
