<?php

namespace ShoppinPal\Vend;

use YapepBase\Application;
use YapepBase\DependencyInjection\SystemContainer;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{

    protected $initDiHelper = true;

    /**
     * @var SystemContainer
     */
    protected $diContainer;


    protected function setUp(): void
    {
        parent::setUp();

        $this->diContainer = new SystemContainer();
        Application::getInstance()->setDiContainer($this->diContainer);

        if ($this->initDiHelper) {
            DiHelper::init();
        }

        require realpath(__DIR__ . '/../../config.php');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // Make sure the di container is clean after a test
        Application::getInstance()->setDiContainer(new SystemContainer());
    }

    protected function getFactoryMock()
    {
        $factoryMock = $this->getMockBuilder(Factory::class)
            ->disableOriginalConstructor()
            ->setMethods(['getOAuth'])
            ->getMock();

        $this->diContainer[DiHelper::KEY_FACTORY] = $factoryMock;

        return $factoryMock;
    }

}
