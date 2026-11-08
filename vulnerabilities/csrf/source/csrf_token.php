<?php

function dvwaCsrfPasswordToken() {
	if (!isset($_SESSION['csrf_password_token']) || !is_string($_SESSION['csrf_password_token'])) {
		$_SESSION['csrf_password_token'] = bin2hex(random_bytes(32));
	}
	return $_SESSION['csrf_password_token'];
}

function dvwaCsrfPasswordTokenField() {
	return "<input type='hidden' name='user_token' value='" . dvwaCsrfPasswordToken() . "' />";
}

function dvwaCsrfConsumePasswordToken($provided) {
	$expected = $_SESSION['csrf_password_token'] ?? null;
	if (!is_string($provided) || !is_string($expected) || !hash_equals($expected, $provided)) {
		return false;
	}
	unset($_SESSION['csrf_password_token']);
	return true;
}
