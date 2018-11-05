<?php
namespace Mofing\Grabbing\Pages\Driver;

use Mofing\Grabbing\Pages\Driver;

/**
 * 天猫网站
 *
 * @author Wenchaojun <343169893@qq.com>
 *        
 */
class Jingdong extends Driver
{

    var $charset = "";

    public function __construct($url)
    {
        $this->homeLink = $url;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Mofing\Grabbing\Pages\Driver::getGoodsInfo()
     */
    public function getGoodsInfo($link)
    {
        $this->charset = "gbk";
        // 获取网页内容
        $content = $this->getPageContent($link);
        // 提取产品地址
        // $pattern = '<link rel="canonical" href="([\S\s]*?)" \/>';
        // $link = $this->getPattenText($pattern, $content);
        $title = "";
        $pic = "";
        // 获取图片
        $mpic = "<img alt='([\S\s]*?)' src='([\S\s]*?)' data-url='([\S\s]*?)'>";
        preg_match($mpic, $content, $data);
        if ($data && ! empty($data[1])) {
            // 获取标题
            $title = $data[1];
            $pic = $data[2];
            // 替换成大图
            $pic = str_replace("s54x54_jfs", "s450x450_jfs", $pic);
        }
        return [
            "title" => $title,
            "link" => $this->getFullUrl($link),
            "number" => $this->getRandomNumber(),
            "key" => $this->getRandomKey($link),
            "image" => $this->getFullUrl($pic)
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Mofing\Grabbing\Pages\Driver::getGoodsList()
     */
    public function getGoodsList()
    {
        $content = $this->getPageContent($this->homeLink);
        $exp = "/\/\/item.jd.com\/(.*?).html\"/";
        preg_match_all($exp, $content, $links);
        // 正则提取一条产品;
        if ($links && ! empty($links[0])) {
            return $links[0];
        }
        return [];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Mofing\Grabbing\Pages\Driver::getPageContent()
     */
    public function getPageContent($url)
    {
        $url = $this->getFullUrl($url);
        // 这里获取网站内容方式有所不同
        $content = $this->curl_get($url);
        if (! empty($this->charset)) {
            $content = mb_convert_encoding($content, $this->defaultCharset, $this->charset);
        }
        // print_r($content);
        return $content;
    }
}

