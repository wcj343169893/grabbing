<?php
namespace Mofing\Grabbing\Pages\Driver;

use Mofing\Grabbing\Pages\Driver;

/**
 * 阿里巴巴批发采购
 * 
 * @author Wenchaojun <343169893@qq.com>
 *        
 */
class Alibaba extends Driver
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
        $pattern = '/<h1 class="d-title">([\S\s]*?)<\/h1>/';
        $title = $this->getPattenText($pattern, $content);
        // 获取图片
        $mpic = '/<meta property="og:image" content="([\S\s]*?)"\/>/';
        $pic = $this->getPattenText($mpic, $content);
        return [
            "title" => $title,
            "link" => $link,
            "number" => $this->getRandomNumber(),
            "key" => $this->getRandomKey($link),
            "image" => $pic
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
        $exp = '/https:\/\/detail.1688.com\/offer\/(\d+).html/';
        preg_match_all($exp, $content, $links);
        // 正则提取一条产品;
        if ($links && ! empty($links[0])) {
            return $links[0];
        }
        return [];
    }
}

