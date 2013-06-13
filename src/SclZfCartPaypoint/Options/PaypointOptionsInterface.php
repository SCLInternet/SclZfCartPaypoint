<?php

namespace SclZfCartPaypoint\Options;

/**
 * Collects up the data that is needed for Paypoint and formats it as required.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface PaypointOptionsInterface
{
    /**
     * The system is running is test mode and will successfully validate test card numbers.
     */
    const MODE_TEST_TRUE  = 'true';

    /**
     * The system is running in test mode and will fail test card numbers.
     */
    const MODE_TEST_FALSE = 'false';

    /**
     * The system runs in live mode and transactions will be processed.
     */
    const MODE_LIVE       = 'live';

    /**
     * Gets the value of mode
     *
     * @return bool
     */
    public function getMode();

    /**
     * Sets the value of mode
     *
     * @param  string $mode Any of the MODE_* values.
     * @return self
     */
    public function setMode($mode);

    /**
     * Gets the value of name
     *
     * @return string
     */
    public function getName();

    /**
     * Sets the value of name
     *
     * @param  string $name
     * @return self
     */
    public function setName($name);

    /**
     * Gets the value of merchant
     *
     * @return string
     */
    public function getMerchant();

    /**
     * Sets the value of merchant
     *
     * @param  string $merchant
     * @return self
     */
    public function setMerchant($merchant);

    /**
     * Gets the value of currency
     *
     * @return string
     */
    public function getCurrency();

    /**
     * Sets the value of currency
     *
     * @param  string $Currency
     * @return self
     */
    public function setCurrency($currency);

    /**
     * Gets the value of txDescription
     *
     * @return string
     */
    public function getTxDescription();

    /**
     * Sets the value of txDescription
     *
     * @param  string $txDescription
     * @return self
     */
    public function setTxDescription($txDescription);

    /**
     * Gets the value of url
     *
     * @return string
     */
    public function getUrl();

    /**
     * Sets the value of url
     *
     * @param  string $url
     * @return string
     */
    public function setUrl($url);

    /**
     * Gets the value of livePassword
     *
     * @return string
     */
    public function getLivePassword();

    /**
     * Sets the value of livePassword
     *
     * @param  string $livePassword
     * @return self
     */
    public function setLivePassword($password);

    /**
     * Gets the value of testPassword
     *
     * @return string
     */
    public function getTestPassword();

    /**
     * Sets the value of testPassword
     *
     * @param  string $testPassword
     * @return self
     */
    public function setTestPassword($password);

    /**
     * Returns true if the system is configured to run in live mode.
     *
     * @return bool
     */
    public function isLive();

    /**
     * Returns the password for the selected mode.
     *
     * @return string
     */
    public function getActivePassword();
}
