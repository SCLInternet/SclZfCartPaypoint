<?php

namespace SclZfCartPaypoint\Service;

use SclZfCartPaypoint\Callback\Callback;
use Zend\Http\Request;

/**
 * Perform actions need to make payments through paypoint.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class PaypointService
{
    const TRANSACTION_SUCCESS = 0;
    const TRANSACTION_FAILED  = 1;
    const BAD_CALLBACK        = 2;

    /**
     * Used to verify a callback URL.
     *
     * @var HashChecker
     */
    protected $hashChecker;

    /**
     * __construct
     *
     * @param HashChecker $hashChecker
     */
    public function __construct(HashChecker $hashChecker)
    {
        $this->hashChecker = $hashChecker;
    }

    /**
     * Takes the request object from a Paypoint transaction callback and completes
     * or fails the transaction.
     *
     * @param  Request $request The request object from the callback page.
     * @return void
     */
    public function processCallback(Request $request)
    {
        if (!$this->hashChecker->isValid($request->getUri())) {
            return self::BAD_CALLBACK;
        }

        // Create callback

        // Load tansaction

    }
}
