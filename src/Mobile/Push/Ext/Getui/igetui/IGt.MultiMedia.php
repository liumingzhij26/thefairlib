<?php
/**
 * 个推IOS多媒体消息，支持图片、音频、视频
 * Created by PhpStorm.
 * User: zqzhao5
 * Date: 17-7-27
 * Time: 下午3:21
 */
class IGtMultiMedia
{
    /**
     * @var资源ID
     */
    public $rid;
    /**
     * @var资源url
     */
    public $url;
    /**
     * @var资源类型
     */
    public $type;
    /**
     * @var是否只支持wifi下发
     */
    public $onlywifi = 0;

    public function __construct()
    {
    }

    public function get_rid()
    {
        return $this->rid;
    }

    public function set_rid($rid)
    {
        $this->rid = $rid;
        return $this;
    }

    public function get_url()
    {
        return $this->url;
    }

    public function set_url($url)
    {
        $this->url = $url;
        return$this;
    }

    public function get_type()
    {
        return $this -> type;
    }

    public function set_type($type)
    {
        $this -> type = $type;
        return $this;
    }

    public function set_onlywifi($onlywifi)
    {
        $this -> onlywifi = $onlywifi ? 1:0;
        return $this;
    }

    public function get_onlywifi()
    {
        return $this -> onlywifi;
    }
}

class MediaType
{
    const __default = self::pic;

    const pic = 1;
    const audio = 2;
    const video = 3;
}
