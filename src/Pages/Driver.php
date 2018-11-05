<?php
namespace Mofing\Grabbing\Pages;

abstract class Driver
{

    var $charset = "";

    var $defaultCharset = "utf-8";

    var $homeLink = "";

    var $detailLink = "";

    var $detailLinks = [];

    /**
     * 获取网站页面
     *
     * @param string $url            
     * @return string
     */
    public function getPageContent($url)
    {
        $url = $this->getFullUrl($url);
        $content = $this->httpRequest($url);
        if (! empty($this->charset)) {
            $content = mb_convert_encoding($content, $this->defaultCharset, $this->charset);
        }
        return $content;
    }

    /**
     * 补充完整url
     *
     * @param string $link            
     * @return string
     */
    protected function getFullUrl($link)
    {
        // 如果是//开头，则需要自动加上http
        if (strpos($link, "//") === 0) {
            $link = "https:" . $link;
        }
        return $link;
    }

    public function getHomePage()
    {}

    public function getDetailPage()
    {}

    /**
     * 生成随机号码
     *
     * @return number
     */
    public function getRandomNumber()
    {
        return rand(1000, 9999);
    }

    /**
     * 生成随机key
     *
     * @param string $link            
     * @return string
     */
    public function getRandomKey($link)
    {
        if (is_array($link)) {
            $link = implode("_", $link);
        }
        return md5(md5($link) . $this->getRandomNumber());
    }

    /**
     * 获取产品列表
     */
    abstract public function getGoodsList();

    /**
     * 获取产品详情
     */
    abstract public function getGoodsInfo($link);

    /**
     * 随机获取一条或者多条
     *
     * @param int $number            
     */
    public function getRandomLink($number)
    {
        $links = $this->getGoodsList();
        if (empty($links)) {
            return false;
        }
        $key = array_rand($links, $number);
        if ($number > 1) {
            $data = [];
            foreach ($key as $k) {
                $data[] = str_replace("\"", "", $links[$k]);
            }
            return $data;
        }
        return str_replace("\"", "", $links[$key]);
    }

    /**
     * 随机获取指定数量的产品
     *
     * @param int $number            
     * @return []
     */
    public function getRandomGoodsInfo($number)
    {
        $link = $this->getRandomLink($number);
        if (! $link) {
            return false;
        }
        if (is_array($link)) {
            $data = [];
            foreach ($link as $li) {
                $data[] = $this->getGoodsInfo($li);
            }
            return $data;
        }
        return $this->getGoodsInfo($link);
    }

    /**
     * 提取正则内部一条数据
     *
     * @param string $patt            
     * @param string $content            
     * @return string|boolean
     */
    protected function getPattenText($patt, $content)
    {
        preg_match($patt, $content, $data);
        if ($data && ! empty($data[1])) {
            return $data[1];
        }
        return false;
    }

    /**
     * 微信模拟请求
     *
     * @param string $url            
     * @return mixed
     */
    protected function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        
        $res = curl_exec($curl);
        curl_close($curl);
        
        return $res;
    }

    protected function curl_get($url, $gzip = true)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.2) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/525.13");
        if ($gzip)
            curl_setopt($curl, CURLOPT_ENCODING, "gzip"); // 关键在这里
        $content = curl_exec($curl);
        curl_close($curl);
        return $content;
    }

    /**
     * 微信模拟请求json
     *
     * @param string $url            
     * @param string $json_string            
     * @return string
     */
    protected function httpPostJson($url, $json_string)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($json_string)
        ));
        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();
        return $return_content;
    }

    /**
     * 模拟浏览器请求
     *
     * @param string $url            
     * @param string $method            
     * @param []|string $postfields            
     * @param array $headers            
     * @param string $debug            
     * @return mixed
     */
    protected function httpRequest($url, $method = "GET", $postfields = null, $headers = array(), $debug = false)
    {
        $method = strtoupper($method);
        $ci = curl_init();
        /* Curl settings */
        curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        // curl_setopt($ci, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0");
        curl_setopt($ci, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.2) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/525.13");
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ci, CURLOPT_TIMEOUT, 7);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        
        switch ($method) {
            case "POST":
                curl_setopt($ci, CURLOPT_POST, true);
                if (! empty($postfields)) {
                    $tmpdatastr = is_array($postfields) ? http_build_query($postfields) : $postfields;
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $tmpdatastr);
                }
                break;
            default:
                curl_setopt($ci, CURLOPT_CUSTOMREQUEST, $method);
                break;
        }
        $ssl = preg_match('/^https:\/\//i', $url) ? TRUE : FALSE;
        curl_setopt($ci, CURLOPT_URL, $url);
        if ($ssl) {
            curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        // curl_setopt($ci, CURLOPT_HEADER, true);
        curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ci, CURLOPT_MAXREDIRS, 2);
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLINFO_HEADER_OUT, true);
        /* curl_setopt($ci, CURLOPT_COOKIE, $Cookiestr); */
        $response = curl_exec($ci);
        $requestinfo = curl_getinfo($ci);
        $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        if ($debug) {
            echo "=====post data======\r\n";
            var_dump($postfields);
            echo "=====info===== \r\n";
            print_r($requestinfo);
            echo "=====response=====\r\n";
            print_r($response);
        }
        curl_close($ci);
        return $response;
    }
}

