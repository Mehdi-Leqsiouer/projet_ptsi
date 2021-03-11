<?php
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/v2/isochrones/driving-car");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_POST, TRUE);

curl_setopt($ch, CURLOPT_POSTFIELDS, '{"locations":[[8.681495,49.41461],[8.686507,49.41943]],"range":[300,200],"intersections":"false","units":"km"}');

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8",
    "Authorization: 5b3ce3597851110001cf6248fcb19b493ccf435791d6dac5ee251b1c",
    "Content-Type: application/json; charset=utf-8"
));

$response = curl_exec($ch);
curl_close($ch);

var_dump($response);

?>