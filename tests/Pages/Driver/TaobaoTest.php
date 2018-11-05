<?php
use Mofing\Grabbing\Pages\Driver\Taobao;

/**
 * Taobao test case.
 */
class TaobaoTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Taobao
     */
    private $taobao;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated AlibabaTest::setUp()
        
        $this->taobao = new Taobao("https://17719002900.taobao.com");
    }

    public function testGetGoodsList()
    {
        $goods = $this->taobao->getRandomGoodsInfo(1);
        print_r($goods);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated AlibabaTest::tearDown()
        $this->taobao = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }
}

