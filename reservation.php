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
function vehicles_reservation_step_1()
{
    ob_start();
    include(plugin_dir_path(__FILE__) . 'templates/form-step-1.php');
    return ob_get_clean();
}
add_shortcode('step_1', 'vehicles_reservation_step_1');

// Shortcode step 2
function vehicles_reservation_step_2()
{
    ob_start();
    include(plugin_dir_path(__FILE__) . 'templates/form-step-2.php');
    return ob_get_clean();
}
add_shortcode('step_2', 'vehicles_reservation_step_2');

// Shortcode step 3
function vehicles_reservation_step_3()
{
    ob_start();
    include(plugin_dir_path(__FILE__) . 'templates/form-step-3.php');
    return ob_get_clean();
}
add_shortcode('step_3', 'vehicles_reservation_step_3');

// Shortcode step 4
function vehicles_reservation_step_4()
{
    ob_start();
    include(plugin_dir_path(__FILE__) . 'templates/form-step-4.php');
    return ob_get_clean();
}
add_shortcode('step_4', 'vehicles_reservation_step_4');
?>