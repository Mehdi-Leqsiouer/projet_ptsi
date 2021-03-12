<?php
session_start();

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

<?php
if (isset($_GET['km'])) {
    $km = $_GET['km']." kilomètres";
}
else {
    $km = "";
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
                var file_path = "";

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

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

                <script src="js_dynamic_field.js"> </script>

                <div class="container">
                    <div class="row">
                        <div class="control-group" id="fields">
                            <div class="controls">
                                <form role="form" autocomplete="off" name ="distance_multi" id = "distance_multi"  method ="GET">
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

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" size="50" id = "distance" name = "distance" class="form-control mt-2" value ="<?php echo $km ?>" readonly>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" size="50" id = "temps" name = "temps" class="form-control mt-2" value ="<?php echo $heures.$minutes ?>" readonly>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <input type="checkbox" id = "pois" name = "pois" class="form-control mt-2"  value = "Afficher les pois" checked>
                                <label for="pois">Afficher les points d'intérets</label>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-light" type="submit">Envoyer</button>
                            </div>
                            <br>
                                </form>


                            <script>
                                $(document).ready(function() {

                                    // process the form
                                    $('#distance_multi').submit(function(event) {
                                        event.preventDefault();
                                        // get the form data
                                        // there are many ways to get this data using jQuery (you can use the class or id also)
                                        var values = $("input[name='fields[]']")
                                            .map(function(){return $(this).val();}).get();
                                        //console.log(values);
                                        var e = document.getElementById("mode");
                                        var strUser = e.options[e.selectedIndex].text;

                                        var formData = {
                                            'fields'              : values,
                                            'mode'             : strUser
                                        };
                                        console.log(formData);
                                        // process the form
                                        $.ajax({
                                            type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
                                            url         : 'calcul_distance_multi.php', // the url where we want to POST
                                            data        : formData,
                                            processData: true // our data object
                                        })
                                            // using the done promise callback
                                            .done(function(data) {

                                                // log data to the console so we can see
                                                //console.log(data);
                                                var json_data = JSON.parse(data);
                                                console.log(json_data);
                                                console.log(json_data.heures);
                                                if (json_data.success != true) {
                                                    console.log("erreur");
                                                }
                                                else {
                                                    $("#distance").val(json_data.km+" kilomètres");
                                                    $("#temps").val(json_data.heures+" heures "+json_data.minutes+" minutes");
                                                    file_path = json_data.path;
                                                    var file_pois = json_data.pois;

                                                    var id = "<?php echo $id; ?>";
                                                    var geojsonLayerV2 = new L.GeoJSON.AJAX(id+"/"+file_path);
                                                    $.getJSON(id+"/"+file_path, function(json) {
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
                                                    map.eachLayer(function (layer) {
                                                        map.removeLayer(layer);
                                                    });
                                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                                    }).addTo(map);
                                                    geojsonLayerV2.addTo(map);

                                                    var chkBox = document.getElementById('pois');
                                                    var pois = false;
                                                    if (chkBox.checked) {
                                                        pois = true;
                                                    }
                                                    if(pois == true) {
                                                        var poisLayer = new L.GeoJSON.AJAX(id + "/" + file_pois);
                                                        poisLayer.addTo(map);
                                                    }
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


                <form name= "save_favori" id = "save_favori" method = "GET">
                    <div class="col-12">
                        <button class="btn btn-light" type="favori">Enregistrer cet itinéraire</button>
                    </div>
                </form>

                <h4 class="text-uppercase mt-4 font-weight-bold text-white">Vos favoris : </h4>
                <div class="col-12">
                    <select id = "favs" name = "favs" value = "mode">

                    </select>
                </div></br>


                <script>
                    $(document).ready(function() {
                        var array = [
                            <?php
                            require_once 'database_connect/db_connect.php';
                            require_once 'database_connect/db_config.php';
                            $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_error());

                            $query = "select nom_favori,path from Favoris where id_user = $id_user and type = 'multi'";
                            $result = mysqli_query($con,$query) or die ("Couldn't execute query: ".mysqli_error($con));
                            while ($fav = mysqli_fetch_assoc($result)) {
                                $favori = $fav["nom_favori"];
                                $path = $fav["path"];
                                $favori = str_replace('_',' en ',$favori);
                                echo "['$favori','$path'],";
                            }
                            ?>
                        ];
                        console.log(array);
                        var select = document.getElementById("favs");
                        for(const val of array) {
                            var option = document.createElement("option");
                            option.value = val[0];
                            option.text = val[0]
                            option.id=val[1];
                            option.setAttribute("name",val[1]);
                            select.appendChild(option);
                        }


                        if (option.id != null) {
                            var tmp_path = option.id;
                            option.selected = true;
                            var geojsonLayerV4 = new L.GeoJSON.AJAX(tmp_path);
                            $.getJSON(tmp_path, function (json) {
                                //console.log(json); // this will show the info it in firebug console
                                var metadata = json.metadata;
                                var query = metadata.query;
                                var coord = query.coordinates;

                                for (index = 0; index < coord.length; ++index) {
                                    var tab = coord[index];
                                    L.marker([tab[1], tab[0]]).addTo(map)
                                        .bindPopup('Point')
                                }
                            });
                            map.eachLayer(function (layer) {
                                map.removeLayer(layer);
                            });
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(map);
                            geojsonLayerV4.addTo(map);
                        }


                        $('#favs').change(function(e) {
                            e.preventDefault();
                            var select = document.getElementById("favs");
                            var item_selected = select.options[select.selectedIndex];

                            var path_select = item_selected.getAttribute("name");

                            var geojsonLayerV3 = new L.GeoJSON.AJAX(path_select);
                            $.getJSON(path_select, function(json) {
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
                            map.eachLayer(function (layer) {
                                map.removeLayer(layer);
                            });
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(map);
                            geojsonLayerV3.addTo(map);

                            console.log(path_select);
                        });

                    });
                </script>



                <div class="col-12">
                    <a  type="submit" href = "deconnection.php">Se déconnecter</a>
                </div>
                <div class="text-white">
                </div>

                <script>

                    $(document).ready(function() {
                        $('#save_favori').submit(function(event) {
                            event.preventDefault();
                            var values = $("input[name='fields[]']")
                                .map(function(){return $(this).val();}).get();
                            //console.log(values);
                            // action="save_favori.php"
                            var e = document.getElementById("mode");
                            var strUser = e.options[e.selectedIndex].text;

                            var name_route = values[0];
                            for (index = 1;index < values.length;++index) {
                                name_route = name_route.concat('-',values[index]);
                            }
                            name_route = name_route.concat('_',strUser);
                            name_route = name_route.replace(/\s/g, '');
                            var id_user = "<?php echo $id_user; ?>";
                            console.log(name_route);

                            if (file_path != "") {
                                console.log("pas null");


                                var data_save = {
                                    'id_user'              : id_user,
                                    'name_route'             : name_route,
                                    'file_path'                : id+"/"+file_path,
                                    'type'                  : 'multi'
                                };
                                console.log(data_save);
                                $.ajax({
                                    type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
                                    url         : 'save_favori.php', // the url where we want to POST
                                    data        : data_save,
                                    processData: true // our data object
                                })
                                    // using the done promise callback
                                    .done(function(data) {

                                        // log data to the console so we can see
                                        //console.log(data);
                                        console.log(data);
                                        var json_data = JSON.parse(data);
                                        console.log(json_data);
                                        console.log(json_data.heures);
                                        if (json_data.success != true) {
                                            console.log("erreur");
                                        }
                                        else {
                                            alert("Favori enregistré !");
                                        }

                                        // here we will handle errors and validation messages
                                    }).fail(function() {
                                    alert("erreur");
                                });


                            }
                            else {
                                alert("Vous devez avoir saisi un itineraire pour l'enregistrer ! ");
                            }


                            event.preventDefault();
                        });
                    });

                </script>



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