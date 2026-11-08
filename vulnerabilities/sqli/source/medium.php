<?php

require_once __DIR__ . '/user_lookup.php';

if (isset($_POST['Submit'])) {
    $id = $_POST['id'] ?? null;
    foreach (dvwaSqliFindUsers($id) as $row) {
        $safeId = (int)$id;
        $first = $row['first_name'];
        $last = $row['last_name'];
        $html .= "<pre>ID: {$safeId}<br />First name: {$first}<br />Surname: {$last}</pre>";
    }
}

$number_of_rows = dvwaSqliUserCount();

?>
