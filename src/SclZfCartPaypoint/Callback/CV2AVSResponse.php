<?php

namespace SclZfCartPaypoint\Callback;

use SclZfCartPaypoint\Exception\DomainException;

/**
 * Process the value return from the CV2AVS system.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CV2AVSResponse
{
    /**
     * All the data provided matched that which the card issuer had on record.
     */
    const ALL_MATCH = 'ALL MATCH';

    /**
     * Only the security code matched
     */
    const CV2_ONLY = 'SECURITY CODE MATCH ONLY';

    /**
     * Only the address matched
     */
    const AVS_ONLY = 'ADDRESS MATCH ONLY';

    /**
     * None of the data matched
     */
    const NO_MATCH = 'NO DATA MATCHES';

    /**
     * The cv2avs system is unavailable or not supported by this card issuer.
     */
    const NOT_CHECKED = 'DATA NOT CHECKED';

    /**
     * The postcode matched but the address did not.
     */
    const POSTCODE_NO_ADDRESS = 'PARTIAL ADDRESS MATCH / POSTCODE';

    /**
     * The address matched but the postcode did not.
     */
    const ADDRESS_NO_POSTCODE = 'PARTIAL ADDRESS MATCH / ADDRESS';

    /**
     * The security code and postcodes matched but the address did not.
     */
    const SECURITY_NO_ADDRESS = 'SECURITY CODE MATCH / POSTCODE';

    /**
     * The security code and address matched but the postcode did not.
     */
    const SECURITY_NO_POSTCODE = 'SECURITY CODE MATCH / ADDRESS';

    /**
     * Were the CV2AVS details checked.
     *
     * @var bool
     */
    protected $checked = false;

    /**
     * Did the security code match.
     *
     * @var bool
     */
    protected $codeMatch = false;

    /**
     * Did the address match.
     *
     * @var bool
     */
    protected $addressMatch = false;

    /**
     * postcodeMatch
     *
     * @var bool
     */
    protected $postcodeMatch = false;

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
     * Set all values to false.
     *
     * @return void
     */
    protected function reset()
    {
        $this->checked       = false;
        $this->codeMatch     = false;
        $this->addressMatch  = false;
        $this->postcodeMatch = false;
    }

    /**
     * Set the matched parameter values.
     *
     * @param  bool $code
     * @param  bool $address
     * @param  bool $postcode
     *
     * @return void
     */
    protected function setMatchedValues($code, $address, $postcode)
    {
        $this->codeMatch     = $code;
        $this->addressMatch  = $address;
        $this->postcodeMatch = $postcode;
    }

    /**
     * Set the values from the response string.
     *
     * @param  string $status
     * @return void
     */
    public function set($status)
    {
        $this->reset();

        if (self::NOT_CHECKED === $status) {
            return;
        }

        $this->checked = true;

        if (self::NO_MATCH === $status) {
            return;
        }

        if (self::ALL_MATCH === $status) {
            $this->setMatchedValues(true, true, true);
            return;
        }

        if (self::CV2_ONLY === $status) {
            $this->setMatchedValues(true, false, false);
            return;
        }

        if (self::AVS_ONLY === $status) {
            $this->setMatchedValues(false, true, true);
            return;
        }

        if (self::ADDRESS_NO_POSTCODE === $status) {
            $this->setMatchedValues(false, true, false);
            return;
        }

        if (self::POSTCODE_NO_ADDRESS === $status) {
            $this->setMatchedValues(false, false, true);
            return;
        }

        if (self::SECURITY_NO_ADDRESS === $status) {
            $this->setMatchedValues(true, false, true);
            return;
        }

        if (self::SECURITY_NO_POSTCODE === $status) {
            $this->setMatchedValues(true, true, false);
            return;
        }

        throw new DomainException('Got unknown status "' . $status . '"');
    }

    /**
     * Was the data checked.
     *
     * @return bool
     */
    public function checked()
    {
        return $this->checked;
    }

    /**
     * Did all checks match.
     *
     * @return bool
     */
    public function allMatch()
    {
        return $this->checked
            && $this->codeMatch
            && $this->addressMatch
            && $this->postcodeMatch;
    }

    /**
     * Did nothing match.
     *
     * @return bool
     */
    public function noMatch()
    {
        return !$this->codeMatch
            && !$this->addressMatch
            && !$this->postcodeMatch;
    }

    /**
     * Did the CV2 security code match.
     *
     * @return bool
     */
    public function codeMatch()
    {
        return $this->codeMatch;
    }

    /**
     * Did the address match.
     *
     * @return bool
     */
    public function addressMatch()
    {
        return $this->addressMatch;
    }

    /**
     * Did the postcode match.
     *
     * @return bool
     */
    public function postcodeMatch()
    {
        return $this->postcodeMatch;
    }
}
