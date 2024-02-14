<?php

function reserva_veiculos_adicionais_page() {
?>
    <div class="container-admin">
        <?php
            $adicionais_data = get_option('reserva_veiculos_data_additionals', array());

            // Check if the edit action is present in the URL and if the add-on index is set
            if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['index'])) {
                $index = intval($_GET['index']);

                // Check if the index is within the valid range
                if ($index >= 0 && $index < count($adicionais_data)) {
                    $adicional_edit = $adicionais_data[$index];
                    include(plugin_dir_path(__FILE__) . 'edit-additional.php');
                    return;
                }
            }
        ?>

        <h2>Administrador de Adicionais</h2>

        <!-- display table is in the admin_menu -->
        <?php display_table($adicionais_data, ['Adicionais', 'Preço', 'Descrição'], 'reserva_veiculos_adicionais_page', 'name', 'price', 'description'); ?>
    </div>
<?php
}
?>