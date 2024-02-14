<?php
function reserva_veiculos_adicionais_page() {
?>
    <div class="container-admin">
        <?php
            // Check if the edit action is present in the URL and if the add-on index is set
            if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['index'])) {
                include(plugin_dir_path(__FILE__) . 'edit-additional.php');
                return;
            }

            // Check if the add action is present in the URL
            if (isset($_GET['action']) && $_GET['action'] === 'add') {
                include(plugin_dir_path(__FILE__) . 'add-additional.php');
                return;
            }

            $adicionais_data = get_option('reserva_veiculos_data_additionals', array());
        ?>

        <h2>Administrador de Adicionais</h2>

        <a href="<?php echo admin_url('admin.php?page=reserva_veiculos_adicionais_page&action=add'); ?>" class="page-title">Adicionar Novo</a>

        <!-- display table is in the admin_menu -->
        <?php display_table($adicionais_data, ['Adicionais', 'Preço', 'Descrição'], 'reserva_veiculos_adicionais_page', 'name', 'price', 'description'); ?>
    </div>
<?php
}
?>