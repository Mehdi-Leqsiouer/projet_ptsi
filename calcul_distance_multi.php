<?php
session_start();
if(!isset($_SESSION["prenom"])) {
    //header('Location: index.php');
    echo "<script>window.location.href='index.php';</script>";
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

    $post_field = '{"locations":'.$list_coord.',"units" : "km"}';
    //curl_setopt($ch, CURLOPT_POSTFIELDS, '{"locations":[[9.70093,48.477473],[9.207916,49.153868],[37.573242,55.801281],[115.663757,38.106467]],"units":"km"}');
    curl_setopt($ch, CURLOPT_POSTFIELDS,$post_field);

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

    curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/v2/directions/$mode/geojson");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    //curl_setopt($ch, CURLOPT_POSTFIELDS, '{"coordinates":[[8.681495,49.41461],[8.686507,49.41943],[8.687872,49.420318]]}');
    curl_setopt($ch, CURLOPT_POSTFIELDS, '{"coordinates":'.$list_coord.'}');

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8",
        "Authorization: 5b3ce3597851110001cf6248fcb19b493ccf435791d6dac5ee251b1c",
        "Content-Type: application/json; charset=utf-8"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}


function getPois($depart,$arriver) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/pois");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    //$arriver = json_encode($arriver);
    //$depart = json_encode($depart);
    $tab = array();
    array_push($tab,$arriver);
    array_push($tab,$depart);
    $tab = json_encode($tab);
    $arriver = json_encode($arriver);
    //$post = "{'request':'pois','geometry':{'bbox':$tab,'geojson':{'type':'Point','coordinates':$arriver},'buffer':1000},'limit':10}";
    // echo $post;
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    curl_setopt($ch, CURLOPT_POSTFIELDS, '{"request":"pois","geometry":{"bbox":'.$tab.',"geojson":{"type":"Point","coordinates":'.$arriver.'},"buffer":200},"limit":30}');

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

    $mode = $_GET['mode'];
    $mode_api = "";
    if ($mode == "Voiture") {
        $mode_api = "driving-car";
    }
    else if ($mode == "Velo") {
        $mode_api = "cycling-road";
    }
    else {
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

    $old_file_id = $sum_coord/$nb_param;
    $file_id = str_replace(".","",$old_file_id);
    $file_name = trim($file_id.".geojson");

    $coords_encode = json_encode($list_coords);
    //var_dump($list_coords);
    $matrix = getMatrix($coords_encode,$mode_api);
   // var_dump($matrix);

    $matrix_decode = json_decode($matrix,true);
    $duration_matrix = $matrix_decode["durations"];
    $duration_0 = $duration_matrix[0];
   // var_dump($duration_0);
    //echo "</br>";
    $index = 0;
    $coord_order = array();
    array_push($coord_order,$list_coords[0]);
    //var_dump($coord_order);
    //echo "</br>";
    $duration_0 = array_diff($duration_0,[0]);
    //var_dump($duration_0);
    foreach($list_coords as $val) {
        if ($index !=0) {
            //var_dump($val);
            $min_value = min($duration_0);
            //var_dump($duration_0);
            $t = array_keys($duration_0, $min_value);
            $in_delete = $t[0];
            array_push($coord_order,$list_coords[$in_delete]);
            unset($duration_0[$in_delete]);
        }
        $index++;
    }

    $path = getMultiPath(json_encode($coord_order),$mode_api);

    $id = $_SESSION["identifiant"];

    if (!is_dir($id)) {
        mkdir($id);
    }

    $fp = fopen("$id/$file_name","w");
    fwrite($fp,$path);
    fclose($fp);


    $coord_depart = $coord_order[0];
    $coord_arriver = $coord_order[count($coord_order)-1];
    $pois = getPois($coord_depart,$coord_arriver);

    //echo $pois;

    $file_pois = "pois_multi.geojson";
    $fp2 = fopen("$id/$file_pois","w");
    fwrite($fp2,$pois);
    fclose($fp2);


    $path_decode = json_decode($path,true);
    //var_dump( $path_decode);

    $data = $path_decode["features"];
    //var_dump($data);
    $data_tmp = $data[0];
    //var_dump($data_tmp);
    $data2 = $data_tmp["properties"];
    $data3 = $data2["summary"];
    //$data4 = $data3[0];

    /*$d = $path_decode[0];
    $data = $d["routes"];
    var_dump($path_decode);
    $data_tmp = $data[0];
    $data2 = $data_tmp["summary"];*/


    $dist = $data3["distance"];
    $duration = $data3["duration"];

    $dist = $dist/1000;
    $duration = $duration/3600;

    //echo "distance ensuite : ".$duration."</br>";

    $nb_heures = (int) ($duration%60);
    if ($nb_heures < 1) {
        $minutes = (int) ($duration*60);
    }
    else {
        $minutes = (int) ($duration*60);
        $minutes = $minutes - $nb_heures*60;
    }
    $dist = (int) $dist;


    $retour = array();
    $retour['success'] = true;
    $retour['km'] = $dist;
    $retour['heures'] = $nb_heures;
    $retour['minutes'] = $minutes;
    $retour['path'] = $file_name;
    $retour['pois'] = $file_pois;
    //var_dump(json_encode($retour));
    echo json_encode($retour);
    die();

    //echo "<script>window.location.href='distance_multi.php?km=$dist&heures=$nb_heures&minutes=$minutes';</script>";
   // clearstatcache();
  //  exit();
}
?>