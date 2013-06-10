<?php

namespace SclZfCartPaypoint\Callback;

use SclZfCartPaypoint\Exception\DomainException;
/**
 * Packages up the callback data nicely.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Callback
{
    /*
     * Response data keys
     */

    const KEY_TRANSACTION_ID = 'trans_id';
    const KEY_VALID          = 'valid';
    const KEY_AUTH_CODE      = 'auth_code';
    const KEY_CV2AVS         = 'cv2avs';
    const KEY_MESSAGE        = 'message';
    const KEY_RESPONSE_CODE  = 'resp_code';
    const KEY_AMOUNT         = 'amount';
    const KEY_CODE           = 'code';
    const KEY_TEST_STATUS    = 'test_status';
    const KEY_HASH           = 'hash';

    /**
     * The transaction id.
     *
     * @var string
     */
    protected $transactionId;

    /**
     * Were the card details accepted.
     *
     * @var bool
     */
    protected $valid;

    /**
     * Authorisation code from the bank.
     *
     * @var int
     */
    protected $authCode;

    /**
     * The result from the CV2AVS checks.
     *
     * @var CV2AVSResponse
     */
    protected $cv2avs;

    /**
     * A message is returned if the transaction is not authorized.
     *
     * @var string
     */
    protected $message;

    /**
     * The response code from the back is the transaction failed.
     *
     * @var int
     */
    protected $responseCode;

    /**
     * The amount authorized by th bank.
     *
     * @var mixed
     */
    protected $amount;

    /**
     * The status code returned from Paypoint.
     *
     * @var StatusCode
     */
    protected $code;

    /**
     * Was the API running in test mode.
     *
     * @var bool
     */
    protected $testStatus;

    /**
     * The verification hash.
     *
     * @var string
     */
    protected $hash;

    /**
     * setValueFromArray
     *
     * @param  array  $values
     * @param  string $key
     * @param  string $method
     * @return void
     */
    protected function setValueFromArray(array $values, $key, $method)
    {
        if (isset($values[$key])) {
            $this->$method($values[$key]);
        }
    }

    /**
     * setBoolStringValue
     *
     * @param  array  $values
     * @param  string $key
     * @param  string $method
     * @return void
     * @throws DomainException When value is not "true" or "false".
     */
    protected function setBoolStringValue(array $values, $key, $method)
    {
        if (!isset($values[$key])) {
            return;
        }

        if ('true' === $values[$key]) {
            $this->$method(true);
            return;
        }

        if ('false' === $values[$key]) {
            $this->$method(false);
            return;
        }

        throw new DomainException(
            sprintf(
                '$values[%s] must be "true" or "false"; got "%s"',
                $key,
                $values[$key]
            )
        );
    }

    /**
     * Set all the values of the callback object.
     *
     * @param  array $values
     * @return self
     */
    public function setCallbackValues(array $values)
    {
        $this->setValueFromArray($values, self::KEY_TRANSACTION_ID, 'setTransactionId');
        $this->setValueFromArray($values, self::KEY_AUTH_CODE, 'setAuthCode');
        $this->setValueFromArray($values, self::KEY_MESSAGE, 'setMessage');
        $this->setValueFromArray($values, self::KEY_AMOUNT, 'setAmount');
        $this->setValueFromArray($values, self::KEY_RESPONSE_CODE, 'setResponseCode');
        $this->setValueFromArray($values, self::KEY_HASH, 'setHash');

        $this->setBoolStringValue($values, self::KEY_VALID, 'setValid');
        $this->setBoolStringValue($values, self::KEY_TEST_STATUS, 'setTestStatus');

        if (isset($values[self::KEY_CV2AVS])) {
            $this->setCv2avs(new CV2AVSResponse($values[self::KEY_CV2AVS]));
        }

        if (isset($values[self::KEY_CODE])) {
            $this->setCode(new StatusCode($values[self::KEY_CODE]));
        }
    }

    /**
     * Gets the value of transactionId
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * Sets the value of transactionId
     *
     * @param  string $transactionId
     * @return self
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = (string) $transactionId;
        return $this;
    }

    /**
     * Gets the value of valid
     *
     * @return bool
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * Sets the value of valid
     *
     * @param  bool $valid
     * @return self
     */
    public function setValid($valid)
    {
        $this->valid = (bool) $valid;
        return $this;
    }

    /**
     * Gets the value of authCode
     *
     * @return int
     */
    public function getAuthCode()
    {
        return $this->authCode;
    }

    /**
     * Sets the value of authCode
     *
     * @param  int $authCode
     * @return self
     */
    public function setAuthCode($authCode)
    {
        $this->authCode = (int) $authCode;
        return $this;
    }

    /**
     * Gets the value of cv2avs
     *
     * @return CV2AVSResponse
     */
    public function getCv2avs()
    {
        return $this->cv2avs;
    }

    /**
     * Sets the value of cv2avs
     *
     * @param  CV2AVSResponse $cv2avs
     * @return self
     */
    public function setCv2avs(CV2AVSResponse $cv2avs)
    {
        $this->cv2avs = $cv2avs;
        return $this;
    }

    /**
     * Gets the value of message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets the value of message
     *
     * @param  string $message
     * @return self
     */
    public function setMessage($message)
    {
        $this->message = (string) $message;
        return $this;
    }

    /**
     * Gets the value of responseCode
     *
     * @return int
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * Sets the value of responseCode
     *
     * @param  int $responseCode
     * @return self
     */
    public function setResponseCode($responseCode)
    {
        $this->responseCode = (int) $responseCode;
        return $this;
    }

    /**
     * Gets the value of amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Sets the value of amount
     *
     * @param  float $amount
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = (float) $amount;
        return $this;
    }

    /**
     * Gets the value of code
     *
     * @return StatusCode
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets the value of code
     *
     * @param  StatusCode $code
     * @return self
     */
    public function setCode(StatusCode $code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Gets the value of testStatus
     *
     * @return bool
     */
    public function getTestStatus()
    {
        return $this->testStatus;
    }

    /**
     * Sets the value of testStatus
     *
     * @param  bool $testStatus
     * @return self
     */
    public function setTestStatus($testStatus)
    {
        $this->testStatus = (bool) $testStatus;
        return $this;
    }

    /**
     * Gets the value of hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Sets the value of hash
     *
     * @param  string $hash
     * @return self
     */
    public function setHash($hash)
    {
        $this->hash = (string) $hash;
        return $this;
    }
}
