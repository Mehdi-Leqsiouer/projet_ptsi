<?php

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


function getIsochrones($locations,$mode,$range)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/v2/isochrones/$mode");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, '{"locations":'.$locations.',"range":'.$range.',"units":"km"}');

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

if (isset($_GET['fields'])) {

    $mode = $_GET['mode'];
    $mode_api = "";
    if ($mode == "Voiture") {
        $mode_api = "driving-car";
    } else if ($mode == "Velo") {
        $mode_api = "cycling-road";
    } else {
        $mode_api = "foot-walking";
    }

    $fields = $_GET['fields'];
    $list_coords = array();
    $sum_coord = 0.0;
    $nb_param = 0;
    foreach($fields as $val) {
        $coord = getCoord($val);
        $decode = json_decode($coord,true);
        $bbox = $decode['bbox'];
        $bbox_sliced = array_slice($bbox,0,2);
        $sum_coord += $bbox_sliced[0]+$bbox_sliced[1];
        $nb_param +=2;
        array_push($list_coords,$bbox_sliced);
    }

    $range = $_GET['intervalle'];
    //echo $range;
    $range_tab = explode(',',$range);


    $iso = getIsochrones(json_encode($list_coords),$mode_api,json_encode($range_tab));

    $id = $_GET['id'];

    if (!is_dir($id)) {
        mkdir($id);
    }

    $file_name = "isochrone.geojson";

    $fp = fopen("$id/$file_name","w");
    fwrite($fp,$iso);
    fclose($fp);


    $retour = array();
    $retour['success'] = true;
    $retour['path'] = $file_name;
    //echo $iso;

    echo json_encode($retour);
    die();
}



?>