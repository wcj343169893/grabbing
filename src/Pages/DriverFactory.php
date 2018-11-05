<?php
namespace Mofing\Grabbing\Pages;

use Mofing\Grabbing\Pages\Driver\Tmall;
use Mofing\Grabbing\Pages\Driver\Alibaba;
use Mofing\Grabbing\Pages\Driver\Jingdong;
use Mofing\Grabbing\Pages\Driver\Taobao;

class DriverFactory
{

    private $driver;

    public function __construct($url)
    {
        // 获取链接的域名
        $host = parse_url($url, PHP_URL_HOST);
        // 判断是京东还是淘宝
        if (strpos($host, "1688.com")) {
            // 1688.com
            $this->driver = new Alibaba($url);
        } elseif (strpos($host, "jd.com")) {
            // jd.com
            $this->driver = new Jingdong($url);
        } elseif (strpos($host, "taobao.com")) {
            // taobao.com
            $this->driver = new Taobao($url);
        } elseif (strpos($host, "tmall.com")) {
            // tmall.com
            $this->driver = new Tmall($url);
        }
    }

    /**
     * 获取处理类
     *
     * @return \Mofing\Grabbing\Pages\Driver
     */
    public function getDriver()
    {
        return $this->driver;
    }
}

