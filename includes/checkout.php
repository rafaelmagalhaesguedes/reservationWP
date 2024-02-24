<?php
    require_once(plugin_dir_path(__FILE__) . '../vendor/autoload.php');
    require_once(plugin_dir_path(__FILE__) . 'secrets.php');

    \Stripe\Stripe::setApiKey($stripeSecretKey );

    header('Content-Type: application/json');

    $YOUR_DOMAIN = 'http://localhost:3001';

    $checkout_session = \Stripe\Checkout\Session::create([
        'line_items' => [[
            'price' => 'price_1OnQx9Gl8SYs9ZebphiLlWFS',
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $YOUR_DOMAIN . '/success',
        'cancel_url' => $YOUR_DOMAIN . '/cancel',
    ]);

    header("HTTP/1.1 303 See Other");
    header("Location: " . $checkout_session->url);
?>