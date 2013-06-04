<?php

namespace SclZfCartPaypoint\Controller;

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
     * Process the payment callback.
     *
     * @return Zend\Http\Response
     */
    public function callbackAction()
    {
        $request = $this->getRequest();

        $query = $request->getQuery();

//        $this->paypointService->processCallback($query);

        return $this->getResponse();
    }
}
