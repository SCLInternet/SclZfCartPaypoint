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
     * Process the payment callback.
     *
     * @return Zend\Http\Response
     */
    public function callbackAction()
    {
        $request = $this->getRequest();

        $query = $request->getQuery();

        $this->getPaypointService()->processCallback($query);

        return $this->getResponse();
    }

    /**
     * getPaypointService
     *
     * @return PaypointService
     * @todo   Inject rather than rely on service locator
     */
    public function getPaypointService()
    {
        if (null === $this->paypointService) {
            $this->setPaypointService(
                $this->getServiceLocator()->get('SclZfCartPaypoint\Service\PaypointService')
            );
        }

        return $this->paypointService;
    }

    /**
     * setPaypointService
     *
     * @param  PaypointService $paypointService
     * @return self
     */
    public function setPaypointService(PaypointService $paypointService)
    {
        $this->paypointService = $paypointService;

        return $this;
    }
}
