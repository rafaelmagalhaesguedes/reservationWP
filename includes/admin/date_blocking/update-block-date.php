<?php
    /* Edit block date */

    // Check if the edit action is present in the URL and if the date index is set
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['index'])) {
        // Get the block dates data
        $block_dates_data = get_option('reserva_veiculos_data_block_dates', array());

        // Get the date index
        $index = $_GET['index'];

        // Get the date from the block dates data
        $date = $block_dates_data[$index];

        // Check if the date is set
        if (isset($date)) {
            // Check if the form is submitted
            if (isset($_POST['submit'])) {
                // Get the start date and end date from the form
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];

                // Update the date in the block dates data
                $block_dates_data[$index] = array(
                    'start_date' => $start_date,
                    'end_date' => $end_date
                );

                // Update the block dates data
                update_option('reserva_veiculos_data_block_dates', $block_dates_data);

                // Redirect back to the block dates page
                wp_redirect(admin_url('admin.php?page=reserva_veiculos_date_blocking_page'));

                exit;
            }
        }
    }
?>

<style>
    .container-edit-date {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .add-link {
        display: inline-block;
        margin: 20px 0;
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
        display: flex;
        flex-direction: column;
        width: 50%;
    }

    label {
        margin-top: 10px;
    }

    input[type="date"] {
        margin-bottom: 10px;
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

<div class="container-edit-date">
    <h2>Editar período</h2>

    <form method="post">
        <label for="start_date">Data inicial:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo $date['start_date']; ?>" required>

        <label for="end_date">Data final:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo $date['end_date']; ?>" required>

        <input type="submit" name="submit" value="Editar período">
    </form>
</div>

