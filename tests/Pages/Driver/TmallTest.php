<?php

use Mofing\Grabbing\Pages\Driver\Tmall;

/**
 * Tmall test case.
 */
class TmallTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Tmall
     */
    private $tmall;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated TmallTest::setUp()
        
        $this->tmall = new Tmall("https://veromoda.tmall.com");
    }
    public function testGetGoodsList()
    {
        $goods = $this->tmall->getRandomGoodsInfo(1);
        print_r($goods);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated TmallTest::tearDown()
        $this->tmall = null;
        
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

