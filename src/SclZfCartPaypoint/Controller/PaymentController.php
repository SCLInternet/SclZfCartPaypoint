<?php

namespace SclZfCartPaypoint\Controller;

use SclZfCartPaypoint\Service\PaypointService;
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
     * __construct
     *
     * @param PaypointService $paypointService
     */
    public function __construct(PaypointService $paypointService)
    {
        $this->paypointService = $paypointService;
    }

    /**
     * Process the payment callback.
     *
     * @return Zend\Http\Response
     */
    public function callbackAction()
    {
        $request = $this->getRequest();

        $query = $request->getQuery();

        $this->paypointService->processCallback($query);

        return $this->getResponse();
    }
}
