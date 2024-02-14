<?php
/* 
  Enqueue scripts
*/
function reserva_veiculos_enqueue_scripts() {
    // Adicione a localização do script para uso no arquivo de script
    wp_localize_script('reserva-veiculos-script', 'reserva_veiculos_data', array(
        'whatsapp_api_url' => 'https://api.whatsapp.com/send',
    ));
}

add_action('wp_enqueue_scripts', 'reserva_veiculos_enqueue_scripts');
?>