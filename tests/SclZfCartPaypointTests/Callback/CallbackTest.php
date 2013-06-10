<?php

namespace SclZfCartPaypointTests\Callback;

use SclZfCartPaypoint\Callback\Callback;
use SclZfCartPaypoint\Callback\StatusCode;
use SclZfCartPaypoint\Callback\CV2AVSResponse;

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

    /**
     * Prepare the instance to be tested.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->callback = new Callback;
    }

    /**
     * testGettersAndSetters
     *
     * @dataProvider getSetDataProvider
     * @covers SclZfCartPaypoint\Callback\Callback::setTransactionId
     * @covers SclZfCartPaypoint\Callback\Callback::getTransactionId
     * @covers SclZfCartPaypoint\Callback\Callback::setValid
     * @covers SclZfCartPaypoint\Callback\Callback::getValid
     * @covers SclZfCartPaypoint\Callback\Callback::setAuthCode
     * @covers SclZfCartPaypoint\Callback\Callback::getAuthCode
     * @covers SclZfCartPaypoint\Callback\Callback::setCv2avs
     * @covers SclZfCartPaypoint\Callback\Callback::getCv2avs
     * @covers SclZfCartPaypoint\Callback\Callback::setMessage
     * @covers SclZfCartPaypoint\Callback\Callback::getMessage
     * @covers SclZfCartPaypoint\Callback\Callback::setResponseCode
     * @covers SclZfCartPaypoint\Callback\Callback::getResponseCode
     * @covers SclZfCartPaypoint\Callback\Callback::setAmount
     * @covers SclZfCartPaypoint\Callback\Callback::getAmount
     * @covers SclZfCartPaypoint\Callback\Callback::setCode
     * @covers SclZfCartPaypoint\Callback\Callback::getCode
     * @covers SclZfCartPaypoint\Callback\Callback::setTestStatus
     * @covers SclZfCartPaypoint\Callback\Callback::getTestStatus
     * @covers SclZfCartPaypoint\Callback\Callback::setHash
     * @covers SclZfCartPaypoint\Callback\Callback::getHash
     *
     * @param  string $name  The name of the get/set function to test.
     * @param  string $value The value to test with.
     * @return void
     */
    public function testGettersAndSetters($name, $value)
    {
        $getter = 'get' . $name;
        $setter = 'set' . $name;

        $result = $this->callback->$setter($value);

        $this->assertEquals(
            $this->callback,
            $result,
            $setter . ' is not fluid.'
        );

        $this->assertEquals(
            $value,
            $this->callback->$getter(),
            $getter . ' did not return the correct value.'
        );
    }

    /**
     * Provides the data to test the getters and setters.
     *
     * @return array
     */
    public function getSetDataProvider()
    {
        return array(
            array('transactionId', 'TRANSX'),
            array('valid', true),
            array('authCode', 8),
            array('cv2avs', new CV2AVSResponse()),
            array('message', 'BLAH'),
            array('responseCode', 12),
            array('amount', 5.99),
            array('code', new StatusCode()),
            array('testStatus', false),
            array('hash', 'abcxyz'),
        );
    }

    /**
     * Test setting the values of the callback object.
     *
     * @covers SclZfCartPaypoint\Callback\Callback::setCallbackValues
     * @covers SclZfCartPaypoint\Callback\Callback::setValueFromArray
     * @covers SclZfCartPaypoint\Callback\Callback::setBoolStringValue
     *
     * @return void
     */
    public function testSetCallbackValues()
    {
        $values = array(
            'trans_id'    => 'TR000',
            'valid'       => 'true',
            'auth_code'   => '99',
            'cv2avs'      => 'ALL MATCH',
            'message'     => 'SUCCESS',
            'resp_code'   => '21',
            'amount'      => '4.88',
            'code'        => 'A',
            'test_status' => 'false',
            'hash'        => 'LE_HASH',
        );

        $this->callback->setCallbackValues($values);

        $this->assertEquals(
            $values['trans_id'],
            $this->callback->getTransactionId(),
            'transactionId value is incorrect.'
        );

        $this->assertTrue(
            $this->callback->getValid(),
            'valid value is incorrect.'
        );

        $this->assertEquals(
            99,
            $this->callback->getAuthCode(),
            'authCode value is incorrect.'
        );

        $this->assertTrue(
            $this->callback->getCv2avs()->allMatch(),
            'cv2avs value is incorrect.'
        );

        $this->assertEquals(
            $values['message'],
            $this->callback->getMessage(),
            'message value is incorrect.'
        );

        $this->assertEquals(
            $values['resp_code'],
            $this->callback->getResponseCode(),
            'responseCode value is incorrect.'
        );

        $this->assertEquals(
            $values['amount'],
            $this->callback->getAmount(),
            'amount value is incorrect.'
        );

        $this->assertEquals(
            $values['code'],
            $this->callback->getCode()->value(),
            'code value is incorrect.'
        );

        $this->assertFalse(
            $this->callback->getTestStatus(),
            'testStatus value is incorrect.'
        );

        $this->assertEquals(
            $values['hash'],
            $this->callback->getHash(),
            'hash value is incorrect.'
        );
    }

    /**
     * Test that if a boolean value is not set then the value remains unset.
     *
     * @depends testSetCallbackValues
     * @covers SclZfCartPaypoint\Callback\Callback::setBoolStringValue
     *
     * @return void
     */
    public function testSetCallbackValuesWithNoBoolValue()
    {
        $this->callback->setCallbackValues(array());

        $this->assertNull($this->callback->getTestStatus());
    }

    /**
     * Test that an exception is thrown if a boolean value contains a string
     * which is not "true" or "false".
     *
     * @depends testSetCallbackValues
     * @covers SclZfCartPaypoint\Callback\Callback::setBoolStringValue
     * @expectedException SclZfCartPaypoint\Exception\DomainException
     *
     * @return void
     */
    public function testSetCallbackValuesWithBadBoolString()
    {
        $this->callback->setCallbackValues(array('test_status' => 'y'));
    }
}
