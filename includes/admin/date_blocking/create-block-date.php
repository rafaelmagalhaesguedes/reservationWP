<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the start and end dates from the form
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Get the existing blocked dates
    $blocked_dates = get_option('reserva_veiculos_data_block_dates', array());

    // Add the new date range to the array
    $blocked_dates[] = array('start_date' => $start_date, 'end_date' => $end_date);

    // Save the updated array back to the database
    update_option('reserva_veiculos_data_block_dates', $blocked_dates);

    // Redirect back to the block dates page
    wp_redirect(admin_url('admin.php?page=reserva_veiculos_date_blocking_page'));
    exit;
}
?>

<style>
    .container-create-date {
        display: flex;
        flex-direction: column;
    }

    .back {
        margin: 10px 0;
        border-radius: 5px;
        color: #222;
    }

    .add-link {
        display: inline-block;
        margin: 10px 0;
        padding: 5px 10px;
        border-radius: 5px;
        background-color: #0073aa;
        color: white;
        text-decoration: none;
    }
    
    h2 {
        border-bottom: 1px solid #ccc;
        width: 50%;
    }

    form {
        width: 30%;
        display: flex;
        flex-direction: column;
    }

    label {
        margin-top: 5px;
    }

    input[type="date"] {
        margin-bottom: 20px;
    }

    input[type="submit"] {
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #0073aa;
        color: white;
        cursor: pointer;
        width: 50%;
        align-self: end;
    }

    @media (max-width: 768px) {
        form {
            width: 95%;
        }
    }
</style>

<div class="container-create-date">
    <h2>Bloquear Período</h2>
    <a href="<?php echo admin_url('admin.php?page=reserva_veiculos_date_blocking_page'); ?>" class="back">Voltar</a>
    <form method="post">
        <label for="start_date">Data inicial:</label>
        <input type="date" id="start_date" name="start_date" required>

        <label for="end_date">Data final:</label>
        <input type="date" id="end_date" name="end_date" required>

        <input type="submit" value="Bloquear período">
    </form>
</div>