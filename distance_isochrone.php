<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<?php
if(!isset($_SESSION["prenom"])) {
    //header('Location: index.php');
    echo "<script>window.location.href='index.php';</script>";
}
else {
    $nom = $_SESSION["nom"];
    $prenom = $_SESSION["prenom"];
    $id = $_SESSION["identifiant"];
    $id_user = $_SESSION["id_user"];


}

?>
<!------ Include the above in your HEAD tag ---------->

<head>
    <meta charset="utf-8" http-equiv="Cache-control" content="no-cache">
    <title>Distance</title>
    <!--Made with love by Mutiullah Samim -->

    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href="css/styles2.css">

    <link rel="stylesheet" type="text/css" href="css/styles3.css">
    <link rel="stylesheet" type="text/css" href="css/style_multi.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

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
                        <a class="nav-link" href="distance_isochrone.php">Distance isochrones</a>
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

<div class="row" id="contatti">
    <div class="container mt-5" >
        <br>

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
              integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
              crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
                integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
                crossorigin=""></script>

        <script src="js/leaflet.ajax.min.js"> </script>

        <div class="row" style="height:550px;">
            <div class="col-md-6 maps" id = "map" > </div>
            <!--<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d11880.492291371422!2d12.4922309!3d41.8902102!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x28f1c82e908503c4!2sColosseo!5e0!3m2!1sit!2sit!4v1524815927977" frameborder="0" style="border:0" allowfullscreen></iframe>-->
            <script type = "text/javascript">
                var map = L.map('map').setView([48.8566969, 2.3514616], 11);
                var file_path = "";

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                var innerHTML = "";
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                    innerHTML = "Geolocation is not supported by this browser.";
                    //map = L.map('map').setView([48.8566969, 2.3514616], 11);
                }
                function showPosition(position) {
                    innerHTML = "Latitude: " + position.coords.latitude +
                        "<br>Longitude: " + position.coords.longitude;
                    console.log(innerHTML);
                   // map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 11);
                    //map.setView(new L.LatLng(position.coords.latitude, position.coords.longitude),11);
                    L.marker([position.coords.latitude, position.coords.longitude]).addTo(map)
                        .bindPopup("Votre position actuelle")
                        .openPopup();
                }

                /*L.marker([51.5, -0.09]).addTo(map)
                    .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
                    .openPopup();*/
                var id = "<?php echo $id; ?>";
                /*var geojsonLayer = new L.GeoJSON.AJAX(id+"/result_multi.geojson");
                $.getJSON(id+"/result_multi.geojson", function(json) {
                    //console.log(json); // this will show the info it in firebug console
                    var metadata = json.metadata;
                    var query = metadata.query;
                    var coord = query.coordinates;

                    for (index = 0;index < coord.length;++index) {
                        var tab = coord[index];
                        L.marker([tab[1], tab[0]]).addTo(map)
                            .bindPopup('Point')
                    }
                });
                geojsonLayer.addTo(map);*/


            </script>

            <div class="col-md-6">
                <h2 class="text-uppercase mt-3 font-weight-bold text-white">DISTANCE</h2>

                <h3 class="text-uppercase mt-4 font-weight-bold text-white"><?php echo "Bienvenue ".$nom." ".$prenom?></h3>

                <script src="js/js_dynamic_field.js"> </script>
                <p>Bonjour ! Veuillez saisir un point de départ et un point d'arrivée. A minima la ville, et si le résultat n'est pas assez précis veuillez
                    précisez le département puis la rue</p>

                <div class="container">
                    <div class="row">
                        <div class="control-group" id="fields">
                            <div class="controls">
                                <form role="form" autocomplete="off" name ="distance_isochrones" id = "distance_isochrones"  method ="GET">
                                    <div class="entry input-group col-xs-3">
                                        <input class="form-control" name="fields[]" id = "field" type="text" placeholder="Point" />
                                        <span class="input-group-btn">
                            <button class="btn btn-success btn-add" type="button">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </span>
                                    </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select id = "mode" name = "mode" value = "mode">
                                        <option = value="Velo">Velo</option>
                                        <option = value="Pieton">Pieton</option>
                                        <option = value="Voiture">Voiture</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for "intervalle" style="width: 250px;">Intervalle en mètres</label>
                                    <input type="text" id = "intervalle"  pattern = "^[0-9,]*$" name = "intervalle" class="form-control mt-2" placeholder = "Format : 200,300,...,N" style="width: 250px;" required>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">

                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-light" type="submit">Envoyer</button>
                            </div>
                            <br>
                            </form>


                            <script>
                                $(document).ready(function() {



                                    // process the form
                                    $('#distance_isochrones').submit(function(event) {
                                        event.preventDefault();
                                        // get the form data
                                        // there are many ways to get this data using jQuery (you can use the class or id also)
                                        var values = $("input[name='fields[]']")
                                            .map(function(){return $(this).val();}).get();
                                        //console.log(values);
                                        var e = document.getElementById("mode");
                                        var strUser = e.options[e.selectedIndex].text;
                                        var intervalles = document.getElementById("intervalle").value;
                                        var id = "<?php echo $id; ?>";

                                        var formData = {
                                            'fields'              : values,
                                            'mode'             : strUser,
                                            'intervalle'       : intervalles,
                                            'id'               :id
                                        };
                                        console.log(formData);
                                        // process the form
                                        $.ajax({
                                            type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
                                            url         : 'calcul_distance_isochrones.php', // the url where we want to POST
                                            data        : formData,
                                            processData: true // our data object
                                        })
                                            // using the done promise callback
                                            .done(function(data) {

                                                // log data to the console so we can see
                                                //console.log(data);
                                                var json_data = JSON.parse(data);
                                                console.log(json_data);
                                                if (json_data.success != true) {
                                                    console.log("erreur");
                                                }
                                                else {
                                                    file_path = json_data.path;

                                                    var id = "<?php echo $id; ?>";
                                                    var geojsonLayerV2 = new L.GeoJSON.AJAX(id+"/"+file_path);
                                                    $.getJSON(id+"/"+file_path, function(json) {
                                                        //console.log(json); // this will show the info it in firebug console
                                                        var metadata = json.metadata;
                                                        var query = metadata.query;
                                                        var locs = query.locations;

                                                        for (index = 0;index < locs.length;++index) {
                                                            var tab = locs[index];
                                                            L.marker([tab[1], tab[0]]).addTo(map)
                                                                .bindPopup('Point').openPopup();
                                                        }
                                                    });
                                                    map.eachLayer(function (layer) {
                                                        map.removeLayer(layer);
                                                    });
                                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                                    }).addTo(map);
                                                    geojsonLayerV2.addTo(map);

                                                }

                                                // here we will handle errors and validation messages
                                            }).fail(function() {
                                            alert("erreur");
                                        });

                                        // stop the form from submitting the normal way and refreshing the page
                                        event.preventDefault();
                                    });
                                });
                            </script>

                        </div>
                    </div>
                </div>
            </br>

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