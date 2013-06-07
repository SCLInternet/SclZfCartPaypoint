<?php

namespace SclZfCartPaypoint\Callback;

/**
 * Packages up the callback data nicely.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Callback
{
    /*
     * Status codes.
     */

    /**
     * Transaction authorised by bank. auth_code available as bank reference.
     */
    const STATUS_AUTHORISED = 'A';

    /**
     *  Transaction not authorised. Failure message text available to merchant.
     */
    const STATUS_NOT_AUTHORISED = 'N';

    /**
     * Communication problem. Trying again later may well work.
     */
    const STATUS_COMMUNICATION_ERROR = 'C';

    /**
     * The PayPoint.net system has detected a fraud condition and rejected the
     * transaction. The message field will contain more details.
     */
    const STATUS_FRAUD = 'F';

    /**
     * Pre-bank checks. Amount not supplied or invalid.
     */
    const STATUS_PRE_NO_AMOUNT = 'P:A';

    /**
     * Pre-bank checks. Not all mandatory parameters supplied.
     */
    const STATUS_PRE_MISSING_PARAMS = 'P:X';

    /**
     * Pre-bank checks. Same payment presented twice.
     */
    const STATUS_PRE_DUPLICATE_PAYMENT = 'P:P';

    /**
     * Pre-bank checks. Start date invalid.
     */
    const STATUS_PRE_START_DATE = 'P:S';

    /**
     * Pre-bank checks. Expiry date invalid.
     */
    const STATUS_PRE_EXPIRY_DATE = 'P:E';

    /**
     * Pre-bank checks. Issue number invalid.
     */
    const STATUS_PRE_ISSUE_NO = 'P:I';

    /**
     * Pre-bank checks. Card number fails LUHN check
     * (the card number is wrong).
     */
    const STATUS_PRE_LUHN = 'P:C';

    /**
     * Pre-bank checks. Card type invalid - i.e. does not match card number prefix.
     */
    const STATUS_TYPE = 'P:T';

    /**
     * Pre-bank checks. Customer name not supplied.
     */
    const STATUS_PRE_NAME = 'P:N';

    /**
     * Pre-bank checks. Merchant does not exist or not registered yet.
     */
    const STATUS_PRE_BAD_MERCHANT = 'P:M';

    /**
     * Pre-bank checks. Merchant account for card type does not exist.
     */
    const STATUS_PRE_CARD_TYPE = 'P:B';

    /**
     * Pre-bank checks. Merchant account for this currency does not exist.
     */
    const STATUS_CURRENCY = 'P:D';

    /**
     * Pre-bank checks. CV2 security code mandatory and not supplied / invalid.
     */
    const STATUS_CV2 = 'P:V';

    /**
     * Pre-bank checks. Transaction timed out awaiting a virtual circuit.
     * Merchant may not have enough virtual circuits for the volume of business.
     */
    const STATUS_TIMEOUT = 'P:R';

    /**
     * Pre-bank checks. No MD5 hash / token key set up against account.
     */
    const STATUS_TOKEN = 'P:#';

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

    protected $message;

    protected $responseCode;

    protected $amount;

    protected $code;

    protected $testStatus;

    protected $hash;

    /**
     * Possible values for the status code.
     */
    protected static $statusValues = array(
        self::STATUS_AUTHORISED,
        self::STATUS_NOT_AUTHORISED,
        self::STATUS_COMMUNICATION_ERROR,
        self::STATUS_FRAUD,
        self::STATUS_PRE_NO_AMOUNT,
        self::STATUS_PRE_MISSING_PARAMS,
        self::STATUS_PRE_DUPLICATE_PAYMENT,
        self::STATUS_PRE_START_DATE,
        self::STATUS_PRE_EXPIRY_DATE,
        self::STATUS_PRE_ISSUE_NO,
        self::STATUS_PRE_LUHN,
        self::STATUS_TYPE,
        self::STATUS_PRE_NAME,
        self::STATUS_PRE_BAD_MERCHANT,
        self::STATUS_PRE_CARD_TYPE,
        self::STATUS_CURRENCY,
        self::STATUS_CV2,
        self::STATUS_TIMEOUT,
        self::STATUS_TOKEN,
    );

    /**
     * Possible callback key values.
     */
    protected static $keyValues = array(
        self::KEY_TRANSACTION_ID,
        self::KEY_VALID,
        self::KEY_AUTH_CODE,
        self::KEY_CV2AVS,
        self::KEY_MESSAGE,
        self::KEY_RESPONSE_CODE,
        self::KEY_AMOUNT,
        self::KEY_CODE,
        self::KEY_TEST_STATUS,
        self::KEY_HASH,
    );
}
