<?php
// Check if the delete action is present in the URL and if the add-on index is set
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['index'])) {
    // Get the add-ons data
    $adicionais_data = get_option('reserva_veiculos_data_additionals', array());

    // Get the add-on index from the URL
    $index = $_GET['index'];

    // Remove the add-on from the $adicionais_data array
    unset($adicionais_data[$index]);

    // Save the updated add-ons data
    update_option('reserva_veiculos_data_additionals', $adicionais_data);

    // Redirect back to the add-ons page
    wp_redirect(admin_url('admin.php?page=reserva_veiculos_adicionais_page'));
    exit;
}
?>