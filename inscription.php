<?php
session_start();
if (isset($_GET['identifiant']) && isset($_GET['password']) && isset($_GET['nom']) && isset($_GET['prenom'])) {
	
	$id = $_GET['identifiant'];
	$pwd = $_GET['password'];
	$pwd_md5 = md5($pwd);
	$nom = $_GET['nom'];
	$prenom = $_GET['prenom'];
	
	
	require_once 'database_connect/db_connect.php';
	
	
    // connecting to db
    //$db = new DB_CONNECT();
	require_once 'database_connect/db_config.php';
	
	$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_error());
	
	$query = "insert into Utilisateurs(identifiant,password,nom,prenom) values ('$id','$pwd_md5','$nom','$prenom')";
	
	$result = mysqli_query($con,$query) or die (header('Location: inscription_html.php?fail=true'));

	/*$_SESSION["prenom"] = $prenom;
	$_SESSION["nom"] = $nom;
	$_SESSION["identifiant"] = $id;*/
    if ($result)
	    header('Location: index.php');
    else
        header('Location: inscription.html');
	
}
else {
	echo "non";
	//header('Location: inscription.html');
}
//header('Location: index.html');
die();


?>