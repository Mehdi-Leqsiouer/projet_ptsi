<?php

if (isset($_GET['name']) && isset($_GET['email']) && isset($_GET['phone']) && isset($_GET['message'])) {
    $name = $_GET['name'];
    $email = $_GET['email'];
    $phone = $_GET['phone'];
    $message = $_GET['message'];


    require_once 'database_connect/db_connect.php';


    // connecting to db
    //$db = new DB_CONNECT();
    require_once 'database_connect/db_config.php';

    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_error());

    $query = "insert into messages_contact(nom,mail,telephone,message) values ('$name','$email','$phone','$message')";


    $result = mysqli_query($con,$query) or die ("Couldn't execute query: ".mysqli_error($con));
    $data  = array();
    if ($result) {
        $data['success'] = true;
        $data['message'] = "Message bien envoyé ! Merci";
    }
    else {
        $data['success'] = false;
        $data['message'] = "Erreur dans l'envoi du message...";
    }
    echo json_encode($data);
}
?>