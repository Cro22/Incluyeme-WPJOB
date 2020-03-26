<?php
require 'lib/WP_Incluyeme.php';
header('Content-type: application/json');
$result = [];
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['id']) {
	$data = new WP_Incluyeme();
	$data::setUserId($_POST['id']);
	try {
		$result = $data->searchModifiedIncluyeme(true);
		echo json_response(200, $result);
	} catch (Exception $e) {
		echo json_response(500, 'Ha ocurrido un error');
	}
	return;
}

function json_response($code = 200, $message = null)
{
	// clear the old headers
	header_remove();
	// set the actual code
	http_response_code($code);
	// set the header to make sure cache is forced
	header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
	// treat this as json
	header('Content-Type: application/json');
	$status = [
		200 => '200 OK',
		400 => '400 Bad Request',
		422 => 'Unprocessable Entity',
		500 => '500 Internal Server Error'
	];
	// ok, validation error, or failure
	header('Status: ' . $status[$code]);
	
	// return the encoded json
	return json_encode([
		'status' => $code < 300, // success or not?
		'message' => $message
	]);
}

$result = ["estado" => "false"];
echo json_response(500, 'Server Error! Please Try Again!');
return;