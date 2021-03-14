<?php
session_start();
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
if (isset($_GET['identifiant']) && isset($_GET['password'])) {
	$id = $_GET['identifiant'];
	$pwd = $_GET['password'];
	$pwd_md5 = md5($pwd);
	
	
	require_once 'database_connect/db_connect.php';
	
	
    // connecting to db
    //$db = new DB_CONNECT();
	require_once 'database_connect/db_config.php';
	
	$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_error());
	
	/*$query = "SELECT * from Utilisateurs where identifiant = '$id' and password = '$pwd_md5'";
	
	$result = mysqli_query($con,$query) or die ("Couldn't execute query: ".mysqli_error($con));

    $query = "select * from Utilisateurs where identifiant = ? and password = ?";*/

    $result = mysqli_prepare($con,"select prenom,nom,identifiant,id_user from Utilisateurs where identifiant = ? and password = ?");
    mysqli_stmt_bind_param($result,'ss',$id,$pwd_md5) or die(mysqli_error($con));
    mysqli_stmt_execute($result) or die(mysqli_error($con));

    if (!$result) {
        printf("Error: %s\n", mysqli_error($con));
        exit();
    }

    mysqli_stmt_bind_result($result, $prenom, $nom,$identifiant, $id_user) or die(mysqli_error($con));

    while (mysqli_stmt_fetch($result)) {
        $_SESSION["prenom"] = $prenom;
        $_SESSION["nom"] = $nom;
        $_SESSION["identifiant"] = $identifiant;
        $_SESSION["id_user"] = $id_user;
        mysqli_stmt_close($result);
        header('Location: distance.php');
        exit();
    }
	
}
else {
	header('Location: index.php');
	exit();
}
//header('Location: index.html');
die();


?>