<?php

$headerCSP = "Content-Security-Policy: script-src 'self';";

header($headerCSP);

?>
<?php
if (isset ($_POST['include'])) {
	if ($_POST['include'] === 'source/impossible.js') {
		$page[ 'body' ] .= '<script src="source/impossible.js"></script>';
	} else {
		$include = is_string($_POST['include']) ? htmlspecialchars($_POST['include'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : '';
		$page[ 'body' ] .= "<p>Script URL not allowed: {$include}</p>";
	}
}
$page[ 'body' ] .= '
<form name="csp" method="POST">
	<p>Only the bundled source/impossible.js script may be included. Other URLs are shown as text.</p>
	<input size="50" type="text" name="include" value="" id="include" />
	<input type="submit" value="Include" />
</form>
';
