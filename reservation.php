<?php
/*
    Plugin Name: RM Reservation
    Description: Plugin para reservas de veículos.
    Version: 2.0
    Author: Rafael M.
*/

if (!defined('ABSPATH')) {
    exit;
}

ob_start();

// Include scripts and styles
require_once plugin_dir_path(__FILE__) . 'includes/scripts.php';
require_once plugin_dir_path(__FILE__) . 'includes/styles.php';

// Include admin menu
include_once(plugin_dir_path(__FILE__) . 'includes/admin/admin_menu.php');

// Include activation function
require_once plugin_dir_path(__FILE__) . 'includes/activation.php';

// Register activation hook
register_activation_hook(__FILE__, 'reserva_veiculos_activation');

// Shortcode step 1
function reserva_veiculos_form_etapa_1_shortcode()
{
    ob_start();
    include(plugin_dir_path(__FILE__) . 'templates/form-etapa-1.php');
    return ob_get_clean();
}
add_shortcode('reserva_veiculos_form_etapa_1', 'reserva_veiculos_form_etapa_1_shortcode');

// Shortcode step 2
function reserva_veiculos_form_etapa_2_shortcode()
{
    ob_start();
    include(plugin_dir_path(__FILE__) . 'templates/form-etapa-2.php');
    return ob_get_clean();
}
add_shortcode('reserva_veiculos_form_etapa_2', 'reserva_veiculos_form_etapa_2_shortcode');

// Shortcode step 3
function reserva_veiculos_form_etapa_3_shortcode()
{
    ob_start();
    include(plugin_dir_path(__FILE__) . 'templates/form-etapa-3.php');
    return ob_get_clean();
}
add_shortcode('reserva_veiculos_form_etapa_3', 'reserva_veiculos_form_etapa_3_shortcode');

// Shortcode step 4
function reserva_veiculos_form_etapa_4_shortcode()
{
    ob_start();
    include(plugin_dir_path(__FILE__) . 'templates/form-etapa-4.php');
    return ob_get_clean();
}
add_shortcode('reserva_veiculos_form_etapa_4', 'reserva_veiculos_form_etapa_4_shortcode');
?>