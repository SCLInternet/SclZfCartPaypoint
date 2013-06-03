<?php

namespace SclZfCartPaypointTests;

use SclZfCartPaypoint\Paypoint;
use Zend\Form\Form;

/**
 * PaypointTest
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class PaypointTest extends \PHPUnit_Framework_TestCase
{
    protected $paypoint;

    protected $options;

    protected $connectionOptions;

    protected $urlBuilder;

    protected function setUp()
    {
        $this->options = $this->getMock('SclZfCartPaypoint\Options\PaypointOptions');

        $this->connectionOptions = $this->getMock('SclZfCartPaypoint\Options\ConnectionOptions');

        $this->urlBuilder = $this->getMock('SclZfUtilities\Route\UrlBuilder');

        $this->options
             ->expects($this->any())
             ->method('getConnectionOptions')
             ->will($this->returnValue($this->connectionOptions));

        $this->paypoint = new Paypoint(
            $this->options,
            $this->urlBuilder
        );
    }

    /**
     * testName
     *
     * @covers SclZfCartPaypoint\Paypoint::name
     *
     * @return void
     */
    public function testName()
    {
        $name = 'Paypoint';

        $this->options
             ->expects($this->once())
             ->method('getName')
             ->will($this->returnValue($name));

        $this->assertEquals($name, $this->paypoint->name());
    }

    /**
     * Test that updateCompleteFrom makes the approprate modifactions to the form.
     *
     * @covers SclZfCartPaypoint\Paypoint::updateCompleteForm
     * @covers SclZfCartPaypoint\Paypoint::addHiddenField
     *
     * @return void
     */
    public function testUpdateCompleteForm()
    {
        $formAction     = 'https://www.secpay.com/java-bin/ValCard';
        $merchant       = 'the_merchant';
        $amount         = 50.50;
        $callback       = 'https://callback_url';
        $transId        = 'TX-000005';
        $remotePassword = 'secret_stuff';
        $digest         = md5($transId . $amount . $remotePassword);

        $form  = new Form;
        $order = $this->getMock('SclZfCart\Entity\OrderInterface');
        $payment = $this->getMock('SclZfCartPayment\Entity\PaymentInterface');

        $this->connectionOptions
             ->expects($this->any())
             ->method('getUrl')
             ->will($this->returnValue($formAction));

        $this->options
             ->expects($this->any())
             ->method('getMerchant')
             ->will($this->returnValue($merchant));

        $this->urlBuilder
             ->expects($this->any())
             ->method('getUrl')
             ->with($this->equalTo('paypoint/callback'))
             ->will($this->returnValue($callback));

        $order->expects($this->any())
              ->method('getTotal')
              ->will($this->returnValue($amount));

        $this->connectionOptions
             ->expects($this->any())
             ->method('getPassword')
             ->will($this->returnValue($remotePassword));

        $payment->expects($this->any())
                ->method('getId')
                ->will($this->returnValue(5));

        $result = $this->paypoint->updateCompleteForm($form, $order, $payment);

        $this->assertEquals($formAction, $form->getAttribute('action'), 'Form action is incorrect');

        $this->assertEquals($merchant, $form->get('merchant')->getValue());
        // @todo Test trans_id
        //$this->assertEquals($merchant, $form->get('trans_id')->getValue());
        $this->assertEquals($amount, $form->get('amount')->getValue());
        $this->assertEquals($callback, $form->get('callback')->getValue());
        $this->assertEquals($digest, $form->get('digest')->getValue());
    }
}
