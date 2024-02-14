<?php
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
<div class="container-admin">
    <h2>Editar Adicional</h2>

    <a href="<?php echo admin_url('admin.php?page=reserva_veiculos_adicionais_page'); ?>" class="page-title-action">Voltar</a>
    <br />

    <form method="post">
        <table class="form-table">
            <tr>
                <th scope="row"><label for="name">Nome</label></th>
                <td><input name="name" id="name" type="text" value="<?php echo esc_attr($adicional_edit['name']); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="price">Preço</label></th>
                <td><input name="price" id="price" type="text" value="<?php echo esc_attr($adicional_edit['price']); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="description">Descrição</label></th>
                <td><textarea name="description" id="description" class="regular-text"><?php echo esc_textarea($adicional_edit['description']); ?></textarea></td>
        </table>

        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Salvar Alterações">
        </p>
    </form>
</div>