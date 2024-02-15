<?php
$index = intval($_GET['index']);
$adicionais_data = get_option('reserva_veiculos_data_additionals', array());

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate the form data here

    // Update the add-on in the $adicionais_data array
    $adicionais_data[$index] = array(
        'name' => sanitize_text_field($_POST['name']),
        'price' => sanitize_text_field($_POST['price']),
        'description' => sanitize_text_field($_POST['description'])
    );

    // Save the updated add-ons data
    update_option('reserva_veiculos_data_additionals', $adicionais_data);

    // Redirect back to the add-ons page
    wp_redirect(admin_url('admin.php?page=reserva_veiculos_adicionais_page'));
    exit;
}

// Display the edit form
?>

<style>
    .container-admin {
        display: flex;
        flex-direction: column;
    }

    h2 {
        border-bottom: 1px solid #ccc;
        width: 100%;
    }

    form {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    label {
        margin-top: 10px;
    }

    input[type="text"] {
        margin-bottom: 10px;
    }

    textarea {
        margin-bottom: 10px;
        height: 150px;
    }

    .submit {
        width: 150px;
        padding: 10px;
        border-radius: 5px;
        background-color: #0073aa;
        color: white;
        border: none;
    }

    @media (max-width: 768px) {
        form {
            width: 95%;
        }
    }
</style>

<div class="container-admin">
    <h2>Editar Adicional</h2>

    <a href="<?php echo admin_url('admin.php?page=reserva_veiculos_adicionais_page'); ?>" class="page-title-action">Voltar</a>
    <br />

    <form method="post">
        <div class="form-group">
            <label for="name">Nome</label>
            <input name="name" id="name" type="text" value="<?php echo esc_attr($adicionais_data[$index]['name']); ?>" class="regular-text">
        </div>
        <div class="form-group">
            <label for="price">Preço</label>
            <input name="price" id="price" type="text" value="<?php echo esc_attr($adicionais_data[$index]['price']); ?>" class="regular-text">
        </div>
        <div class="form-group">
            <label for="description">Descrição</label>
            <textarea name="description" id="description" class="regular-text"><?php echo esc_textarea($adicionais_data[$index]['description']); ?></textarea>
        </div>
        
        <div class="button-edit">
            <input type="submit" name="submit" id="submit" class="submit" value="Salvar Alterações">
        </div>
    </form>
</div>