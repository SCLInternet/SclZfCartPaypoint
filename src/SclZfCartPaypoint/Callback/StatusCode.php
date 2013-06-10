<?php

namespace SclZfCartPaypoint\Callback;

use SclZfCartPaypoint\Exception\DomainException;

/**
 * Represents a paypoint callback status code.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class StatusCode
{
    /**
     * Transaction authorised by bank. auth_code available as bank reference.
     */
    const AUTHORISED = 'A';

    /**
     *  Transaction not authorised. Failure message text available to merchant.
     */
    const NOT_AUTHORISED = 'N';

    /**
     * Communication problem. Trying again later may well work.
     */
    const COMMUNICATION_ERROR = 'C';

    /**
     * The PayPoint.net system has detected a fraud condition and rejected the
     * transaction. The message field will contain more details.
     */
    const FRAUD = 'F';

    /**
     * Pre-bank checks. Amount not supplied or invalid.
     */
    const PRE_NO_AMOUNT = 'P:A';

    /**
     * Pre-bank checks. Not all mandatory parameters supplied.
     */
    const PRE_MISSING_PARAMS = 'P:X';

    /**
     * Pre-bank checks. Same payment presented twice.
     */
    const PRE_DUPLICATE_PAYMENT = 'P:P';

    /**
     * Pre-bank checks. Start date invalid.
     */
    const PRE_START_DATE = 'P:S';

    /**
     * Pre-bank checks. Expiry date invalid.
     */
    const PRE_EXPIRY_DATE = 'P:E';

    /**
     * Pre-bank checks. Issue number invalid.
     */
    const PRE_ISSUE_NO = 'P:I';

    /**
     * Pre-bank checks. Card number fails LUHN check
     * (the card number is wrong).
     */
    const PRE_LUHN = 'P:C';

    /**
     * Pre-bank checks. Card type invalid - i.e. does not match card number prefix.
     */
    const TYPE = 'P:T';

    /**
     * Pre-bank checks. Customer name not supplied.
     */
    const PRE_NAME = 'P:N';

    /**
     * Pre-bank checks. Merchant does not exist or not registered yet.
     */
    const PRE_BAD_MERCHANT = 'P:M';

    /**
     * Pre-bank checks. Merchant account for card type does not exist.
     */
    const PRE_CARD_TYPE = 'P:B';

    /**
     * Pre-bank checks. Merchant account for this currency does not exist.
     */
    const CURRENCY = 'P:D';

    /**
     * Pre-bank checks. CV2 security code mandatory and not supplied / invalid.
     */
    const CV2 = 'P:V';

    /**
     * Pre-bank checks. Transaction timed out awaiting a virtual circuit.
     * Merchant may not have enough virtual circuits for the volume of business.
     */
    const TIMEOUT = 'P:R';

    /**
     * Pre-bank checks. No MD5 hash / token key set up against account.
     */
    const TOKEN = 'P:#';

    /**
     * The status code.
     *
     * @var string
     */
    protected $status;

    /**
     * Possible values for the status code.
     */
    protected static $statusValues = array(
        self::AUTHORISED,
        self::NOT_AUTHORISED,
        self::COMMUNICATION_ERROR,
        self::FRAUD,
        self::PRE_NO_AMOUNT,
        self::PRE_MISSING_PARAMS,
        self::PRE_DUPLICATE_PAYMENT,
        self::PRE_START_DATE,
        self::PRE_EXPIRY_DATE,
        self::PRE_ISSUE_NO,
        self::PRE_LUHN,
        self::TYPE,
        self::PRE_NAME,
        self::PRE_BAD_MERCHANT,
        self::PRE_CARD_TYPE,
        self::CURRENCY,
        self::CV2,
        self::TIMEOUT,
        self::TOKEN,
    );

    /**
     * __construct
     *
     * @param  string $status
     */
    public function __construct($status = null)
    {
        if (null !== $status) {
            $this->set($status);
        }
    }

    /**
     * Set the value of the status code.
     *
     * @param  string $status
     * @return self
     */
    public function set($status)
    {
        if (!in_array($status, self::$statusValues)) {
            throw new DomainException(
                sprintf(
                    'Value of $status is invalid; got "%s".',
                    is_object($status) ? get_class($status) : gettype($status)
                )
            );
        }

        $this->status = $status;

        return $this;
    }

    /**
     * Return the value of the status code.
     *
     * @return string
     */
    public function value()
    {
        return $this->status;
    }
}
