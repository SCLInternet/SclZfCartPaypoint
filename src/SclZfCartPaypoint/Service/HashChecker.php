<?php

namespace SclZfCartPaypoint\Service;

/**
 * Verify is a callback URI's hash is valid.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class HashChecker
{
    /**
     * The digest key.
     *
     * @var string
     */
    protected $digestKey;

    /**
     * __construct
     *
     * @param  mixed $digestKey
     */
    public function __construct($digestKey)
    {
        $this->digestKey = (string) $digestKey;
    }

    /**
     * Check if a URI hash is valid.
     *
     * @param  string $uri
     * @return bool
     */
    public function isValid($uri)
    {
        $matches = array();

        if (!preg_match('/^(.*&)hash=([0-9a-f]{32})$/', $uri, $matches)) {
            return false;
        }

        $uri = $matches[1];
        $hash = $matches[2];

        return $hash == md5($uri . $this->digestKey);
    }
}
