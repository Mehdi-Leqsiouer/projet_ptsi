<?php
if (isset($_GET['depart']) && isset($_GET['arriver'])) {
	
	$depart = $_GET['depart'];
	$arriver = $_GET['arriver'];
	
	$key = "519187be45d8881773bd8692cab5ad3b";
	
	$url1 = "http://api.positionstack.com/v1/forward?access_key=".$key."&query=".$depart;
	$url2 = "http://api.positionstack.com/v1/forward?access_key=".$key."&query=".$arriver;
	
	
	$res1 = CallAPI("GET",$url1);
	$res2 = CallAPI("GET",$url2);
	
	
	$result = json_decode($res1, true);
	
	//var_dump($result);
	
	$data = $result["data"];
	//var_dump ($data);
	
	$t = $data[0];
	//var_dump($t);
	
	
	$lat_depart = $t["latitude"];
	$long_depart = $t["longitude"];
	echo $lat_depart;
	echo "</br>";
	echo $long_depart;
	
	$result2 = json_decode($res2, true);
	
	//var_dump($result);
	
	$data2 = $result2["data"];
	//var_dump ($data);
	
	$t2 = $data2[0];
	//var_dump($t);
	
	echo "</br>";
	$lat_arriver = $t2["latitude"];
	$long_arriver = $t2["longitude"];
	echo $lat_arriver;
	echo "</br>";
	echo $long_arriver;
	
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
?>