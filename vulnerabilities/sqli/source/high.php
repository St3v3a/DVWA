<?php

require_once __DIR__ . '/user_lookup.php';

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    foreach (dvwaSqliFindUsers($id, true) as $row) {
        $safeId = (int)$id;
        $first = $row['first_name'];
        $last = $row['last_name'];
        $html .= "<pre>ID: {$safeId}<br />First name: {$first}<br />Surname: {$last}</pre>";
    }
}

?>
