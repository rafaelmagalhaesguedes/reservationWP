<?php
if (!defined('ABSPATH')) {
    exit;
}

include 'categories/read-categories.php';
include 'additionals/read-additionals.php';
include 'date_blocking/index.php';
include 'utils/display_table.php';

// Adicione ao menu principal de configurações
function reserva_veiculos_admin_menu()
{
    // Adicione o menu principal
    add_menu_page(
        'Águia Locadora', // título da página
        'Águia Locadora', // nome no menu
        'manage_options', // capacidade necessária
        'reserva_veiculos_admin_page', // identificador exclusivo da página
        '', // função de callback para renderizar a página
        'dashicons-car', // ícone do menu
        3 // posição no menu
    );

    // Menu de subpágina para configurações de veículos
    add_submenu_page(
        'reserva_veiculos_admin_page', // menu pai (Águia Locadora)
        'Configurações de Veículos', // título da página
        'Configurações de Veículos', // nome no menu
        'manage_options', // capacidade necessária
        'reserva_veiculos_admin_page', // identificador exclusivo da página
        'reserva_veiculos_preco_categoria_page' // função de callback para renderizar a página
    );

    // Menu de subpágina para configurações de adicionais
    add_submenu_page(
        'reserva_veiculos_admin_page', // menu pai (Águia Locadora)
        'Configurações de Adicionais', // título da página
        'Configurações de Adicionais', // nome no menu
        'manage_options', // capacidade necessária
        'reserva_veiculos_adicionais_page', // unique page identifier
        'reserva_veiculos_adicionais_page' 
    );

    // Menu de subpágina para configurações de bloqueio de datas
    add_submenu_page(
        'reserva_veiculos_admin_page', // menu pai (Águia Locadora)
        'Configurações de Bloqueio', // título da página
        'Configurações de Bloqueio', // nome no menu
        'manage_options', // capacidade necessária
        'reserva_veiculos_date_blocking_page', // unique page identifier
        'reserva_veiculos_date_blocking_page' 
    );
}
add_action('admin_menu', 'reserva_veiculos_admin_menu');
?>