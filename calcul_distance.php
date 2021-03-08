<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
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


if (isset($_GET['depart']) && isset($_GET['arriver']) && isset($_GET['ville_depart']) && isset($_GET['ville_arriver'])) {

	
	$depart = $_GET['depart'];
	$arriver = $_GET['arriver'];
	$v1 = $_GET['ville_depart'];
	$v2 = $_GET['ville_arriver'];
	
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
	
	$key = "519187be45d8881773bd8692cab5ad3b";
	
	$url1 = "http://api.positionstack.com/v1/forward?access_key=".$key."&query=".$depart;
	$url2 = "http://api.positionstack.com/v1/forward?access_key=".$key."&query=".$arriver;
	
	//echo $url1."</br>";
	//echo $url2;
	
	//$res1 = CallAPI("GET",$url1);
	//$res2 = CallAPI("GET",$url2);
	
	//$result = json_decode($res1, true);
	//$result = API($depart,$v1,$key);
	//$result2 = API($arriver,$v2,$key);
	
	
	$loc1 = $depart." ".$v1;
	$loc2 = $arriver." ".$v2;	
	
	$result = getCoord($loc1);
	$result2 = getCoord($loc2);

	//var_dump($result2);
	
	$res1_decode = json_decode($result,true);
	$res2_decode = json_decode($result2,true);

    $bbox = $res1_decode['bbox'];
    $bbox2 = $res2_decode['bbox'];

    $lat_depart = $bbox[1];
    $long_depart = $bbox[0];

    $lat_arriver = $bbox2[1];
    $long_arriver = $bbox2[0];
	
	$path = getPath($lat_depart,$long_depart,$lat_arriver,$long_arriver,$mode_api);
	//echo "</br></br>";
	//echo $path;



    $id = $_GET["identifiant"];

    if (!is_dir($id)) {
        mkdir($id);
    }

    $fp = fopen("$id/result.geojson","w");
	fwrite($fp,$path);
	fclose($fp);
	
	
	$path_decode = json_decode($path,true);
	//var_dump( $path_decode);
	
	$data = $path_decode["features"];
	//var_dump($data);
	$data_tmp = $data[0];
	//var_dump($data_tmp);
	$data2 = $data_tmp["properties"];
	$data3 = $data2["segments"];
	$data4 = $data3[0];
	$dist = $data4["distance"];
	$duration = $data4["duration"];
	
	//echo $dist;
	//echo "distance de base : ".$duration."</br>";
	
	
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
	
//	echo $dist."</br>";
	$dist = (int) $dist;
	//echo $minutes."</br>";;
	//echo $nb_heures."</br>";;

    $retour = array();
    $retour['success'] = true;
    $retour['km'] = $dist;
    $retour['heures'] = $nb_heures;
    $retour['minutes'] = $minutes;
    $retour['path'] = "$id/result.geojson";
    //var_dump(json_encode($retour));
    echo json_encode($retour);

    die();
	//echo "<script>window.location.href='distance.php?km=$dist&heures=$nb_heures&minutes=$minutes&arriver=$arriver&depart=$depart&v1=$v1&v2=$v2';</script>";
	//clearstatcache();
	//exit();
}
?>