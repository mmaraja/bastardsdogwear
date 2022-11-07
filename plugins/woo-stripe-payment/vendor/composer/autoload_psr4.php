<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(__DIR__);
$baseDir = dirname($vendorDir);

return array(
    'Stripe\\' => array($vendorDir . '/stripe/stripe-php/lib'),
    'PaymentPlugins\\WooFunnels\\Stripe\\' => array($baseDir . '/packages/woofunnels/src'),
    'PaymentPlugins\\Stripe\\WooCommerceSubscriptions\\' => array($baseDir . '/packages/subscriptions/src'),
    'PaymentPlugins\\Stripe\\WooCommercePreOrders\\' => array($baseDir . '/packages/preorders/src'),
    'PaymentPlugins\\Stripe\\GermanMarket\\' => array($baseDir . '/packages/germanmarket/src'),
    'PaymentPlugins\\Stripe\\' => array($baseDir . '/src'),
    'PaymentPlugins\\CheckoutWC\\Stripe\\' => array($baseDir . '/packages/checkoutwc/src'),
    'PaymentPlugins\\CartFlows\\Stripe\\' => array($baseDir . '/packages/cartflows/src'),
    'PaymentPlugins\\Blocks\\Stripe\\' => array($baseDir . '/packages/blocks/src'),
);
