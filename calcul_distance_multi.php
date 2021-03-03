<?php
session_start();
if(!isset($_SESSION["prenom"])) {
    //header('Location: index.php');
    //echo "<script>window.location.href='index.php';</script>";
}

function API($street,$city,$key) {
    $queryString = http_build_query([
        'access_key' => $key,
        'query' => $street,
        'region' => $city,
        'country' => 'FR',
        'output' => 'json',
        'limit' => 1,
    ]);

    $ch = curl_init(sprintf('%s?%s', 'http://api.positionstack.com/v1/forward', $queryString));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $json = curl_exec($ch);

    curl_close($ch);

    $apiResult = json_decode($json, true);
    return $apiResult;

}

function getCoord($location) {
    $ch = curl_init();
    $locationEncode = urlencode($location);
    curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/geocode/search?api_key=5b3ce3597851110001cf6248fcb19b493ccf435791d6dac5ee251b1c&text=$locationEncode&boundary.country=FR&size=1");
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

function getPath($lat1,$lon1,$lat2,$lon2,$mode) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/v2/directions/$mode?api_key=5b3ce3597851110001cf6248fcb19b493ccf435791d6dac5ee251b1c&start=$lon1,$lat1&end=$lon2,$lat2");
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


function getMatrix($list_coord,$mode) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/v2/matrix/$mode");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    //curl_setopt($ch, CURLOPT_POSTFIELDS, '{"locations":[[9.70093,48.477473],[9.207916,49.153868],[37.573242,55.801281],[115.663757,38.106467]],"units":"km"}');
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{'locations':$list_coord,'units':'km'}");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8",
        "Authorization: 5b3ce3597851110001cf6248fcb19b493ccf435791d6dac5ee251b1c",
        "Content-Type: application/json; charset=utf-8"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    //var_dump($response);

    return $response;
}

function getMultiPath($list_coord,$mode) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/v2/directions/$mode");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    //curl_setopt($ch, CURLOPT_POSTFIELDS, '{"coordinates":[[8.681495,49.41461],[8.686507,49.41943],[8.687872,49.420318]]}');
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{'coordinates':$list_coord}");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8",
        "Authorization: 5b3ce3597851110001cf6248fcb19b493ccf435791d6dac5ee251b1c",
        "Content-Type: application/json; charset=utf-8"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}


if (isset($_GET['fields'])) {

    $fields = $_GET['fields'];

    clearstatcache();
    exit;
}
?>