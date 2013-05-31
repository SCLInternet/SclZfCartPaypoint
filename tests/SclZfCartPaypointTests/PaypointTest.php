<?php

namespace SclZfCartPaypointTests;

use SclZfCartPaypoint\Paypoint;
use Zend\Form\Form;

class PaypointTest extends \PHPUnit_Framework_TestCase
{
    protected $paypoint;

    protected $options;

    protected $connectionOptions;

    protected function setUp()
    {
        $this->options = $this->getMock('SclZfCartPaypoint\Options\PaypointOptions');

        $this->connectionOptions = $this->getMock('SclZfCartPaypoint\Options\ConnectionOptions');

        $this->options
             ->expects($this->any())
             ->method('getConnectionOptions')
             ->will($this->returnValue($this->connectionOptions));

        $this->paypoint = new Paypoint($this->options);
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

    public function testUpdateCompleteForm()
    {
        $formAction     = 'https://www.secpay.com/java-bin/ValCard';
        $merchant       = 'the_merchant';
        $amount         = 50.50;
        $callback       = 'https://callback_url';
        $transId        = 'TX-???';
        $remotePassword = 'secret_stuff';
        $digest         = md5($transId . $amount . $remotePassword);

        $this->connectionOptions
             ->expects($this->any())
             ->method('getUrl')
             ->will($this->returnValue($formAction));

        $this->options
             ->expects($this->any())
             ->method('getMerchant')
             ->will($this->returnValue($merchant));

        $form = new Form;
        $order = $this->getMock('SclZfCart\Entity\OrderInterface');

        $order->expects($this->any())
              ->method('getTotal')
              ->will($this->returnValue($amount));

        $result = $this->paypoint->updateCompleteForm($form, $order);

        $this->assertEquals($formAction, $form->getAttribute('action'), 'Form action is incorrect');

        $this->assertEquals($merchant, $form->get('merchant')->getValue());
        // @todo Test trans_id
        //$this->assertEquals($merchant, $form->get('trans_id')->getValue());
        $this->assertEquals($amount, $form->get('amount')->getValue());
        $this->assertEquals($callback, $form->get('callback')->getValue());
        $this->assertEquals($digest, $form->get('digest')->getValue());
    }
}
