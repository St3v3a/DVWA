<?php

$headerCSP = "Content-Security-Policy: script-src 'self';";

header($headerCSP);

?>
<?php
if (isset ($_POST['include'])) {
	$include = is_string($_POST['include']) ? htmlspecialchars($_POST['include'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : '';
	$page[ 'body' ] .= "<p>Submitted text: {$include}</p>";
}
$page[ 'body' ] .= '
<form name="csp" method="POST">
	<p>Submitted markup is displayed as text.</p>
	<input size="50" type="text" name="include" value="" id="include" />
	<input type="submit" value="Include" />
</form>
';
