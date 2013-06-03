<?php

namespace SclZfCartPaypointTests\Options;

use SclZfCartPaypoint\Options\ConnectionOptions;

/**
 * Unit tests for {@see ConnectionOptions}.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class ConnectionOptionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The instance to be tested
     *
     * @var ConnectionOptions
     */
    protected $options;

    /**
     * Prepare the object to be tested.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->options = new ConnectionOptions;
    }

    /**
     * Test the getters and setters
     *
     * @covers SclZfCartPaypoint\Options\ConnectionOptions::getUrl
     * @covers SclZfCartPaypoint\Options\ConnectionOptions::setUrl
     * @covers SclZfCartPaypoint\Options\ConnectionOptions::getPassword
     * @covers SclZfCartPaypoint\Options\ConnectionOptions::setPassword
     * @dataProvider getSetProvider
     *
     * @return void
     */
    public function testGetSet($param, $value)
    {
        $getter = 'get' . $param;
        $setter = 'set' . $param;

        $this->options->$setter($value);

        $this->assertEquals(
            $value,
            $this->options->$getter(),
            'Value for $' . $param . 'was incorrect.'
        );
    }

    /**
     * Provides values to test getters and setters
     *
     * @return array
     */
    public function getSetProvider()
    {
        return array(
            array('url', 'http://some.url'),
            array('password', 'secret'),
        );
    }
}
