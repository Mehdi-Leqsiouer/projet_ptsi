<?php
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/pois");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_POST, TRUE);

curl_setopt($ch, CURLOPT_POSTFIELDS, '{"request":"pois","geometry":{"bbox":[[2.2028069496154785,48.88038635253906],[2.230592727661133,48.875728607177734]],"geojson":{"type":"Point","coordinates":[2.2028069496154785,48.88038635253906]},"buffer":1000},"limit":10}');

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8",
    "Authorization: 5b3ce3597851110001cf6248fcb19b493ccf435791d6dac5ee251b1c",
    "Content-Type: application/json; charset=utf-8"
));

$response = curl_exec($ch);
curl_close($ch);

var_dump($response);

?>