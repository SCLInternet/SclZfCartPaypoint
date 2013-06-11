<?php

namespace SclZfCartPaypointTests\Service;

use SclZfCartPaypoint\Service\HashChecker;

/**
 * Unit tests for {@see HashChecker}.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class HashCheckerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test digest password.
     */
    const DIGEST_KEY = 'top-secret';

    /**
     * HashChecker
     *
     * @var mixed
     */
    protected $checker;

    /**
     * Setup the instance to be tested
     *
     * @return void
     */
    protected function setUp()
    {
        $this->checker = new HashChecker(self::DIGEST_KEY);
    }

    /**
     * When a good hash is given test the isValid method returns true.
     *
     * @covers SclZfCartPaypoint\Service\HashChecker::isValid
     * @covers SclZfCartPaypoint\Service\HashChecker::__construct
     *
     * @return void
     */
    public function testGoodHash()
    {
        $hashablePart = '/callback.php?valid=true&trans_id=001&';

        $uri = $hashablePart . 'hash=' . md5($hashablePart . self::DIGEST_KEY);

        $this->assertTrue($this->checker->isValid($uri));
    }

    /**
     * When a bad hash is given test the isValid method returns false.
     *
     * @covers SclZfCartPaypoint\Service\HashChecker::isValid
     *
     * @return void
     */
    public function testBadHash()
    {
        $uri = '/callback.php?valid=true&trans_id=001&hash=174af8acde72bc7dea9f2bae432d8a34';

        $this->assertFalse($this->checker->isValid($uri));
    }

    /**
     * If the URI doesn't end with a hash prameter then an exception is throw.
     *
     * @covers SclZfCartPaypoint\Service\HashChecker::isValid
     *
     * @return void
     */
    public function testBadUri()
    {
        $this->assertFalse($this->checker->isValid('/callback.php?valid=true&trans_id=001'));
    }
}
