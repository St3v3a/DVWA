<?php

function mediumTokenKey() {
	if (!isset($_SESSION['cryptography_medium_key']) || !is_string($_SESSION['cryptography_medium_key']) || strlen($_SESSION['cryptography_medium_key']) !== 32) {
		$_SESSION['cryptography_medium_key'] = random_bytes(32);
	}
	return $_SESSION['cryptography_medium_key'];
}

function issueMediumToken($user, $level, $expires) {
	$payload = json_encode(array('user' => $user, 'ex' => $expires, 'level' => $level));
	$signature = hash_hmac('sha256', $payload, mediumTokenKey(), true);
	return bin2hex($payload . $signature);
}

function verifyMediumToken($token) {
	if (!is_string($token) || $token === '' || strlen($token) % 2 !== 0 || !ctype_xdigit($token)) {
		throw new Exception('Token is in wrong format');
	}
	$raw = hex2bin($token);
	if (strlen($raw) <= 32) {
		throw new Exception('Token is in wrong format');
	}
	$payload = substr($raw, 0, -32);
	$signature = substr($raw, -32);
	if (!hash_equals(hash_hmac('sha256', $payload, mediumTokenKey(), true), $signature)) {
		throw new Exception('Invalid token');
	}
	$claims = json_decode($payload);
	if (!is_object($claims) || !is_string($claims->user ?? null) || !is_string($claims->level ?? null) || !is_int($claims->ex ?? null)) {
		throw new Exception('Token claims are invalid');
	}
	if ($claims->ex <= time()) {
		throw new Exception('Token expired');
	}
	return $claims;
}

$errors = '';
$success = '';
$messages = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	try {
		if (!array_key_exists('token', $_POST)) {
			throw new Exception('No token passed');
		}
		$user = verifyMediumToken($_POST['token']);
		if ($user->user === 'sweep' && $user->ex > time() && $user->level === 'admin') {
			$success = 'Welcome administrator Sweep';
		} else {
			$messages = 'Login successful but not as the right user.';
		}
	} catch (Exception $e) {
		$errors = $e->getMessage();
	}
}

$sootyToken = issueMediumToken('sooty', 'admin', time() - 60);
$sweepToken = issueMediumToken('sweep', 'user', time() - 60);
$sooToken = issueMediumToken('soo', 'user', time() + 3600);

$html = "
		<p>These session tokens are signed by the server. A changed claim invalidates its signature.</p>
		<p><strong>Sooty (admin), session expired</strong></p>
		<p><textarea style='width: 600px; height: 56px' readonly='readonly'>{$sootyToken}</textarea></p>
		<p><strong>Sweep (user), session expired</strong></p>
		<p><textarea style='width: 600px; height: 56px' readonly='readonly'>{$sweepToken}</textarea></p>
		<p><strong>Soo (user), session valid</strong></p>
		<p><textarea style='width: 600px; height: 56px' readonly='readonly'>{$sooToken}</textarea></p>
		<hr>
		<p>Submit a token to check its claims.</p>
";

if ($errors !== '') {
	$html .= '<div class="warning">' . htmlentities($errors) . '</div>';
}
if ($messages !== '') {
	$html .= '<div class="nearly">' . $messages . '</div>';
}
if ($success !== '') {
	$html .= '<div class="success">' . $success . '</div>';
}

$html .= "
		<form name='signed_token' method='post' action='" . $_SERVER['PHP_SELF'] . "'>
			<p><label for='token'>Token:</label><br />
			<textarea style='width: 600px; height: 56px' id='token' name='token'></textarea></p>
			<p><input type='submit' value='Submit'></p>
		</form>
";
?>
