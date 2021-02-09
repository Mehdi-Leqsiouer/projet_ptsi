<?php
session_start();
if(!isset($_SESSION["prenom"])) {
	//header('Location: index.php');
	echo "<script>window.location.href='index.php';</script>";
}
function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

function API($street,$city) {
	$queryString = http_build_query([
  'access_key' => '519187be45d8881773bd8692cab5ad3b',
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


if (isset($_GET['depart']) && isset($_GET['arriver']) && isset($_GET['ville_depart']) && isset($_GET['ville_arriver'])) {

	
	$depart = $_GET['depart'];
	$arriver = $_GET['arriver'];
	$v1 = $_GET['ville_depart'];
	$v2 = $_GET['ville_arriver'];
	
	$mode = $_GET['mode'];
	
	$key = "519187be45d8881773bd8692cab5ad3b";
	
	$url1 = "http://api.positionstack.com/v1/forward?access_key=".$key."&query=".$depart;
	$url2 = "http://api.positionstack.com/v1/forward?access_key=".$key."&query=".$arriver;
	
	//echo $url1."</br>";
	//echo $url2;
	
	//$res1 = CallAPI("GET",$url1);
	//$res2 = CallAPI("GET",$url2);
	
	//$result = json_decode($res1, true);
	$result = API($depart,$v1);
	$result2 = API($arriver,$v2);
	
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
	
	echo $heures."</br>";
	echo $minutes;
	
	//$tmp = passthru("python3 get_distance.py $lat_depart $long_depart $lat_arriver $long_arriver");
    //echo $tmp;
	//header("Location: distance.php");
	echo "<script>window.location.href='distance.php?km=$km&heures=$heures&minutes=$minutes&arriver=$arriver&depart=$depart&v1=$v1&v2=$v2';</script>";
	//header("Location: distance.php?km=".$km);
	exit;
}
?>