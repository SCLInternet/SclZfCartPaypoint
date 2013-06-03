<?php

namespace SclZfCartPaypoint;

use SclZfCart\Entity\OrderInterface;
use SclZfCartPayment\Entity\PaymentInterface;
use SclZfCartPayment\PaymentMethodInterface;
use SclZfCartPaypoint\Options\PaypointOptions;
use SclZfUtilities\Route\UrlBuilder;
use Zend\Form\Form;

/**
 * The payment method to intgrate Paypoint into SclZfCartPayment
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Paypoint implements PaymentMethodInterface
{
    const VAR_MERCHANT = 'merchant';
    const VAR_TRANS_ID = 'trans_id';
    const VAR_AMOUNT   = 'amount';
    const VAR_CALLBACK = 'callback';
    const VAR_DIGEST   = 'digest';

    /**
     * @var PaypointOptions
     */
    protected $options;

    /**
     * Used to construct the callback URL.
     *
     * @var UrlBuilder
     */
    protected $urlBuilder;

    /**
     * @param PaypointOptions $options
     * @param UrlBuilder      $urlBuilder
     */
    public function __construct(
        PaypointOptions $options,
        UrlBuilder $urlBuilder
    ) {
        $this->options    = $options;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function name()
    {
        return $this->options->getName();
    }

    /**
     * Adds a hidden field element to the form.
     *
     * @param  Form   $form
     * @param  string $name
     * @param  string $value
     * @return void
     */
    protected function addHiddenField(Form $form, $name, $value)
    {
        $form->add(
            array(
                'name' => $name,
                'type' => 'Zend\Form\Element\Hidden',
                'attributes' => array(
                    'value' => $value
                )
            )
        );
    }

    /**
     * {@inheritDoc}
     *
     * @param  Form             $form
     * @param  OrderInterface   $order
     * @param  PaymentInterface $payment
     * @return void
     */
    public function updateCompleteForm(Form $form, OrderInterface $order, PaymentInterface $payment)
    {
        $form->setAttribute(
            'action',
            $this->options->getConnectionOptions()->getUrl()
        );

        // @todo Use the SequenceGenerator
        $transId = sprintf('TX-%06d', $payment->getId());
        $total = $order->getTotal();

        $digest = md5(
            $transId
            . $total
            . $this->options->getConnectionOptions()->getPassword()
        );

        $callbackUrl = $this->urlBuilder->getUrl('paypoint/callback');

        $this->addHiddenField($form, self::VAR_MERCHANT, $this->options->getMerchant());
        $this->addHiddenField($form, self::VAR_TRANS_ID, $transId);
        $this->addHiddenField($form, self::VAR_AMOUNT, $total);
        $this->addHiddenField($form, self::VAR_CALLBACK, $callbackUrl);
        $this->addHiddenField($form, self::VAR_DIGEST, $digest);
    }

    /**
     * {@inheritDoc}
     *
     * @param  array   $data
     * @return boolean Return true if the payment was successful
     */
    public function complete(array $data)
    {
    }
}
