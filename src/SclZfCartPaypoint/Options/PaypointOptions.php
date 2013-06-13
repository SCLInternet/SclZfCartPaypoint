<?php

namespace SclZfCartPaypoint\Options;

use SclZfCartPaypoint\Exception\DomainException;
use Zend\Stdlib\AbstractOptions;

/**
 * Collects up the data that is needed for Paypoint and formats it as required.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class PaypointOptions extends AbstractOptions implements PaypointOptionsInterface
{
    /**
     * Should the system be running live transactions.
     *
     * @var string
     */
    protected $mode;

    /**
     * The name of this payment method.
     *
     * @var string
     */
    protected $name;

    /**
     * The vendor merchant name.
     *
     * @var string
     */
    protected $merchant;

    /**
     * The currency to make transactions in.
     *
     * @var string
     */
    protected $currency;

    /**
     * The transaction description.
     *
     * @var string
     */
    protected $txDescription;

    /**
     * The URL of the Paypoint API.
     *
     * @var string
     */
    protected $url;

    /**
     * The password for the system in live mode.
     *
     * @var string
     */
    protected $livePassword;

    /**
     * The password for the system in test mode.
     *
     * @var string
     */
    protected $testPassword;

    /**
     * {@inheritDoc}
     *
     * @return bool
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $mode Any of the MODE_* values.
     * @return self
     * @throws DomainException If the mode is not one of the 3 allowed mode strings.
     */
    public function setMode($mode)
    {
        if (!in_array(
            $mode,
            array(self::MODE_TEST_TRUE, self::MODE_TEST_FALSE, self::MODE_LIVE)
        )) {
            throw new DomainException('Value of $mode was invalid; got "' . $mode .'"');
        }

        $this->mode = (string) $mode;
        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = (string) $name;
        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getMerchant()
    {
        return $this->merchant;
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $merchant
     * @return self
     */
    public function setMerchant($merchant)
    {
        $this->merchant = (string) $merchant;
        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $Currency
     * @return self
     */
    public function setCurrency($currency)
    {
        $this->currency = (string) $currency;
        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getTxDescription()
    {
        return $this->txDescription;
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $txDescription
     * @return self
     */
    public function setTxDescription($txDescription)
    {
        $this->txDescription = (string) $txDescription;
        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $url
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = (string) $url;
        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getLivePassword()
    {
        return $this->livePassword;
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $livePassword
     * @return self
     */
    public function setLivePassword($password)
    {
        $this->livePassword = $password;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getTestPassword()
    {
        return $this->testPassword;
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $testPassword
     * @return self
     */
    public function setTestPassword($password)
    {
        $this->testPassword = $password;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @return bool
     */
    public function isLive()
    {
        return (self::MODE_LIVE === $this->getMode());
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getActivePassword()
    {
        return ($this->isLive())
            ? $this->getLivePassword()
            : $this->getTestPassword();
    }
}
