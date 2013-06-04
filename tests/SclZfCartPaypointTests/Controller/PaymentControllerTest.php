<?php

namespace SclZfCartPaypointTests\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Unit tests for {@see PaymentController}.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class PaymentControllerTests extends AbstractHttpControllerTestCase
{
    /**
     * Setup the instance to be tested.
     *
     * @return void
     */
    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../TestConfiguration.php'
        );
        parent::setUp();
    }

    /**
     * Test the callback action.
     *
     * @covers SclZfCartPaypoint\Controller\PaymentController::callbackAction
     * @covers SclZfCartPaypoint\Controller\PaymentController::setPaypointService
     * @covers SclZfCartPaypoint\Controller\PaymentController::getPaypointService
     *
     * @return void
     */
    public function testCallbackAction()
    {
        $result = $this->dispatch('/paypoint/callback');

        $this->assertControllerName('SclZfCartPaypoint\Controller\Payment');
        $this->assertControllerClass('PaymentController');
        $this->assertMatchedRouteName('paypoint/callback');
        $this->assertResponseStatusCode(200);
    }
}
