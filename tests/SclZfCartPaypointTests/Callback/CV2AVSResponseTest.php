<?php

namespace SclZfCartPaypointTests\Callback;

use SclZfCartPaypoint\Callback\CV2AVSResponse;

/**
 * Unit tests for {@see CV2AVSResponse}.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CV2AVSResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The instance to be tested.
     *
     * @var CV2AVSResponse
     */
    protected $cv2avs;

    /**
     * Set up the instance to be tested.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->cv2avs = new CV2AVSResponse();
    }

    /**
     * Assert a the result from a given method is true/false.
     *
     * @param  string $method
     * @param  bool   $expected
     *
     * @return void
     */
    protected function checkValue($method, $expected)
    {
        $message = $method . '() should be ' . ($expected ? 'true' : 'false');

        if ($expected) {
            $this->assertTrue($this->cv2avs->$method(), $message);

            return;
        }

        $this->assertFalse($this->cv2avs->$method(), $message);
    }

    /**
     * Check all the values of the object.
     *
     * @param  bool $checked
     * @param  bool $code
     * @param  bool $address
     * @param  bool $postcode
     *
     * @return void
     */
    protected function checkValues($checked, $code, $address, $postcode)
    {
        $all = $code && $address && $postcode;

        $none = !$code && !$address && !$postcode;

        $this->checkValue('checked', $checked);
        $this->checkValue('allMatch', $all);
        $this->checkValue('codeMatch', $code);
        $this->checkValue('addressMatch', $address);
        $this->checkValue('postcodeMatch', $postcode);
        $this->checkValue('allMatch', $all);
        $this->checkValue('noMatch', $none);
    }

    /**
     * Test that all the values are set to false on initialisation.
     *
     * @return void
     */
    public function testInitialisedValues()
    {
        $this->checkValues(false, false, false, false);
    }

    /**
     * Test values for an ALL MATCH response.
     *
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::set
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::checked
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::allMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::codeMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::addressMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::postcodeMatch
     *
     * @return void
     */
    public function testAllMatch()
    {
        $this->cv2avs->set('ALL MATCH');

        $this->checkValues(true, true, true, true);
    }

    /**
     * Test values for an SECURITY CODE MATCH ONLY response.
     *
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::set
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::checked
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::allMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::codeMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::addressMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::postcodeMatch
     *
     * @return void
     */
    public function testSecurityMatchOnly()
    {
        $this->cv2avs->set('SECURITY CODE MATCH ONLY');

        $this->checkValues(true, true, false, false);
    }

    /**
     * Test values for an ADDRESS MATCH ONLY response.
     *
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::set
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::checked
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::allMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::codeMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::addressMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::postcodeMatch
     *
     * @return void
     */
    public function testAddressMatchOnly()
    {
        $this->cv2avs->set('ADDRESS MATCH ONLY');

        $this->checkValues(true, false, true, true);
    }

    /**
     * Test values for an NO DATA MATCHES response.
     *
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::set
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::checked
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::allMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::codeMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::addressMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::postcodeMatch
     *
     * @return void
     */
    public function testNoDataMatcheds()
    {
        $this->cv2avs->set('NO DATA MATCHES');

        $this->checkValues(true, false, false, false);
    }

    /**
     * Test values for an DATA NOT CHECKED response.
     *
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::set
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::checked
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::allMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::codeMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::addressMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::postcodeMatch
     *
     * @return void
     */
    public function testDataNotChecked()
    {
        $this->cv2avs->set('DATA NOT CHECKED');

        $this->checkValues(false, false, false, false);
    }

    /**
     * Test values for an PARTIAL ADDRESS MATCH / ADDRESS response.
     *
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::set
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::checked
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::allMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::codeMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::addressMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::postcodeMatch
     *
     * @return void
     */
    public function testAddressNoPostcode()
    {
        $this->cv2avs->set('PARTIAL ADDRESS MATCH / ADDRESS');

        $this->checkValues(true, false, true, false);
    }

    /**
     * Test values for an PARTIAL ADDRESS MATCH / POSTCODE response.
     *
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::set
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::checked
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::allMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::codeMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::addressMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::postcodeMatch
     *
     * @return void
     */
    public function testPostcodeNoAddress()
    {
        $this->cv2avs->set('PARTIAL ADDRESS MATCH / POSTCODE');

        $this->checkValues(true, false, false, true);
    }

    /**
     * Test values for an SECURITY CODE MATCH / POSTCODE response.
     *
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::set
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::checked
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::allMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::codeMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::addressMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::postcodeMatch
     *
     * @return void
     */
    public function testSecurityNoAddress()
    {
        $this->cv2avs->set('SECURITY CODE MATCH / POSTCODE');

        $this->checkValues(true, true, false, true);
    }

    /**
     * Test values for an SECURITY CODE MATCH / ADDRESS response.
     *
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::set
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::checked
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::allMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::codeMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::addressMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::postcodeMatch
     *
     * @return void
     */
    public function testSecurityNoPostcode()
    {
        $this->cv2avs->set('SECURITY CODE MATCH / ADDRESS');

        $this->checkValues(true, true, true, false);
    }

    /**
     * Test values for an SECURITY CODE MATCH / ADDRESS response.
     *
     * @depends testSecurityNoPostcode
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::set
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::checked
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::allMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::codeMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::addressMatch
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::postcodeMatch
     *
     * @return void
     */
    public function testConstructor()
    {
        $this->cv2avs = new CV2AVSResponse('SECURITY CODE MATCH / ADDRESS');

        $this->checkValues(true, true, true, false);
    }

    /**
     * Make sure an exception is thrown when an invalid status is set.
     *
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::set
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::validStatus
     * @expectedException SclZfCartPaypoint\Exception\DomainException
     *
     * @return void
     */
    public function testInvalidStatus()
    {
        $this->cv2avs->set('xxx');
    }

    /**
     * Test initializing the values via the constructor.
     *
     * @covers SclZfCartPaypoint\Callback\CV2AVSResponse::__construct
     *
     * @return void
     */
    public function testConstructWithValue()
    {
        $this->cv2avs->set('ALL MATCH');

        $this->checkValues(true, true, true, true);
    }
}
