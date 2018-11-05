<?php
use Mofing\Grabbing\Pages\Driver\Alibaba;

/**
 * Alibaba test case.
 */
class AlibabaTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Alibaba
     */
    private $alibaba;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated AlibabaTest::setUp()
        
        $this->alibaba = new Alibaba("https://jieweiyujuchang.1688.com");
    }

    public function testGetGoodsList()
    {
        $goods = $this->alibaba->getRandomGoodsInfo(1);
        print_r($goods);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated AlibabaTest::tearDown()
        $this->alibaba = null;
        
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

