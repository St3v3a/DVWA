<?php

function dvwaStoreUploadedImage($file) {
	if (!is_array($file) ||
		($file['error'] ?? null) !== UPLOAD_ERR_OK ||
		!is_string($file['name'] ?? null) ||
		!is_string($file['tmp_name'] ?? null) ||
		!is_uploaded_file($file['tmp_name'])) {
		return false;
	}

	$size = filesize($file['tmp_name']);
	if ($size === false || $size < 1 || $size >= 100000) {
		return false;
	}

	$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
	$expectedType = match ($extension) {
		'jpg', 'jpeg' => IMAGETYPE_JPEG,
		'png' => IMAGETYPE_PNG,
		default => null,
	};
	if ($expectedType === null) {
		return false;
	}

	$imageInfo = @getimagesize($file['tmp_name']);
	if ($imageInfo === false || $imageInfo[2] !== $expectedType ||
		$imageInfo[0] < 1 || $imageInfo[1] < 1 ||
		$imageInfo[0] > 4096 || $imageInfo[1] > 4096 ||
		$imageInfo[0] * $imageInfo[1] > 16000000) {
		return false;
	}

	$image = $expectedType === IMAGETYPE_JPEG
		? @imagecreatefromjpeg($file['tmp_name'])
		: @imagecreatefrompng($file['tmp_name']);
	if ($image === false) {
		return false;
	}

	$uploadDirectory = DVWA_WEB_PAGE_TO_ROOT . 'hackable/uploads/';
	if (!is_dir($uploadDirectory) || !is_writable($uploadDirectory)) {
		return false;
	}
	$temporary = tempnam($uploadDirectory, '.dvwa-image-');
	if ($temporary === false) {
		return false;
	}

	$encoded = $expectedType === IMAGETYPE_JPEG
		? imagejpeg($image, $temporary, 90)
		: imagepng($image, $temporary, 9);
	if (!$encoded || !chmod($temporary, 0644)) {
		unlink($temporary);
		return false;
	}

	$storedName = bin2hex(random_bytes(16)) . ($expectedType === IMAGETYPE_JPEG ? '.jpg' : '.png');
	$storedPath = $uploadDirectory . $storedName;
	if (!rename($temporary, $storedPath)) {
		unlink($temporary);
		return false;
	}
	return array('name' => $storedName, 'path' => $storedPath);
}
