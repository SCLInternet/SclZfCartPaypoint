<?php

namespace SclZfCartPaypoint\Options;

use SclZfCartPaypoint\Exception\InvalidArgumentException;
use Zend\Stdlib\AbstractOptions;

/**
 * Collects up the data that is needed for Paypoint and formats it as required.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class PaypointOptions extends AbstractOptions
{
    /**
     * Should the system be running live transactions.
     *
     * @var bool
     */
    protected $live;

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
     * The sagepay protocol version.
     *
     * @var string
     */
    protected $version;

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
     * liveConnection
     *
     * @var mixed
     */
    protected $liveConnection;

    /**
     * testConnection
     *
     * @var mixed
     */
    protected $testConnection;

    /**
     * Gets the value of live
     *
     * @return bool
     */
    public function getLive()
    {
        return $this->live;
    }

    /**
     * Sets the value of live
     *
     * @param  string $live
     * @return self
     */
    public function setLive($live)
    {
        $this->live = (string) $live;
        return $this;
    }

    /**
     * Gets the value of name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name
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
     * Gets the value of merchant
     *
     * @return string
     */
    public function getMerchant()
    {
        return $this->merchant;
    }

    /**
     * Sets the value of merchant
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
     * Gets the value of version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Sets the value of version
     *
     * @param  string $version
     * @return self
     */
    public function setVersion($version)
    {
        $this->version = (string) $version;
        return $this;
    }

    /**
     * Gets the value of currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Sets the value of currency
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
     * Gets the value of txDescription
     *
     * @return string
     */
    public function getTxDescription()
    {
        return $this->txDescription;
    }

    /**
     * Sets the value of txDescription
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
     * Gets the value of liveConnection
     *
     * @return ConnectionOptions
     */
    public function getLiveConnection()
    {
        return $this->liveConnection;
    }

    /**
     * Sets the value of liveConnection
     *
     * @param  ConnectionOptions|array $liveConnection
     * @return self
     */
    public function setLiveConnection($liveConnection)
    {
        if (is_array($liveConnection)) {
            $liveConnection = new ConnectionOptions($liveConnection);
        }

        if (!$liveConnection instanceof ConnectionOptions) {
            throw new InvalidArgumentException(
                '$liveConnection must be an instance of ConnectionOptions'
            );
        }

        $this->liveConnection = $liveConnection;

        return $this;
    }

    /**
     * Gets the value of testConnection
     *
     * @return ConnectionOptions
     */
    public function getTestConnection()
    {
        return $this->testConnection;
    }

    /**
     * Sets the value of testConnection
     *
     * @param  ConnectionOptions|array $testConnection
     * @return self
     */
    public function setTestConnection($testConnection)
    {
        if (is_array($testConnection)) {
            $testConnection = new ConnectionOptions($testConnection);
        }

        if (!$testConnection instanceof ConnectionOptions) {
            throw new InvalidArgumentException(
                '$testConnection must be an instance of ConnectionOptions'
            );
        }

        $this->testConnection = $testConnection;

        return $this;
    }

    /**
     * Returns the active connection options.
     *
     * @return ConnectionOptions
     */
    public function getConnectionOptions()
    {
        return $this->getLive()
            ? $this->getLiveConnection()
            : $this->getTestConnection();
    }
}
