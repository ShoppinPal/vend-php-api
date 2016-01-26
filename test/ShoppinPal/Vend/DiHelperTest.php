<?php
namespace ShoppinPal\Vend;

use YapepBase\Application;

/**
 * Class DiHelperTest
 *
 * @covers ShoppinPal\Vend\DiHelper
 */
class DiHelperTest extends BaseTest
{
    protected $initDiHelper = false;

    public function testInit()
    {
        $container = Application::getInstance()->getDiContainer();

        $this->assertFalse(
            isset($container[DiHelper::KEY_DI_HELPER]),
            'The DI helper should not be set before the test'
        );

        $this->assertFalse(
            isset($container[DiHelper::KEY_FACTORY]),
            'The factory should not be set before the test'
        );

        DiHelper::init();

        $this->assertTrue(
            isset($container[DiHelper::KEY_DI_HELPER]),
            'The DI helper should be set after the test'
        );

        $this->assertTrue(
            isset($container[DiHelper::KEY_FACTORY]),
            'The factory should be set after the test'
        );

        $this->assertInstanceOf(
            DiHelper::class,
            $container[DiHelper::KEY_DI_HELPER],
            'The container returns the wrong class for the DI helper'
        );

        $this->assertInstanceOf(
            Factory::class,
            $container[DiHelper::KEY_FACTORY],
            'The container returns the wrong class for the factory'
        );
    }

    public function testGetInstance()
    {
        $this->testInit();
        $this->assertInstanceOf(
            DiHelper::class,
            DiHelper::getInstance(),
            'Invalid return value for DiHelper::getInstance()'
        );
    }

    public function testGetFactory()
    {
        DiHelper::init();
        $helper = new DiHelper();
        $this->assertInstanceOf(
            Factory::class,
            $helper->getFactory(),
            'Invalid return value for DiHelper::getFactory()'
        );
    }
}
