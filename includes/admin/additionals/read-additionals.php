<?php
function reserva_veiculos_adicionais_page() {
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
            // Check if the edit action is present in the URL and if the add-on index is set
            if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['index'])) {
                include(plugin_dir_path(__FILE__) . 'update-additional.php');
                return;
            }

            // Check if the add action is present in the URL
            if (isset($_GET['action']) && $_GET['action'] === 'add') {
                include(plugin_dir_path(__FILE__) . 'create-additional.php');
                return;
            }

            // Check if the delete action is present in the URL and if the add-on index is set
            if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['index'])) {
                include(plugin_dir_path(__FILE__) . 'delete-additional.php');
                return;
            }

            $adicionais_data = get_option('reserva_veiculos_data_additionals', array());
        ?>

        <h2>Administrador de Adicionais</h2>

        <a href="<?php echo admin_url('admin.php?page=reserva_veiculos_adicionais_page&action=add'); ?>" class="add-link">Adicionar novo item</a>

        <!-- display table is in the admin_menu -->
        <?php display_table($adicionais_data, ['Adicionais', 'Preço', 'Descrição'], 'reserva_veiculos_adicionais_page', 'name', 'price', 'description'); ?>
    </div>
<?php
}
?>