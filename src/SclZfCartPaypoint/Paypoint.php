<?php

namespace SclZfCartPaypoint;

use SclZfCart\Entity\OrderInterface;
use SclZfCartPayment\PaymentMethodInterface;
use SclZfCartPaypoint\Data\CryptData;
use SclZfCartPaypoint\Options\PaypointOptions;
use Zend\Crypt\BlockCipher;
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

    /*
    const TX_TYPE_PAYMENT = 'PAYMENT';

    const CRYPT_VAR_TX_CODE      = 'VendorTxCode';
    const CRYPT_VAR_AMOUNT       = 'Amount';
    const CRYPT_VAR_CURRENCY     = 'Currency';
    const CRYPT_VAR_DESCRIPTION  = 'Description';
    const CRYPT_VAR_SUCCESS_URL  = 'SuccessURL';
    const CRYPT_VAR_FAILURE_URL  = 'FailureURL';
    */

    /**
     * @var PaypointOptions
     */
    private $options;

    /**
     *
     * @var BlockCipher
     */
    private $blockCipher;

    /**
     *
     * @var CryptData
     */
    private $cryptData;

    /**
     * @param PaypointOptions $options
     * @param BlockCipher     $blockCipher
     * @param CryptData       $cryptData
     */
    public function __construct(
        PaypointOptions $options
        //BlockCipher $blockCipher,
        //CryptData $cryptData
    ) {
        $this->options = $options;

        //$blockCipher->setKey((string) $options->password);
        //$this->blockCipher = $blockCipher;

        //$this->cryptData = $cryptData;
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
     *
     * @param Form $form
     * @param string $name
     * @param string $value
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
     * @param  OrderIntefface $order
     * @return string
     */
    /*
    private function getCrypt(OrderInterface $order)
    {
        $this->cryptData
            // @todo Use the SequenceGenerator
            ->add(self::CRYPT_VAR_TX_CODE, 'SCL-TX-')
            // @todo Cart::getAmount()
            ->add(self::CRYPT_VAR_AMOUNT, '')
            ->add(self::CRYPT_VAR_CURRENCY, $this->options->currency)
            ->add(self::CRYPT_VAR_DESCRIPTION, $this->options->transactionDescription)
            // @todo Get urls from routes in the options
            ->add(self::CRYPT_VAR_SUCCESS_URL, '')
            ->add(self::CRYPT_VAR_FAILURE_URL, '');

        $encrypted = $this->blockCipher->encrypt((string) $this->cryptData);

        return base64_encode($encrypted);
    }
    */

    /**
     * {@inheritDoc}
     *
     * @param  Form           $form
     * @param  OrderInterface $order
     * @return void
     */
    public function updateCompleteForm(Form $form, OrderInterface $order)
    {
        $form->setAttribute(
            'action',
            $this->options->getConnectionOptions()->getUrl()
        );

        // @todo Use the SequenceGenerator
        $transId = 'TX-???';
        $total = $order->getTotal();

        $digest = md5(
            $transId
            . $total
            . $this->options->getConnectionOptions()->getPassword()
        );

        $this->addHiddenField($form, self::VAR_MERCHANT, $this->options->getMerchant());
        $this->addHiddenField($form, self::VAR_TRANS_ID, $transId);
        $this->addHiddenField($form, self::VAR_AMOUNT, $total);
        // @todo Generate the callback url
        $this->addHiddenField($form, self::VAR_CALLBACK, '');
        $this->addHiddenField($form, self::VAR_DIGEST, $digest);
    }

    /**
     * {@inheritDoc}
     *
     * @param array $data
     * @return boolean Return true if the payment was successful
     */
    public function complete(array $data)
    {
    }
}
