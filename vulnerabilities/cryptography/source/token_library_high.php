<?php

function highTokenKey() {
	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	if (!isset($_SESSION['cryptography_high_key']) || !is_string($_SESSION['cryptography_high_key']) || strlen($_SESSION['cryptography_high_key']) !== 32) {
		$_SESSION['cryptography_high_key'] = random_bytes(32);
	}
	return $_SESSION['cryptography_high_key'];
}

function encrypt($plaintext, $iv) {
	if (strlen($iv) !== 12) {
		throw new Exception('Invalid IV');
	}
	$ciphertext = openssl_encrypt($plaintext, 'aes-256-gcm', highTokenKey(), OPENSSL_RAW_DATA, $iv, $tag, '', 16);
	if ($ciphertext === false) {
		throw new Exception('Encryption failed');
	}
	return $ciphertext . $tag;
}

function decrypt($ciphertext, $iv) {
	if (strlen($iv) !== 12 || strlen($ciphertext) <= 16) {
		throw new Exception('Invalid token');
	}
	$tag = substr($ciphertext, -16);
	$body = substr($ciphertext, 0, -16);
	$plaintext = openssl_decrypt($body, 'aes-256-gcm', highTokenKey(), OPENSSL_RAW_DATA, $iv, $tag);
	if ($plaintext === false) {
		throw new Exception('Invalid token');
	}
	return $plaintext;
}

function create_token($debug = false) {
	$plaintext = 'userid:2';
	$iv = random_bytes(12);
	$ciphertext = encrypt($plaintext, $iv);
	if ($debug) {
		print 'Clear text token: ' . $plaintext . "\n";
	}
	return json_encode(array(
		'token' => base64_encode($ciphertext),
		'iv' => base64_encode($iv)
	));
}

function check_token($data) {
	$users = array(
		1 => array('name' => 'Geoffery', 'level' => 'admin'),
		2 => array('name' => 'Bungle', 'level' => 'user'),
		3 => array('name' => 'Zippy', 'level' => 'user'),
		4 => array('name' => 'George', 'level' => 'user')
	);

	$input = json_decode($data, true);
	if (!is_array($input)) {
		return json_encode(array('status' => 522, 'message' => 'Data in wrong format'));
	}
	if (!isset($input['token']) || !is_string($input['token'])) {
		return json_encode(array('status' => 523, 'message' => 'Missing token'));
	}
	if (!isset($input['iv']) || !is_string($input['iv'])) {
		return json_encode(array('status' => 524, 'message' => 'Missing IV'));
	}

	$ciphertext = base64_decode($input['token'], true);
	$iv = base64_decode($input['iv'], true);
	if ($ciphertext === false || $iv === false) {
		return json_encode(array('status' => 522, 'message' => 'Data in wrong format'));
	}
	try {
		$plaintext = decrypt($ciphertext, $iv);
	} catch (Exception $e) {
		return json_encode(array('status' => 526, 'message' => 'Unable to authenticate token'));
	}

	if (!preg_match('/^userid:(\d+)$/', $plaintext, $matches)) {
		return json_encode(array('status' => 527, 'message' => 'No user specified'));
	}
	$id = (int)$matches[1];
	if (!isset($users[$id])) {
		return json_encode(array('status' => 525, 'message' => 'User not found'));
	}
	return json_encode(array(
		'status' => 200,
		'user' => $users[$id]['name'],
		'level' => $users[$id]['level']
	));
}
?>
