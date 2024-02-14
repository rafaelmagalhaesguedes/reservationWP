<?php
function display_table($data, $headers, $edit_page, ...$fields) {
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr>';
    foreach ($headers as $header) {
        echo '<th scope="col">' . $header . '</th>';
    }
    echo '<th scope="col">Editar</th>';
    echo '</tr></thead>';
    echo '<tbody>';
    foreach ($data as $index => $item) {
        echo '<tr>';
        foreach ($fields as $field) {
            echo '<td>' . esc_html($item[$field]) . '</td>';
        }
        echo '<td><a href="?page=' . $edit_page . '&action=edit&index=' . $index . '">Editar</a></td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
}
?>