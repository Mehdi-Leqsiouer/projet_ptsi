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
         var file_path = "";
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(map);

		/*L.marker([51.5, -0.09]).addTo(map)
			.bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
			.openPopup();*/

         var id = "<?php echo $id; ?>";
		/*var geojsonLayer = new L.GeoJSON.AJAX(id+"/result.geojson");
		$.getJSON(id+"/result.geojson", function(json) {
			//console.log(json); // this will show the info it in firebug console
			var metadata = json.metadata;
			var query = metadata.query;
			var coord = query.coordinates;
			var depart = coord[0];
			var arriver = coord[1];
			var depart = [coord[1],coord[0]];
            var arriver = [coord[3],coord[2]];
            console.log(depart);
			L.marker([depart[1], depart[0]]).addTo(map)
			.bindPopup('Point de départ')
			.openPopup();
			L.marker([arriver[1], arriver[0]]).addTo(map)
			.bindPopup("Point d'arrivé")
			.openPopup();
		});
		geojsonLayer.addTo(map);*/
		
		 </script>
      
      <div class="col-md-6">
        <h2 class="text-uppercase mt-3 font-weight-bold text-white">DISTANCE</h2>
		
		<h3 class="text-uppercase mt-4 font-weight-bold text-white"><?php echo "Bienvenue ".$nom." ".$prenom?></h3>
		
        <form role = "form" name ="distance" id = "distance" autocomplete="off" method = "GET" >
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <input type="text" id = "depart" name = "depart" class="form-control mt-2" placeholder="Rue de départ" value = "<?php echo $depart ?>" >
              </div>
            </div>
			<div class="col-lg-6">
              <div class="form-group">
                <input type="text" id = "ville_depart" name = "ville_depart" class="form-control mt-2" placeholder="Ville de départ *" value = "<?php echo $v1 ?>" required>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <input type="text" id = "arriver" name = "arriver" class="form-control mt-2" placeholder="Rue d'arrivé" value = "<?php echo $arriver ?>" >
              </div>
            </div>
			<div class="col-lg-6">
              <div class="form-group">
                <input type="text" id = "ville_arriver" name = "ville_arriver" class="form-control mt-2" placeholder="Ville d'arrivée *" value = "<?php echo $v2 ?>" required>
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
                <input type="text" id = "distance_affichage" name = "distance_affichage" placeholder = "Distance en km" class="form-control mt-2" value ="<?php echo $km ?>" readonly>
              </div>
            </div>
			
			<div class="col-lg-6">
              <div class="form-group">			
                <input type="text" id = "temps" name = "temps" class="form-control mt-2" placeholder = "Temps" value ="<?php echo $heures.$minutes ?>" readonly>
              </div>
            </div>

              <div class="col-lg-6">
                  <input type="checkbox" id = "pois" name = "pois" class="form-control mt-2"  value = "Afficher les pois" checked>
                  <label for="pois">Afficher les points d'intérets</label>
              </div>

            <div class="col-12">
              <button class="btn btn-light" type="submit">Envoyer</button>
            </div>
          </div>
        </form>
          <form name ="save_favori" id = "save_favori" method = "GET">
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

                      $query = "select nom_favori,path from Favoris where id_user = $id_user and type = 'simple'";
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
                      option.selected = true;
                      var tmp_path = option.id;

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

                  // process the form
                  $('#distance').submit(function(event) {
                      event.preventDefault();
                      // get the form data
                      // there are many ways to get this data using jQuery (you can use the class or id also)
                      //console.log(values);
                      var e = document.getElementById("mode");
                      var strUser = e.options[e.selectedIndex].text;
                      var id = "<?php echo $id; ?>";
                      var formData = {
                          'depart'              : $('input[name=depart]').val(),
                          'arriver'              : $('input[name=arriver]').val(),
                          'ville_depart'              : $('input[name=ville_depart]').val(),
                          'ville_arriver'              : $('input[name=ville_arriver]').val(),
                          'mode'             : strUser,
                          'identifiant' : id
                      };
                      console.log(formData);
                      // process the form
                      $.ajax({
                          type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
                          url         : 'calcul_distance.php', // the url where we want to POST
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
                                  $("#distance_affichage").val(json_data.km+" kilomètres");
                                  $("#temps").val(json_data.heures+" heures "+json_data.minutes+" minutes");

                                  file_path = json_data.path;
                                  var file_pois = json_data.pois;
                                  console.log(file_path);
                                  var id = "<?php echo $id; ?>";
                                  var geojsonLayerV2 = new L.GeoJSON.AJAX(id+"/"+file_path);
                                  $.getJSON(id+"/"+file_path, function(json) {
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
                      })
                      ;

                      // stop the form from submitting the normal way and refreshing the page
                      event.preventDefault();
                  });

              });
          </script>


          <script>

              $(document).ready(function() {
                  $('#save_favori').submit(function(event) {
                      event.preventDefault();
                      //console.log(values);
                      // action="save_favori.php"
                      var e = document.getElementById("mode");
                      var strUser = e.options[e.selectedIndex].text;

                      var name_route = $('input[name=depart]').val()+$('input[name=ville_depart]').val()+"-"+$('input[name=arriver]').val()+$('input[name=ville_arriver]').val();
                      name_route = name_route.replace(/\s/g, '');

                      name_route = name_route.concat('_',strUser);
                      var id_user = "<?php echo $id_user; ?>";
                      console.log(name_route);

                      if (file_path != "") {
                          console.log("pas null");


                          var data_save = {
                              'id_user'              : id_user,
                              'name_route'             : name_route,
                              'file_path'                : id+"/"+file_path,
                              'type'                    :'simple'
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
    <link rel="stylesheet" type="text/css" href="footer.css">
    <footer>
    <div id="footer">
        test
    </div>
    </footer>

</div>
<!--
<div class="row text-center bg-success text-white" id="author">
  <div class="col-12 mt-4 h3 ">
      test !!
</div>
<div class="col-12 my-2">

</div>


</div>-->

</body>

    <!--Bottom Footer-->

    <!--Bottom Footer-->

</html>