<?php

if (isset($_COOKIE['id'])) {
	$exists = dvwaSqliBlindUserExists($_COOKIE['id']);

	if ($exists) {
		$html .= '<pre>User ID exists in the database.</pre>';
	} else {
		if ($exists !== null) {
			// Keep the lesson's timing and 404 behavior for a valid missing ID.
			if (rand(0, 5) == 3) {
				sleep(rand(2, 4));
			}
			header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
		}
		$html .= '<pre>User ID is MISSING from the database.</pre>';
	}
}

?>
