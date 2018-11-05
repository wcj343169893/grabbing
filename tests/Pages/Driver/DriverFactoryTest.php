<?php

use Mofing\Grabbing\Pages\DriverFactory;

/**
 * DriverFactory test case.
 */
class DriverFactoryTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var DriverFactory
     */
    private $productValidation;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated DriverFactoryTest::setUp()
        
        $this->productValidation = new DriverFactory("https://stmctoys.1688.com");
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated DriverFactoryTest::tearDown()
        $this->productValidation = null;
        
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
     * Tests DriverFactory->getRandomGoodsInfo()
     */
    public function testGetRandomGoodsInfo()
    {
        $driver = $this->productValidation->getDriver();
        $result = $driver->getRandomGoodsInfo(1);
        print_r($result);
    }
}

