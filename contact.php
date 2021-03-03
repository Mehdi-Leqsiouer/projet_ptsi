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
<!--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<!--<script src="form.js"></script>-->
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

    <link rel="stylesheet" type="text/css" href="style_contact.css">

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

<div class="container contact-form">
    <div class="contact-image">
        <img src="https://image.ibb.co/kUagtU/rocket_contact.png" alt="rocket_contact"/>
    </div>
    <form name = "formName" id = "formName" method="GET" autocomplete="off">
        <h3>Laissez-nous un message</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Votre prénom *" value="" />
                </div>
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="Votre e-mail *" value="" />
                </div>
                <div class="form-group">
                    <input type="text" name="phone" class="form-control" placeholder="Votre numéro de téléphone (optionnel)" value="" />
                </div>
                <div class="form-group">
                    <input type="submit" name="btnSubmit" class="btnContact" value="Envoyer message" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <textarea name="message" class="form-control" placeholder="Your Message *" style="width: 100%; height: 150px;"></textarea>
                </div>
            </div>

    </form>

    <div class="col-12">
        <a  type="submit" href = "deconnection.php">Se déconnecter</a>
    </div>
    <div class="text-white">
    </div>

    <script>
        $(document).ready(function() {

            // process the form
            $('#formName').submit(function(event) {
                event.preventDefault();
                // get the form data
                // there are many ways to get this data using jQuery (you can use the class or id also)
                var formData = {
                    'name'              : $('input[name=name]').val(),
                    'email'             : $('input[name=email]').val(),
                    'phone'             : $('input[name=phone]').val(),
                    'message'             : $('textarea[name=message]').val()
                };
                // process the form
                $.ajax({
                    type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
                    url         : 'send_contact.php', // the url where we want to POST
                    data        : formData // our data object
                })
                    // using the done promise callback
                    .done(function(data) {

                        // log data to the console so we can see
                        console.log(data);
                        var json_data = JSON.parse(data);
                        console.log(json_data.success);
                        if (json_data.success != true) {
                            console.log("erreur");
                        }
                        else{
                            $('#formName').html('<div class="alert alert-success">' + json_data.message + '</div> <a  type="submit" href = "deconnection.php">Se déconnecter</a>');
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
</div>
</body>
</html>
</html>