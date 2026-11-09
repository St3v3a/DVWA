<?php
header("Content-Type: application/json; charset=UTF-8");

if (!isset($_GET['callback'])) {
	return "";
}

if ($_GET['callback'] !== 'solveSum') {
	http_response_code(400);
	exit;
}

$outp = array ("answer" => "15");

echo "solveSum(" . json_encode($outp) . ")";
?>
