<?php

namespace SclZfCartPaypointTests\Options;

use SclZfCartPaypoint\Options\PaypointOptions;
use SclZfCartPaypoint\Options\ConnectionOptions;

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
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getLive
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setLive
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getName
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setName
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getMerchant
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setMerchant
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getVersion
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setVersion
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getCurrency
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setCurrency
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getTxDescription
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setTxDescription
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getLiveConnection
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setLiveConnection
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getTestConnection
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setTestConnection
     *
     * @return void
     */
    public function testGetSet()
    {
        $this->getSetCheck('live', true);
        $this->getSetCheck('name', 'the_name');
        $this->getSetCheck('merchant', 'the_merchant');
        $this->getSetCheck('version', '10.0');
        $this->getSetCheck('currency', 'GBP');
        $this->getSetCheck('txDescription', 'the_description');
        $this->getSetCheck('liveConnection', $this->getMock('SclZfCartPaypoint\Options\ConnectionOptions'));
        $this->getSetCheck('testConnection', $this->getMock('SclZfCartPaypoint\Options\ConnectionOptions'));
    }

    /**
     * Test the set*Connection method when passed an array.
     *
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getLiveConnection
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setLiveConnection
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getTestConnection
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setTestConnection
     *
     * @return void
     */
    public function testConnectionSettersWithArray()
    {
        $live = array(
            'url'      => 'live_url',
            'password' => 'live_pw',
        );
        $test = array(
            'url'      => 'test_url',
            'password' => 'test_pw',
        );

        $this->options->setLiveConnection($live);
        $this->options->setTestConnection($test);

        $liveConn = $this->options->getLiveConnection();
        $testConn = $this->options->getTestConnection();

        $this->assertEquals($live['url'], $liveConn->getUrl(), 'Live URL is incorrect.');
        $this->assertEquals($test['url'], $testConn->getUrl(), 'Test URL is incorrect.');

        $this->assertEquals($live['password'], $liveConn->getPassword(), 'Live password is incorrect.');
        $this->assertEquals($test['password'], $testConn->getPassword(), 'Test password is incorrect.');
    }

    /**
     * Check that when setLiveConnection is call with something that is not an
     * array or instance of ConnectionOptions that an exception is thrown.
     *
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setLiveConnection
     * @expectedException SclZfCartPaypoint\Exception\InvalidArgumentException
     *
     * @return void
     */
    public function testSetLiveConnectionWithBadValue()
    {
        $this->options->setLiveConnection(7);
    }

    /**
     * Check that when setTestConnection is call with something that is not an
     * array or instance of ConnectionOptions that an exception is thrown.
     *
     * @covers SclZfCartPaypoint\Options\PaypointOptions::setTestConnection
     * @expectedException SclZfCartPaypoint\Exception\InvalidArgumentException
     *
     * @return void
     */
    public function testSetTestConnectionWithBadValue()
    {
        $this->options->setTestConnection(7);
    }

    /**
     * testGetConnection
     *
     * @covers SclZfCartPaypoint\Options\PaypointOptions::getConnectionOptions
     *
     * @return void
     */
    public function testGetConnection()
    {
        $liveConnection = new ConnectionOptions();
        $liveConnection->setUrl('liveurl');
        $testConnection = new ConnectionOptions();
        $liveConnection->setUrl('testurl');

        $this->options->setLiveConnection($liveConnection);
        $this->options->setTestConnection($testConnection);

        $this->options->setLive(false);
        $this->assertEquals(
            $testConnection,
            $this->options->getConnectionOptions(),
            'Test options are wrong'
        );

        $this->options->setLive(true);
        $this->assertEquals(
            $liveConnection,
            $this->options->getConnectionOptions(),
            'Live options are wrong'
        );
    }
}
