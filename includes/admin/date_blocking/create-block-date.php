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

<h2>Bloquear novo período</h2>

<form method="post">
    <label for="start_date">Data inicial:</label>
    <input type="date" id="start_date" name="start_date" required>

    <label for="end_date">Data final:</label>
    <input type="date" id="end_date" name="end_date" required>

    <input type="submit" value="Bloquear período">
</form>