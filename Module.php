<?php

namespace SclZfCartPaypoint;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * This module provides them implementation for using Paypoint with
 * SclZfCartPayement
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ControllerProviderInterface,
    ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * {@inheritDoc}
     *
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * {@inheritDoc}
     *
     * @return array
     */
    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'SclZfCartPaypoint\Controller\Payment' => function ($cm) {
                    $sm = $cm->getServiceLocator();

                    return new \SclZfCartPaypoint\Controller\PaymentController(
                        $sm->get('SclZfCartPaypoint\Service\PaypointService')
                    );
                },
            ),
        );
    }
    /**
     * {@inheritDoc}
     *
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'SclZfCartPaypoint\Service\PaypointService' => function ($sm) {
                    return new \SclZfCartPaypoint\Service\PaypointService();
                },
            ),
        );
    }
}
