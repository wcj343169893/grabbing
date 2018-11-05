<?php
namespace Mofing\Grabbing\Pages\Driver;

use Mofing\Grabbing\Pages\Driver;

/**
 * 淘宝网站
 *
 * @author Wenchaojun <343169893@qq.com>
 *        
 */
class Taobao extends Driver
{

    var $charset = "gbk";

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
        // 获取网页内容
        $content = $this->getPageContent($link);
        // 获取标题
        $pattern = "/<h3[^>]*data-title=\"(.*?)\"[^>]*>/i";
        $title = $this->getPattenText($pattern, $content);
        // 获取图片
        $mpic = "/<img[^>]*src=\"(.*?)\"[^>]*>/i";
        $pic = $this->getPattenText($mpic, $content);
        return [
            "title" => $title,
            "link" => $this->getFullUrl($link),
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
        $exp = '/\/\/item\.taobao\.com\/item\.htm?[^\s]+/i';
        preg_match_all($exp, $content, $links);
        // 正则提取一条产品;
        if ($links && ! empty($links[0])) {
            return $links[0];
        }
        return [];
    }
}

