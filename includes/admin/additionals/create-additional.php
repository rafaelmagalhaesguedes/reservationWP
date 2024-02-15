<?php
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adicionais_data = get_option('reserva_veiculos_data_additionals', array());

    // Add the new additional service to the array
    $adicionais_data[] = array(
        'name' => sanitize_text_field($_POST['name']),
        'price' => sanitize_text_field($_POST['price']),
        'description' => sanitize_text_field($_POST['description']),
    );

    // Save the updated array
    update_option('reserva_veiculos_data_additionals', $adicionais_data);

    // Redirect back to the add-ons page
    wp_redirect(admin_url('admin.php?page=reserva_veiculos_adicionais_page'));
}
?>

<style>

    h2 {
        border-bottom: 1px solid #ccc;
        width: 50%;
    }

    form {
        display: flex;
        flex-direction: column;
        width: 50%;
    }

    label {
        margin-top: 10px;
    }

    input[type="text"] {
        margin-bottom: 10px;
    }

    textarea {
        margin-bottom: 10px;
        height: 100px;
    }

    input[type="submit"] {
        width: 100px;
        padding: 10px;
        border-radius: 5px;
        background-color: #0073aa;
        color: white;
        border: none;
        align-self: flex-end;
        cursor: pointer;
    }

    @media (max-width: 768px) {
        form {
            width: 95%;
        }
    }
</style>

<div>
    <h2>Adicionar Adicional</h2>
    <a href="<?php echo admin_url('admin.php?page=reserva_veiculos_adicionais_page'); ?>" class="page-title-action">Voltar</a>
    <!-- Form to add a new additional service -->
    <form method="post">
        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" required>

        <label for="price">Preço:</label>
        <input type="text" id="price" name="price" required>

        <label for="description">Descrição:</label>

        <textarea id="description" name="description" required></textarea>

        <input type="submit" value="Adicionar">
    </form>
</div>