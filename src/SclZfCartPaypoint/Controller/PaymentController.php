<?php

namespace SclZfCartPaypoint\Controller;

use SclZfCartPaypoint\Exception\DomainException;
use SclZfCartPaypoint\Service\HashChecker;
use SclZfCartPaypoint\Service\PaypointService;
use SclZfCartPaypoint\Callback\Callback;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Controller to process the payment callback.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class PaymentController extends AbstractActionController
{
    /**
     * paypointService
     *
     * @var PaypointService
     */
    protected $paypointService;

    /**
     * To validate the hash in the URI.
     *
     * @var HashChecker
     */
    protected $hashChecker;

    /**
     * __construct
     *
     * @param  PaypointService $paypointService
     * @param  HashChecker     $hashChecker
     */
    public function __construct(PaypointService $paypointService, HashChecker $hashChecker)
    {
        $this->paypointService = $paypointService;
        $this->hashChecker     = $hashChecker;
    }

    /**
     * Process the payment callback.
     *
     * @return Zend\Http\Response
     */
    public function callbackAction()
    {
        $request = $this->getRequest();

        if (!$this->hashChecker->isValid($request->getUri())) {
            throw new DomainException('URI doesn\'t contain a valid hash.');
        }

        $this->paypointService->processCallback($request);

        return $this->getResponse();
    }
}
