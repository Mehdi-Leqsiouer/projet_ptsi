<?php
	session_start();
	if(isset($_SESSION["prenom"])) {
		header("Location: distance.php");
	}
?>


<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Login Page</title>
   <!--Made with love by Mutiullah Samim -->
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="css/styles.css">

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

</head>
<body>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
<div class="container">
    <div class="card card-login mx-auto text-center bg-dark">
        <div class="card-header mx-auto bg-dark">
            <!--<span> <img src="https://amar.vote/assets/img/amarVotebd.png" class="w-75" alt="Logo"> </span><br/>-->
			 <span class="logo_title mt-5"> PROJET DISTANCE </span></br>
                        <span class="logo_title mt-5"> Connexion </span>

        </div>
        <div class="card-body">
            <?php if (isset($_GET['fail'])) echo "<p style='color:red;'>Identifiant/Mdp incorrects ! </p>";?>
            <form action="login.php" method="GET">
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" name="identifiant" id = "identifiant" class="form-control" placeholder="Identifiant" required>
                </div>

                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" name="password" id = "password" class="form-control" placeholder="Mot de passe" required>
                </div>

                <div class="form-group">
                    <input type="submit" name="btn" value="Connexion" class="btn btn-outline-danger float-right login_btn">
                </div>

            </form>
			<div class="form-group">
                    <a name="inscription" value="inscription" class="btn btn-outline-danger float-right login_btn" href = "inscription_html.php">Inscription</a>
                </div>
        </div>
    </br>
        </br>
        <p style ="color:white;">Projet créé et développé dans le cadre du projet PTSI de l'ESILV</p>
        <p style ="color:white;">Mehdi LEQSIOUER --- Nada MATROUF --- Badr QOTB</p>
    </div>
</div>
</body>
</html>