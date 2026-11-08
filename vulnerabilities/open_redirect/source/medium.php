<?php

require_once __DIR__ . '/redirect_target.php';

if (array_key_exists ("redirect", $_GET) && $_GET['redirect'] != "") {
	$target = dvwaLocalRedirectTarget($_GET['redirect']);
	if ($target !== null) {
		header ("location: " . $target);
	} else {
		http_response_code(400);
		echo 'Invalid redirect target.';
	}
	exit;
}

http_response_code (500);
?>
<p>Missing redirect target.</p>
<?php
exit;
?>
