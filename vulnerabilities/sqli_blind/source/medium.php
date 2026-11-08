<?php

if (isset($_POST['Submit'])) {
	$exists = dvwaSqliBlindUserExists($_POST['id'] ?? null);

	if ($exists) {
		$html .= '<pre>User ID exists in the database.</pre>';
	} else {
		$html .= '<pre>User ID is MISSING from the database.</pre>';
	}
}

?>
