<?php

namespace SclZfCartPaypointTests\Callback;

use SclZfCartPaypoint\Callback\Callback;

/**
 * Unit tests for {@see Callback}.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CallbackTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The instance to be tested.
     *
     * @var Callback
     */
    protected $callback;

    public function testInitialisation()
    {
        $this->callback = new Callback();
    }
}

