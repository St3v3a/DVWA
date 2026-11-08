<?php

if (isset($_POST['Upload'])) {
	$stored = dvwaStoreUploadedImage($_FILES['uploaded'] ?? null);
	if ($stored === false) {
		$html .= '<pre>Your image was not uploaded. We can only accept JPEG or PNG images.</pre>';
	} else {
		$html .= "<pre><a href='{$stored['path']}'>{$stored['name']}</a> succesfully uploaded!</pre>";
	}
}

?>
