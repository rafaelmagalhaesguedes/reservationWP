<?php
    function reserva_veiculos_date_blocking_page() {
    ?>
        <style>
            .add-link {
                display: inline-block;
                margin: 20px 0;
                padding: 5px 10px;
                border-radius: 5px;
                background-color: #0073aa;
                color: white;
                text-decoration: none;
            }
        </style>
        <div class="container-admin">
            <?php
                // Check if the add action is present in the URL
                if (isset($_GET['action']) && $_GET['action'] === 'add') {
                    include(plugin_dir_path(__FILE__) . 'create-block-date.php');
                    return;
                }

                // Check if the delete action is present in the URL and if the date index is set
                if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['index'])) {
                    include(plugin_dir_path(__FILE__) . 'delete-block-date.php');
                    return;
                }

                // Check if the edit action is present in the URL and if the date index is set
                if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['index'])) {
                    include(plugin_dir_path(__FILE__) . 'update-block-date.php');
                    return;
                }

                $block_dates_data = get_option('reserva_veiculos_data_block_dates', array());
            ?>

            <h2>Administrador de Bloqueio de Datas</h2>

            <a href="<?php echo admin_url('admin.php?page=reserva_veiculos_date_blocking_page&action=add'); ?>" class="add-link">Bloquear nova data</a>

            <!-- display table is in the admin_menu -->
            <?php display_table($block_dates_data, ['Data Inicial', 'Data Final'], 'reserva_veiculos_date_blocking_page', 'start_date', 'end_date'); ?>
        </div>
    <?php
    }
?>