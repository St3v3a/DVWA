<?php

require_once __DIR__ . '/redirect_target.php';

if (array_key_exists ("redirect", $_GET) && $_GET['redirect'] != "") {
	$target = dvwaLocalRedirectTarget($_GET['redirect'], true);
	if ($target !== null) {
		header ("location: " . $target);
		exit;
	} else {
		http_response_code (400);
		?>
		<p>You can only redirect to the info page.</p>
		<?php
		exit;
	}
}

http_response_code (500);
?>
<p>Missing redirect target.</p>
<?php
exit;
?>
