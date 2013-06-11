<?php

namespace SclZfCartPaypointTests\Service;

use SclZfCartPayment\Entity\PaymentInterface;
use SclZfCartPayment\Mapper\PaymentMapperInterface;
use SclZfCartPayment\Service\CompletionService;
use SclZfCartPaypoint\Callback\Callback;
use SclZfCartPaypoint\Callback\StatusCode;
use SclZfCartPaypoint\Service\PaypointService;

/**
 * Unit tests for {@see PaypointService}.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class PaypointServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The instance to be tested.

     * @var PaypointService
     */
    protected $service;

    /**
     * paymentMapper
     *
     * @var PaymentMapperInterface
     */
    protected $paymentMapper;

    /**
     * completionService
     *
     * @var CompletionService
     */
    protected $completionService;

    /**
     * callback
     *
     * @var Callback
     */
    protected $callback;

    /**
     * statusCode
     *
     * @var StatusCode
     */
    protected $statusCode;

    /**
     * payment
     *
     * @var PaymentInterface
     */
    protected $payment;

    /**
     * Create the object to use for testing.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->paymentMapper = $this->getMock('SclZfCartPayment\Mapper\PaymentMapperInterface');

        $this->completionService = $this->getMockBuilder('SclZfCartPayment\Service\CompletionService')
            ->disableOriginalConstructor()
            ->getMock();

        $this->service = new PaypointService($this->paymentMapper, $this->completionService);

        $this->callback = $this->getMock('SclZfCartPaypoint\Callback\Callback');

        $this->statusCode = $this->getMock('SclZfCartPaypoint\Callback\StatusCode');

        $this->callback
             ->expects($this->any())
             ->method('getCode')
             ->will($this->returnValue($this->statusCode));

        $this->payment = $this->getMock('SclZfCartPayment\Entity\PaymentInterface');
    }

    /**
     * Check that processCallback throws an exception if a bad transactionId is provided.
     *
     * @covers SclZfCartPaypoint\Service\PaypointService::processCallback
     * @covers SclZfCartPaypoint\Service\PaypointService::paymentId
     * @expectedException SclZfCartPaypoint\Exception\DomainException
     *
     * @return void
     */
    public function testProcessCallbackWithBadTransactionId()
    {
        $this->callback
             ->expects($this->atLeastOnce())
             ->method('getTransactionId')
             ->will($this->returnValue('123'));

        $this->service->processCallback($this->callback);
    }

    /**
     * Check that processCallback throws an exception if the payment is not found.
     *
     * @covers SclZfCartPaypoint\Service\PaypointService::processCallback
     * @covers SclZfCartPaypoint\Service\PaypointService::paymentId
     * @expectedException SclZfCartPaypoint\Exception\RuntimeException
     *
     * @return void
     */
    public function testProcessCallbackWithNonExistingPayment()
    {
        $this->callback
             ->expects($this->atLeastOnce())
             ->method('getTransactionId')
             ->will($this->returnValue('TX-000002'));

        $this->paymentMapper
             ->expects($this->once())
             ->method('findById')
             ->with($this->equalTo(2))
             ->will($this->returnValue(null));

        $this->service->processCallback($this->callback);
    }

    /**
     * Test that a successfult transaction is completed properly.
     *
     * @covers SclZfCartPaypoint\Service\PaypointService::processCallback
     * @covers SclZfCartPaypoint\Service\PaypointService::transactionSuccessful
     * @covers SclZfCartPaypoint\Service\PaypointService::__construct
     *
     * @return void
     */
    public function testProcessCallbackWithSuccessfulTransaction()
    {
        $this->callback
             ->expects($this->atLeastOnce())
             ->method('getTransactionId')
             ->will($this->returnValue('TX-000002'));

        $this->paymentMapper
             ->expects($this->once())
             ->method('findById')
             ->with($this->equalTo(2))
             ->will($this->returnValue($this->payment));

        $this->statusCode
             ->expects($this->atLeastOnce())
             ->method('value')
             ->will($this->returnValue(StatusCode::AUTHORISED));

        $this->completionService
             ->expects($this->once())
             ->method('complete')
             ->with($this->equalTo($this->payment));

        $this->service->processCallback($this->callback);
    }

    /**
     * Test that a successfult transaction is completed properly.
     *
     * @covers SclZfCartPaypoint\Service\PaypointService::processCallback
     * @covers SclZfCartPaypoint\Service\PaypointService::transactionSuccessful
     * @covers SclZfCartPaypoint\Service\PaypointService::__construct
     *
     * @return void
     */
    public function testProcessCallbackWithFailedTransaction()
    {
        $this->callback
             ->expects($this->atLeastOnce())
             ->method('getTransactionId')
             ->will($this->returnValue('TX-000002'));

        $this->paymentMapper
             ->expects($this->once())
             ->method('findById')
             ->with($this->equalTo(2))
             ->will($this->returnValue($this->payment));

        $this->statusCode
             ->expects($this->atLeastOnce())
             ->method('value')
             ->will($this->returnValue(StatusCode::NOT_AUTHORISED));

        $this->completionService
             ->expects($this->once())
             ->method('fail')
             ->with($this->equalTo($this->payment));

        $this->service->processCallback($this->callback);
    }
}
