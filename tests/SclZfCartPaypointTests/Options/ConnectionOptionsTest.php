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
     *
     * @return void
     */
    public function testGetSet()
    {
        $url = 'http://some.url';
        $password = 'secret';

        $this->options->setUrl($url);
        $this->assertEquals(
            $url,
            $this->options->getUrl(),
            'URL is incorrect.'
        );

        $this->options->setPassword($password);
        $this->assertEquals(
            $password,
            $this->options->getPassword(),
            'password is incorrect.'
        );
    }
}
