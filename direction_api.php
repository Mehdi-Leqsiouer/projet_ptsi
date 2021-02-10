<?php
function API() {
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/v2/directions/driving-car?api_key=5b3ce3597851110001cf6248fcb19b493ccf435791d6dac5ee251b1c&start=8.681495,49.41461&end=8.687872,49.420318");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	  "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8"
	));

	$response = curl_exec($ch);
	curl_close($ch);

	//var_dump($response);
	return $response;
	}

$response = API();
echo $response;





?>