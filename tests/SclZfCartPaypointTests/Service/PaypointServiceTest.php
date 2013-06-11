<?php

namespace SclZfCartPaypointTests\Service;

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
     *
     * @var PaypointService
     */
    protected $service;

    /**
     * Mock HashChecker
     *
     * @var \SclZfCartPaypoint\Service\HashChecker
     */
    protected $hashChecker;

    /**
     * Mock request object.
     *
     * @var \Zend\Http\Request
     */
    protected $request;

    /**
     * Create the object to use for testing.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->hashChecker = $this->getMockBuilder('SclZfCartPaypoint\Service\HashChecker')
            ->disableOriginalConstructor()
            ->getMock();

        $this->service = new PaypointService($this->hashChecker);

        $this->request = $this->getMock('Zend\Http\Request');
    }

    /**
     * Test that if a callback is made with a bad URI BAD_CALLBACK is returned.
     *
     * @covers SclZfCartPaypoint\Service\PaypointService::processCallback
     *
     * @return void
     */
    public function testProcessCallbackWithBadUri()
    {
<<<<<<< HEAD
        $callback = $this->getMock('SclZfCartPaypoint\Callback\Callback');

        $this->service->processCallback($callback);
=======
        $this->hashChecker
             ->expects($this->atLeastOnce())
             ->method('isValid')
             ->will($this->returnValue(false));

        $result = $this->service->processCallback($this->request);

        $this->assertEquals(
            PaypointService::BAD_CALLBACK,
            $result
        );
>>>>>>> Started processing callbacks [broken]
    }
}
