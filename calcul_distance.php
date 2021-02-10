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
  'output' => 'json',
  'limit' => 1,
	]);

	$ch = curl_init(sprintf('%s?%s', 'http://api.positionstack.com/v1/forward', $queryString));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$json = curl_exec($ch);

	curl_close($ch);

	$apiResult = json_decode($json, true);
	return $apiResult;
	//print_r($apiResult);
}

function getPath($lat1,$lon1,$lat2,$lon2,$mode) {
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/v2/directions/$mode?api_key=5b3ce3597851110001cf6248fcb19b493ccf435791d6dac5ee251b1c&start=$lon1,$lat1&end=$lon2,$lat1");
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
	$result = API($depart,$v1,$key);
	$result2 = API($arriver,$v2,$key);
	
	$data = $result["data"];
	//var_dump ($data);
	
	$t = $data[0];
	//var_dump($t);
	
	
	$lat_depart = $t["latitude"];
	$long_depart = $t["longitude"];
	#echo $lat_depart;
	#echo "</br>";
	#echo $long_depart;
	
	//$result2 = json_decode($res2, true);
	
	//var_dump($result);
	
	$data2 = $result2["data"];
	//var_dump ($data);
	
	$t2 = $data2[0];
	//var_dump($t);
	
	#echo "</br>";
	$lat_arriver = $t2["latitude"];
	$long_arriver = $t2["longitude"];
	#echo $lat_arriver;
	#echo "</br>";
	#echo $long_arriver;
	
	$value = array();
	$ret_code = -1;
	
	exec("python3 get_distance.py $lat_depart $long_depart $lat_arriver $long_arriver $mode",$value,$ret_code);
	$km = $value[0];
	$heures = $value[1];
	$minutes = $value[2];
	
	//echo $heures."</br>";
	//echo $minutes;
	
	
	$path = getPath($lat_depart,$long_depart,$lat_arriver,$long_arriver,$mode_api);
	echo "</br></br>";
	//echo $path;
	
	
	$path_decode = json_decode($path,true);
	//var_dump( $path_decode);
	
	$data = $path_decode["features"];
	//var_dump($data);
	$data_tmp = $data[0];
	//var_dump($data_tmp);
	$data2 = $data_tmp["properties"];
	//var_dump($data2);
	//var_dump($data2);
	$data3 = $data2["segments"];
	//var_dump($data);
	$data4 = $data3[0];
	
	$dist = $data4["distance"];
	$duration = $data4["duration"];
	
	//echo $dist;
	echo "distance de base : ".$duration."</br>";
	
	
	$dist = $dist/1000;
	$duration = $duration/3600;
	
	echo "distance ensuite : ".$duration."</br>";
	
	$nb_heures = (int) ($duration%60);
	if ($nb_heures < 1) {
		$minutes = (int) ($duration*60);
	}
	else {
		$minutes = (int) ($duration*60);
		$minutes = $minutes - $nb_heures*60;
	}
	
	echo $dist."</br>";
	$dist = (int) $dist;
	echo $minutes."</br>";;
	echo $nb_heures."</br>";;
	
	echo "<script>window.location.href='distance.php?km=$dist&heures=$nb_heures&minutes=$minutes&arriver=$arriver&depart=$depart&v1=$v1&v2=$v2';</script>";
	//exit;
}
?>