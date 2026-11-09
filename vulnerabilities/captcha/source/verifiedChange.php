<?php

function dvwaCaptchaBeginChange( $user, $level, $password ) {
	$_SESSION[ 'captcha_password_change' ] = array(
		'user' => $user,
		'level' => $level,
		'password_hash' => hash( 'sha256', $password ),
		'expires' => time() + 300
	);
}

function dvwaCaptchaConsumeChange( $user, $level, $password ) {
	$pending = $_SESSION[ 'captcha_password_change' ] ?? null;
	unset( $_SESSION[ 'captcha_password_change' ] );

	return is_array( $pending )
		&& isset( $pending[ 'user' ], $pending[ 'level' ], $pending[ 'password_hash' ], $pending[ 'expires' ] )
		&& $pending[ 'user' ] === $user
		&& $pending[ 'level' ] === $level
		&& $pending[ 'expires' ] >= time()
		&& hash_equals( $pending[ 'password_hash' ], hash( 'sha256', $password ) );
}

?>
