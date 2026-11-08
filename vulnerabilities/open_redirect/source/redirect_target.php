<?php

function dvwaLocalRedirectTarget($target, $infoOnly = false) {
	if (!is_string($target) || $target === '' || preg_match('/[\x00-\x20\x7f]/', $target) || str_contains($target, '\\')) {
		return null;
	}
	if (str_starts_with($target, '//')) {
		return null;
	}

	$parts = parse_url($target);
	if ($parts === false || isset($parts['scheme']) || isset($parts['host']) || isset($parts['user']) || isset($parts['pass']) || isset($parts['port'])) {
		return null;
	}
	$path = $parts['path'] ?? '';
	if ($path === '' || str_contains($path, '%')) {
		return null;
	}
	if ($infoOnly && !in_array($path, array('info.php', '/vulnerabilities/open_redirect/info.php', '/vulnerabilities/open_redirect/source/info.php'), true)) {
		return null;
	}
	if ($infoOnly && $path === '/vulnerabilities/open_redirect/info.php') {
		return '/vulnerabilities/open_redirect/source/info.php'
			. (isset($parts['query']) ? '?' . $parts['query'] : '')
			. (isset($parts['fragment']) ? '#' . $parts['fragment'] : '');
	}
	return $target;
}
