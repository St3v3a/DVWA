<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = 'Vulnerability: JavaScript Attacks' . $page[ 'title_separator' ].$page[ 'title' ];
$page[ 'page_id' ] = 'javascript';
$page[ 'help_button' ]   = 'javascript';
$page[ 'source_button' ] = 'javascript';

dvwaDatabaseConnect();

$vulnerabilityFile = '';
$securityLevel = dvwaSecurityLevelGet();
switch( $securityLevel ) {
	case 'low':
		$vulnerabilityFile = 'low.php';
		break;
	case 'medium':
		$vulnerabilityFile = 'medium.php';
		break;
	case 'high':
		$vulnerabilityFile = 'high.php';
		break;
	default:
		$vulnerabilityFile = 'impossible.php';
		break;
}

function dvwaJavascriptTokenForLevel($level) {
	$issued = $_SESSION['javascript_form_token'] ?? null;
	$user = dvwaCurrentUser();
	if (!is_array($issued) || ($issued['level'] ?? null) !== $level ||
		($issued['user'] ?? null) !== $user ||
		!is_string($issued['token'] ?? null)) {
		$issued = array('level' => $level, 'user' => $user, 'token' => bin2hex(random_bytes(32)));
		$_SESSION['javascript_form_token'] = $issued;
	}
	return $issued['token'];
}

function dvwaJavascriptConsumeToken($level, $submitted) {
	$issued = $_SESSION['javascript_form_token'] ?? null;
	if (!is_string($submitted) || !is_array($issued) ||
		($issued['level'] ?? null) !== $level ||
		($issued['user'] ?? null) !== dvwaCurrentUser() ||
		!is_string($issued['token'] ?? null) ||
		!hash_equals($issued['token'], $submitted)) {
		return false;
	}
	unset($_SESSION['javascript_form_token']);
	return true;
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] == "POST" && $vulnerabilityFile != 'impossible.php') {
	if (!is_string($_POST['phrase'] ?? null) || !is_string($_POST['server_token'] ?? null)) {
		$message = "<p>Missing phrase or token.</p>";
	} elseif (!dvwaJavascriptConsumeToken($securityLevel, $_POST['server_token'])) {
		$message = "<p>Invalid token.</p>";
	} elseif ($_POST['phrase'] === "success") {
		$message = "<p style='color:red'>Well done!</p>";
	} else {
		$message = "<p>You got the phrase wrong.</p>";
	}
}
$serverToken = $vulnerabilityFile == 'impossible.php' ? '' : dvwaJavascriptTokenForLevel($securityLevel);

if ( dvwaSecurityLevelGet() == "impossible" ) {
$page[ 'body' ] = <<<EOF
<div class="body_padded">
	<h1>Vulnerability: JavaScript Attacks</h1>

	<div class="vulnerable_code_area">
	<p>
		You can never trust anything that comes from the user or prevent them from messing with it and so there is no impossible level.
	</p>
EOF;
} else {
$page[ 'body' ] = <<<EOF
<div class="body_padded">
	<h1>Vulnerability: JavaScript Attacks</h1>

	<div class="vulnerable_code_area">
	<p>
		Submit the word "success" to win.
	</p>

	$message

	<form name="low_js" method="post">
		<input type="hidden" name="token" value="" id="token" />
		<input type="hidden" name="server_token" value="$serverToken" id="server-token" />
		<label for="phrase">Phrase</label> <input type="text" name="phrase" value="ChangeMe" id="phrase" />
		<input type="submit" id="send" name="send" value="Submit" />
	</form>
EOF;
}

require_once DVWA_WEB_PAGE_TO_ROOT . "vulnerabilities/javascript/source/{$vulnerabilityFile}";

$page[ 'body' ] .= <<<EOF
	</div>
EOF;

$page[ 'body' ] .= "
	<h2>More Information</h2>
	<ul>
		<li>" . dvwaExternalLinkUrlGet( 'https://www.w3schools.com/js/' ) . "</li>
		<li>" . dvwaExternalLinkUrlGet( 'https://www.youtube.com/watch?v=cs7EQdWO5o0&index=17&list=WL' ) . "</li>
		<li>" . dvwaExternalLinkUrlGet( 'https://ponyfoo.com/articles/es6-proxies-in-depth' ) . "</li>
	</ul>
	<p><i>Module developed by <a href='https://twitter.com/digininja'>Digininja</a>.</i></p>
</div>\n";

dvwaHtmlEcho( $page );

?>
