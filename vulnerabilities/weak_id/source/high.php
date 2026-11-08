<?php

$html = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$cookie_value = bin2hex(random_bytes(20));
	setcookie("dvwaSession", $cookie_value, array(
		'expires' => time() + 3600,
		'path' => '/vulnerabilities/weak_id/',
		'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
		'httponly' => true,
		'samesite' => 'Lax',
	));
}

?>
