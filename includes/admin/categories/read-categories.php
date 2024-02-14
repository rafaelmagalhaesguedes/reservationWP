<?php
function reserva_veiculos_preco_categoria_page(){
?>
    <div class="container-admin">
        <?php
            $veiculos_data = get_option('reserva_veiculos_data_veiculos', array());

            // Check if the edit action is present in the URL and if the vehicle index is set
            if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['index'])) {
                $index = intval($_GET['index']);

                // Check if the index is within the valid range
                if ($index >= 0 && $index < count($veiculos_data)) {
                    $veiculo_edit = $veiculos_data[$index];
                    include(plugin_dir_path(__FILE__) . 'edit-category.php');
                    return;
                }
            }
        ?>

        <h2>Administrador de Categorias</h2>

        <!-- display table is in the admin_menu -->
        <?php display_table($veiculos_data, ['Veículos', 'Categoria', 'Preço'], 'reserva_veiculos_admin_page', 'cars', 'category', 'price'); ?>
    </div>
<?php
}
?>