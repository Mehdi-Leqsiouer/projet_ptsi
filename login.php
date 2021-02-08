<?php
if (isset($_GET['identifiant']) && isset($_GET['password'])) {
	$id = $_GET['identifiant'];
	$pwd = $_GET['password'];
	$pwd_md5 = md5($pwd);
	
	
	require_once 'database_connect/db_connect.php';
	
	
    // connecting to db
    //$db = new DB_CONNECT();
	require_once 'database_connect/db_config.php';
	
	$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_error());
	
	$query = "SELECT * from Utilisateurs where identifiant = '$id' and password = '$pwd_md5'";
	
	$result = mysqli_query($con,$query) or die ("Couldn't execute query: ".mysqli_error($con));
	
	
	$nb_rows = mysqli_num_rows($result);
	
	if($nb_rows > 0) {
		header('Location: distance.html');
		
	}
	else {
		header('Location: index.html');
	}
	
}
else {
	header('Location: index.html');
}
//header('Location: index.html');
die();


?>