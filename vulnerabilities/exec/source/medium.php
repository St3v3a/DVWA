<?php

if( isset( $_POST[ 'Submit' ]  ) ) {
	// Get input
	$target = $_POST[ 'ip' ] ?? null;
	if (is_string($target)) {
		$target = trim($target);
	}
	if (!is_string($target) || filter_var($target, FILTER_VALIDATE_IP) === false) {
		$html .= '<pre>ERROR: You have entered an invalid IP.</pre>';
		return;
	}

	// Set blacklist
	$substitutions = array(
		'&&' => '',
		';'  => '',
	);

	// Remove any of the characters in the array (blacklist).
	$target = str_replace( array_keys( $substitutions ), $substitutions, $target );

	// Determine OS and execute the ping command.
	if( stristr( php_uname( 's' ), 'Windows NT' ) ) {
		// Windows
		$cmd = shell_exec( 'ping  ' . $target );
	}
	else {
		// *nix
		$cmd = shell_exec( 'ping  -c 4 ' . $target );
	}

	// Feedback for the end user
	$html .= "<pre>{$cmd}</pre>";
}

?>
