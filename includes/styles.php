<?php
/* 
  Enqueue styles
*/
function reserva_veiculos_enqueue_styles() {
    // Enqueue o arquivo de estilo principal
    wp_enqueue_style('reserva-veiculos-style', plugin_dir_url(__FILE__) . '../assets/styles/etapa-1.css');

    // Enqueue o arquivo de estilo painel de administração
    if (is_admin()) {
        wp_enqueue_style('reserva-veiculos-admin-style', plugin_dir_url(__FILE__) . '../assets/styles/admin.css');
    }
    
    // Enqueue o arquivo de estilo específico para o formulário da Etapa 2
    if (is_page('etapa2')) {
        wp_enqueue_style('reserva-veiculos-etapa-2-style', plugin_dir_url(__FILE__) . '../assets/styles/etapa-2.css');
    }

    // Enqueue o arquivo de estilo específico para o formulário da Etapa 3
    if (is_page('etapa3')) {
        wp_enqueue_style('reserva-veiculos-etapa-3-style', plugin_dir_url(__FILE__) . '../assets/styles/etapa-3.css');
    }

    // Enqueue o arquivo de estilo específico para o Resumo da reserva
    if (is_page('etapa4')) {
        wp_enqueue_style('reserva-veiculos-resumo-style', plugin_dir_url(__FILE__) . '../assets/styles/etapa-4.css');
    }

    // Enqueue o arquivo de estilo específico para o Resumo da reserva
    if (is_page('etapa5')) {
        wp_enqueue_style('reserva-veiculos-etapa-4-style', plugin_dir_url(__FILE__) . '../assets/styles/resumo.css');
    }
}

add_action('wp_enqueue_scripts', 'reserva_veiculos_enqueue_styles');
?>