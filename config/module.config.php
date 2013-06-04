<?php

namespace SclZfCartPaypoint;

return array(
    'controllers' => array(
        'invokables' => array(
            __NAMESPACE__ . '\Controller\Payment' => __NAMESPACE__ . '\Controller\PaymentController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'paypoint' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route' => '/paypoint'
                ),
                'may_terminate' => false,
                'child_routes'  => array(
                    'callback' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/callback',
                            'defaults' => array(
                                'action'     => 'callback',
                                'controller' => __NAMESPACE__ . '\Controller\Payment',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
