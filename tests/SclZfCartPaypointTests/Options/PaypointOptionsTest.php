<?php

namespace SclZfCartPaypointTests\Options;

use SclZfCartPaypoint\Options\PaypointOptions;
use SclZfCartPaypoint\Options\PaypointOptionsInterface;

/**
 * Unit tests for {@see ConnectionOptions}.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class PaypointOptionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The instance to be tested
     *
     * @var PaypointOptions
     */
    protected $options;

    /**
     * Prepare the object to be tested.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->options = new PaypointOptions;
    }

    /**
     * Test a getter and setter for a specific parameter.
     *
     * @param  string $property
     * @param  mixed  $value
     * @return void
     */
    protected function getSetCheck($property, $value)
    {
        $getter = "get$property";
        $setter = "set$property";

        $this->options->$setter($value);

        $this->assertEquals(
            $value,
            $this->options->$getter(),
            "$property is incorrect"
        );
    }

    /**
     * Test the getters and setters
     *
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getMode
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setMode
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getName
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setName
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getMerchant
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setMerchant
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getCurrency
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setCurrency
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getTxDescription
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setTxDescription
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getUrl
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setUrl
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getLivePassword
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setLivePassword
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getTestPassword
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setTestPassword
     *
     * @return void
     */
    public function testGetSet()
    {
        $this->getSetCheck('mode', 'true');
        $this->getSetCheck('mode', 'false');
        $this->getSetCheck('mode', 'live');
        $this->getSetCheck('name', 'the_name');
        $this->getSetCheck('merchant', 'the_merchant');
        $this->getSetCheck('currency', 'GBP');
        $this->getSetCheck('txDescription', 'the_description');
        $this->getSetCheck('url', 'http://api.url');
        $this->getSetCheck('livePassword', 'live_password');
        $this->getSetCheck('testPassword', 'test_password');
    }

    /**
     * Test set mode with a value which is not in the allowed set.
     *
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setMode
     * @expectedException SclZfCartPaypoint\Exception\DomainException
     *
     * @return void
     */
    public function testSetModeWithBadMode()
    {
        $this->options->setMode('bad_mode');
    }

    /**
     * testGetConnection
     *
     * @covers SclZfCartPaypoint\Options\PaypointOptions::isLive
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getActivePassword
     *
     * @return void
     */
    public function testIsLiveAndGetActivePassword()
    {
        $livePassword = 'live_password';
        $testPassword = 'test_password';

        $this->options->setLivePassword($livePassword);
        $this->options->setTestPassword($testPassword);

        $this->options->setMode(PaypointOptionsInterface::MODE_LIVE);

        $this->assertTrue(
            $this->options->isLive(),
            'isLive should return true for MODE_LIVE'
        );

        $this->assertEquals(
            $livePassword,
            $this->options->getActivePassword(),
            'Live password doesn\'t match for MODE_LIVE'
        );

        $this->options->setMode(PaypointOptionsInterface::MODE_TEST_TRUE);

        $this->assertFalse(
            $this->options->isLive(),
            'isLive should return false for MODE_TEST_TRUE'
        );

        $this->assertEquals(
            $testPassword,
            $this->options->getActivePassword(),
            'Test password doesn\'t match for MODE_TEST_TRUE'
        );

        $this->options->setMode(PaypointOptionsInterface::MODE_TEST_FALSE);

        $this->assertFalse(
            $this->options->isLive(),
            'isLive should return false for MODE_TEST_FALSE'
        );

        $this->assertEquals(
            $testPassword,
            $this->options->getActivePassword(),
            'Test password doesn\'t match for MODE_TEST_FALSE'
        );
    }
}
