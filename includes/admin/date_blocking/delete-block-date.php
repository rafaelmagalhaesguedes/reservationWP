<?php
    /* Delete block date */

    // Check if the delete action is present in the URL and if the date index is set
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['index'])) {
        // Get the block dates data
        $block_dates_data = get_option('reserva_veiculos_data_block_dates', array());

        // Get the date index
        $index = $_GET['index'];

        // Remove the date from the block dates data
        unset($block_dates_data[$index]);

        // Update the block dates data
        update_option('reserva_veiculos_data_block_dates', $block_dates_data);

        // Redirect back to the block dates page
        wp_redirect(admin_url('admin.php?page=reserva_veiculos_date_blocking_page'));
        
        exit;
    }
?>