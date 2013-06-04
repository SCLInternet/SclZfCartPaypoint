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
     * Process the payment callback.
     *
     * @return void
     */
    public function callbackAction()
    {
        echo "STUFF";
//        return $this->getResponse();
    }
}
