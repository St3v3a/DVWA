<?php

if (isset($_POST['Change'])) {
	if (!dvwaCsrfConsumePasswordToken($_POST['user_token'] ?? null)) {
		$html .= "<pre>Invalid CSRF token.</pre>";
		return;
	}
	$pass_new = $_POST['password_new'];
	$pass_conf = $_POST['password_conf'];

	if ($pass_new == $pass_conf) {
		$pass_new = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $pass_new);
		$pass_new = md5($pass_new);

		$current_user = dvwaCurrentUser();
		$insert = "UPDATE users SET password = '$pass_new' WHERE user = '" . $current_user . "';";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $insert) or die('<pre>' . mysqli_error($GLOBALS["___mysqli_ston"]) . '</pre>');
		$html .= "<pre>Password Changed.</pre>";
	} else {
		$html .= "<pre>Passwords did not match.</pre>";
	}

	mysqli_close($GLOBALS["___mysqli_ston"]);
}

?>
