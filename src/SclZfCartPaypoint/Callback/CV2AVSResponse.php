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
     * The status string.
     *
     * @var string
     */
    protected $status = self::NOT_CHECKED;

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

    protected function validStatus($status)
    {
        return in_array(
            $status,
            array(
                self::ALL_MATCH,
                self::CV2_ONLY,
                self::AVS_ONLY,
                self::NO_MATCH,
                self::NOT_CHECKED,
                self::POSTCODE_NO_ADDRESS,
                self::ADDRESS_NO_POSTCODE,
                self::SECURITY_NO_ADDRESS,
                self::SECURITY_NO_POSTCODE,
            )
        );
    }

    /**
     * Set the values from the response string.
     *
     * @param  string $status
     * @return void
     * @throws DomainException When invalid status is given
     */
    public function set($status)
    {
        if (!$this->validStatus($status)) {
            throw new DomainException('Got unknown status "' . $status . '"');
        }

        $this->status = $status;
    }

    /**
     * Was the data checked.
     *
     * @return bool
     */
    public function checked()
    {
        return self::NOT_CHECKED !== $this->status;
    }

    /**
     * Did all checks match.
     *
     * @return bool
     */
    public function allMatch()
    {
        return self::ALL_MATCH  === $this->status;
    }

    /**
     * Did nothing match.
     *
     * @return bool
     */
    public function noMatch()
    {
        return self::NOT_CHECKED === $this->status
            || self::NO_MATCH === $this->status;
    }

    /**
     * Did the CV2 security code match.
     *
     * @return bool
     */
    public function codeMatch()
    {
        return self::ALL_MATCH  === $this->status
            || self::CV2_ONLY  === $this->status
            || self::SECURITY_NO_ADDRESS  === $this->status
            || self::SECURITY_NO_POSTCODE === $this->status;
    }

    /**
     * Did the address match.
     *
     * @return bool
     */
    public function addressMatch()
    {
        return self::ALL_MATCH  === $this->status
            || self::AVS_ONLY  === $this->status
            || self::ADDRESS_NO_POSTCODE  === $this->status
            || self::SECURITY_NO_POSTCODE === $this->status;
    }

    /**
     * Did the postcode match.
     *
     * @return bool
     */
    public function postcodeMatch()
    {
        return self::ALL_MATCH  === $this->status
            || self::AVS_ONLY  === $this->status
            || self::POSTCODE_NO_ADDRESS  === $this->status
            || self::SECURITY_NO_ADDRESS === $this->status;
    }
}
