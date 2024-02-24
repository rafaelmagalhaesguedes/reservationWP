<?php
/* 
  Enqueue scripts
*/
function reserva_veiculos_enqueue_scripts() {
    // Enqueue Mercado Pago SDK v2
    wp_enqueue_script('mercadopago-sdk-v2', 'https://sdk.mercadopago.com/js/v2', array(), null, true);

    // Localize script for use in script file
    wp_localize_script('reserva-veiculos-script', 'reserva_veiculos_data', array(
        'whatsapp_api_url' => 'https://api.whatsapp.com/send',
    ));
}

add_action('wp_enqueue_scripts', 'reserva_veiculos_enqueue_scripts');
?>