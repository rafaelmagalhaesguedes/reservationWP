<?php
    // Processar o envio do formulário de edição
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reserva_veiculos_salvar_edicao'])) {
        $edit_index = intval($_POST['edit_veiculo_index']);

        // Verificar se o índice está dentro do intervalo válido
        if ($edit_index >= 0 && $edit_index < count($veiculos_data)) {
            // Processar o upload da nova imagem
            if (!empty($_FILES['edit_veiculo_image']['tmp_name'])) {
                $upload_dir = plugin_dir_path(__FILE__) . 'assets/images/'; // Diretório de upload dentro do seu plugin
                $file_name = $_FILES['edit_veiculo_image']['name'];
                $file_path = $upload_dir . $file_name;

                // Fazer upload da nova imagem
                move_uploaded_file($_FILES['edit_veiculo_image']['tmp_name'], $file_path);

                // Atualizar o caminho da imagem no banco de dados
                $veiculos_data[$edit_index]['image'] = plugin_dir_url(__FILE__) . '../assets/images/' . $file_name;
            }

            // Atualizar os dados do veículo editado
            $veiculos_data[$edit_index]['cars'] = sanitize_text_field($_POST['edit_veiculo_cars']);
            $veiculos_data[$edit_index]['category'] = sanitize_text_field($_POST['edit_veiculo_category']);
            $veiculos_data[$edit_index]['price'] = floatval($_POST['edit_veiculo_price']);

            // Salvar os dados atualizados no banco de dados
            update_option('reserva_veiculos_data_veiculos', $veiculos_data);

            // Redirecionar de volta para a página de administração
            wp_redirect(admin_url('options-general.php?page=reserva_veiculos_admin_page'));
            exit;
        }
    }

?>

<style>
    .container-admin {
        display: flex;
        flex-direction: column;
    }

    .form-user {
        display: flex;
        flex-direction: column;
        width: 50%;
    }

    .form-user input {
        margin-bottom: 10px;
    }

    .form-user label {
        margin-bottom: 10px;
    }

    .form-user input[type="submit"] {
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .form-user {
            width: 90%;
        }

        .form-user input {
            width: 100%;
        }
    }
</style>

<div class="container-admin">
    <h2>Editar Veículo</h2>

    <a href="<?php echo admin_url('admin.php?page=reserva_veiculos_adicionais_page'); ?>" class="page-title-action">Voltar</a>
    <br />

    <form class="form-user" method="post" action="">
        <input type="hidden" name="edit_veiculo_index" value="<?php echo esc_attr($index); ?>">

        <!-- <label for="edit_veiculo_image">Nova Imagem:</label>
        <input type="file" name="edit_veiculo_image" accept="image/*"> -->

        <label for="edit_veiculo_cars">Carros:</label>
        <input type="text" name="edit_veiculo_cars" value="<?php echo esc_html($veiculo_edit['cars']); ?>">

        <label for="edit_veiculo_category">Categoria:</label>
        <input type="text" name="edit_veiculo_category" value="<?php echo esc_html($veiculo_edit['category']); ?>">

        <label for="edit_veiculo_price">Preço:</label>
        <input type="text" name="edit_veiculo_price" value="<?php echo esc_attr($veiculo_edit['price']); ?>">

        <input type="submit" name="reserva_veiculos_salvar_edicao" value="Salvar Edição" class="button-primary">
    </form>
</div>
