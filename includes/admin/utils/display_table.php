<?php
function display_table($data, $headers, $edit_page, ...$fields) {
    echo '
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .actions {
            text-align: center;
            width: 5%;
        }
    </style>';

    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr>';
    foreach ($headers as $header) {
        echo '<th scope="col">' . $header . '</th>';
    }
    echo '<th class="actions" scope="col"></th>';
    echo '<th  class="actions" scope="col"></th>';
    echo '</tr></thead>';
    echo '<tbody>';
    foreach ($data as $index => $item) {
        echo '<tr>';
        foreach ($fields as $field) {
            // Check if the field is a date field
            if ($field === 'start_date' || $field === 'end_date') {
                // Format the date ex: 1 de janeiro de 2024
                $date = DateTime::createFromFormat('Y-m-d', $item[$field]);
                if ($date !== false) {
                    echo '<td>' . $date->format('d') . ' de ' . $date->format('F') . ' de ' . $date->format('Y') . '</td>';
                } else {
                    echo '<td>Not valid</td>'; // Empty cell if date is not valid
                }
            } else {
                echo '<td>' . esc_html($item[$field]) . '</td>';
            }
        }
        echo '<td><a href="?page=' . $edit_page . '&action=edit&index=' . $index . '"><span class="dashicons dashicons-edit"></span></a></td>';
        echo '<td><a href="?page=' . $edit_page . '&action=delete&index=' . $index . '" onclick="return confirm(\'Deseja remover definitivamente?\')"><span class="dashicons dashicons-trash"></span></a></td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
}
?>