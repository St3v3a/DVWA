<?php

if (isset($_GET['Submit'])) {
	$exists = dvwaSqliBlindUserExists($_GET['id'] ?? null);

	if ($exists) {
		$html .= '<pre>User ID exists in the database.</pre>';
	} else {
		// Preserve the missing-ID status for valid lookups; reject malformed input on this page.
		if ($exists !== null) {
			header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
		}
		$html .= '<pre>User ID is MISSING from the database.</pre>';
	}
}

?>
