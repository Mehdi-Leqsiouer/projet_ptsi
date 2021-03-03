<?php
session_start();

if(!isset($_SESSION["prenom"])) {
    //header('Location: index.php');
    echo "<script>window.location.href='index.php';</script>";
}
else {
    $nom = $_SESSION["nom"];
    $prenom = $_SESSION["prenom"];


}

?>

<html>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" http-equiv="Cache-control" content="no-cache">
    <title>Distance</title>
    <!--Made with love by Mutiullah Samim -->

    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href="styles2.css">

    <link rel="stylesheet" type="text/css" href="styles3.css">
    <link rel="stylesheet" type="text/css" href="style_mutli.css">

    <nav class="navbar navbar-expand-md navbar-dark fixed-top" id="banner">
        <div class="container">
            <!-- Brand -->

            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="distance.php">Distance entre 2 points</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="distance_multi.php">Distance multi-points</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


</head>

<body>

<?php
if (isset($_GET['km'])) {
    $km = $_GET['km']." kilomètres";
}
else {
    $km = "";
}

if (isset($_GET['depart'])) {
    $depart = $_GET['depart'];
}
else {
    $depart = "";
}

if (isset($_GET['arriver'])) {
    $arriver = $_GET['arriver'];
}
else {
    $arriver = "";
}

if (isset($_GET['v1'])) {
    $v1 = $_GET['v1'];
}
else {
    $v1 = "";
}

if (isset($_GET['v2'])) {
    $v2 = $_GET['v2'];
}
else {
    $v2 = "";
}

if (isset($_GET['minutes'])) {
    $minutes = $_GET['minutes']." minutes";
}
else {
    $minutes = "";
}

if (isset($_GET['heures'])) {
    $heures = $_GET['heures']." heures ";
}
else {
    $heures = "";
}

?>


<div class="row" id="contatti">
    <div class="container mt-5" >
        <br>

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
              integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
              crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
                integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
                crossorigin=""></script>

        <script src="leaflet.ajax.min.js"> </script>

        <div class="row" style="height:550px;">
            <div class="col-md-6 maps" id = "map" > </div>
            <!--<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d11880.492291371422!2d12.4922309!3d41.8902102!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x28f1c82e908503c4!2sColosseo!5e0!3m2!1sit!2sit!4v1524815927977" frameborder="0" style="border:0" allowfullscreen></iframe>-->
            <script type = "text/javascript">
                var map = L.map('map').setView([48.8566969, 2.3514616], 11);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                /*L.marker([51.5, -0.09]).addTo(map)
                    .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
                    .openPopup();*/

                var geojsonLayer = new L.GeoJSON.AJAX("result.geojson");
                $.getJSON("result.geojson", function(json) {
                    //console.log(json); // this will show the info it in firebug console
                    var metadata = json.metadata;
                    var query = metadata.query;
                    var coord = query.coordinates;
                    var depart = coord[0];
                    var arriver = coord[1];
                    /*var depart = [coord[1],coord[0]];
                    var arriver = [coord[3],coord[2]];
                    console.log(depart);*/
                    L.marker([depart[1], depart[0]]).addTo(map)
                        .bindPopup('Point de départ')
                        .openPopup();
                    L.marker([arriver[1], arriver[0]]).addTo(map)
                        .bindPopup("Point d'arrivé")
                        .openPopup();
                });
                geojsonLayer.addTo(map);

            </script>

            <div class="col-md-6">
                <h2 class="text-uppercase mt-3 font-weight-bold text-white">DISTANCE</h2>

                <h3 class="text-uppercase mt-4 font-weight-bold text-white"><?php echo "Bienvenue ".$nom." ".$prenom?></h3>

                <script src="js_dynamic_field.js"> </script>

                <div class="container">
                    <div class="row">
                        <div class="control-group" id="fields">
                            <div class="controls">
                                <form role="form" autocomplete="off" action ="calcul_distance_multi.php" method ="GET">
                                    <div class="entry input-group col-xs-3">
                                        <input class="form-control" name="fields[]" type="text" placeholder="Point" />
                                        <span class="input-group-btn">
                            <button class="btn btn-success btn-add" type="button">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </span>
                                    </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-light" type="submit">Envoyer</button>
                            </div>
                            <br>
                                </form>

                        </div>
                    </div>
                </div>



              <!--  <script type="text/javascript">
                    $(document).ready(function(){
                        var maxField = 5; //Input fields increment limitation
                        var addButton = $('.add_button'); //Add button selector
                        var wrapper = $('.row'); //Input field wrapper
                        var fieldHTML = '<div class="col-lg-6"><div class="form-group"><input type="text" name="field_name[]" value=""/><a href="javascript:void(0);" class="remove_button"><img src="remove-icon.png"/></a></div></div>'; //New input field html
                        var x = 1; //Initial field counter is 1

                        //Once add button is clicked
                        $(addButton).click(function(){
                            //Check maximum number of input fields
                            if(x < maxField){
                                x++; //Increment field counter
                                $(wrapper).append(fieldHTML); //Add field html
                            }
                        });

                        //Once remove button is clicked
                        $(wrapper).on('click', '.remove_button', function(e){
                            e.preventDefault();
                            $(this).parent('div').remove(); //Remove field html
                            x--; //Decrement field counter
                        });
                    });
                </script>-->


                <form action="save_favori.php" method = "GET">
                    <div class="col-12">
                        <button class="btn btn-light" type="favori">Enregistrer cet itinéraire</button>
                    </div>
                </form>
                <div class="col-12">
                    <a  type="submit" href = "deconnection.php">Se déconnecter</a>
                </div>
                <div class="text-white">
                </div>

            </div>
        </div>
    </div>

    <div class="row text-center bg-success text-white" id="author">
        <div class="col-12 mt-4 h3 ">
        </div>
        <div class="col-12 my-2">
        </div>
    </div>
    <body>
</html>