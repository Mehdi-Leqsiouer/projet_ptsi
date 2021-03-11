<?php

if (isset($_GET['file_path']) && isset($_GET['name_route']) && isset($_GET['id_user']) && isset($_GET['type'])) {
    $file_path = $_GET['file_path'];
    $name_route = $_GET['name_route'];
    $id_user = $_GET['id_user'];
    $type = $_GET['type'];


    require_once 'database_connect/db_connect.php';


    // connecting to db
    //$db = new DB_CONNECT();
    require_once 'database_connect/db_config.php';

    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_error());

    $query = "insert into Favoris(nom_favori,path,type,id_user) values ('$name_route','$file_path','$type',$id_user)";

    $result = mysqli_query($con,$query) or die ("Couldn't execute query: ".mysqli_error($con));
    $data  = array();
    if ($result) {
        $data['success'] = true;
        $data['message'] = "favori inséré";
    }
    else {
        $data['success'] = false;
        $data['message'] = "favori pas inséré";
    }
    echo json_encode($data);
}
?>