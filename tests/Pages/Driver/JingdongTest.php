<?php
use Mofing\Grabbing\Pages\Driver\Jingdong;

/**
 * Jingdong test case.
 */
class JingdongTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Jingdong
     */
    private $jingdong;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated JingdongTest::setUp()
        
        $this->jingdong = new Jingdong("https://mall.jd.com/index-1000000904.html");
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated JingdongTest::tearDown()
        $this->jingdong = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }

    /**
     * Tests Jingdong->getGoodsList()
     */
    public function testGetGoodsList()
    {
        $goods = $this->jingdong->getRandomGoodsInfo(1);
        print_r($goods);
    }
}

