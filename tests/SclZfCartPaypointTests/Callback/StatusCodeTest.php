<?php

namespace SclZfCartPaypointTests;

use SclZfCartPaypoint\Callback\StatusCode;

/**
 * Unit tests for {@StatusCode}.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class StatusCodeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The instance to be tested.
     *
     * @var StatusCode
     */
    protected $statusCode;

    /**
     * Set up an instance to be tested.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->statusCode = new StatusCode();
    }

    /**
     * Test that when set is called with an invalid value an exception is thrown.
     *
     * @covers SclZfCartPaypoint\Callback\StatusCode::set
     * @expectedException SclZfCartPaypoint\Exception\DomainException
     *
     * @return void
     */
    public function testSetWithInvalidValue()
    {
        $this->statusCode->set('invalid value');
    }

    /**
     * Test that the value it is stored in the object properly.
     *
     * @covers SclZfCartPaypoint\Callback\StatusCode::set
     * @covers SclZfCartPaypoint\Callback\StatusCode::value
     *
     * @return void
     */
    public function testSetValue()
    {
        $result = $this->statusCode->set(StatusCode::TOKEN);

        $this->assertEquals(
            $this->statusCode,
            $result,
            'StatusCode::set() is not fluent.'
        );

        $this->assertEquals(
            StatusCode::TOKEN,
            $this->statusCode->value()
        );
    }

    /**
     * Test that when constructor is passed and invalid value an exception is thrown.
     *
     * @covers SclZfCartPaypoint\Callback\StatusCode::set
     * @expectedException SclZfCartPaypoint\Exception\DomainException
     *
     * @return void
     */
    public function testConstructWithInvalidValue()
    {
        $statusCode = new StatusCode('invalid value');
    }

    /**
     * Test that value can be set via the constructor.
     *
     * @covers SclZfCartPaypoint\Callback\StatusCode::__construct
     * @covers SclZfCartPaypoint\Callback\StatusCode::value
     *
     * @return void
     */
    public function testConstructor()
    {
        $statusCode = new StatusCode(StatusCode::TOKEN);

        $this->assertEquals(
            StatusCode::TOKEN,
            $statusCode->value()
        );
    }
}
