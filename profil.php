<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ici.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <title>Mon profil</title>
</head>

<?php

//ouverture de la session
session_start();

if(isset($_POST["deconnexion"]))
{
    session_destroy();
    header("location:connexion.php");
}
//Modification du profil

$bdd = mysqli_connect("localhost:3306", "mze-idrisse", "dztrzv5v6", "idrisse-mze-hamadi_module-connexion"); //On ce connecte a la base de donnée

if (isset($_SESSION["login"])) // Quand on est connecté
{
    $login = $_SESSION["login"];
    $rq = mysqli_query($bdd, "SELECT  prenom, nom, password FROM utilisateurs WHERE login='$login'"); //on selectionne p, n et mdp
    $ri = mysqli_fetch_assoc($rq); //on les récupère
    $prenom = $ri['prenom'];
    $nom = $ri['nom'];
    $password = $ri['password'];
                
    if (isset($_POST["modification"])) // Quand on appuis sur valider 
    {

        $nlogin = $_POST["login"];
        $prenom = $_POST["prenom"];
        $nom = $_POST["nom"];
        $password = $_POST["password"];
        $npassword = $_POST["npassword"];
        $rnpassword = $_POST["rnpassword"];

        $rqt = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE login='$login' and password='$npassword'"); // Nous faisons une requête et on vérifie les informations.
        $rr = mysqli_num_rows($rqt);
        
        if ($rr == 1)
        {
            echo "Le login ou le mot de passe sont déja pris!";
        }
        elseif ($rnpassword != $npassword)
        {
            echo "Les mots de passe sont différents";
        }
        else
        {
            // si toutes les informations rentré ne sont pas connu de la base de donnée la modification sera faite.
            $rqtu = mysqli_query($bdd, "UPDATE utilisateurs SET login='$nlogin', prenom='$prenom', nom='$nom', password='$npassword' WHERE login='$login'");            
            $_SESSION["login"] = $nlogin;
            $_SESSION["prenom"] = $prenom;
            $_SESSION["nom"] = $nom;
            $_SESSION["password"] = $npassword;
            $_SESSION["npassword"] = $npassword;
            $_SESSION["rnpassword"] = $npassword;

            if ($rqtu)
            {
                echo "modification réussie.";
            }
            else
            {
                echo "modification échoué";
            }
        }
    }
    elseif (isset($_POST["annuler"]))
    {
        header("location:index.php");
    }
}
else
{
    header("location:connexion.php");
}

?>

<body>
    
    <header>

        <a href="index.php"><h2>module de connexion</h2></a>

        <div>
            <?php
            if(isset($_SESSION["login"]))
            {
                echo "Connecté à ".$_SESSION["login"];
                echo "<form action='' method='post'><input type='submit' name='deconnexion' value='se deconnecter'></form>";
                echo "<a href='profil.php'>Mon profil</a>";
                
                if($_SESSION["login"] == "admin")
                {
                    echo "<a href='admin.php'>administrateur</a>";
                }
            }
            else
            {
                echo "<a href='connexion.php'>Se connecter</a> ";
                echo "<a href='inscription.php'>S'inscrire</a>";
            }
            ?>
        </div>

    </header>
    <!--Formulaire d'inscription-->

    <form action="" method="post">
        <div class="pro">

            <h1>Modifier son profil</h1>
            <p>Veuillez remplir ce formulaire pour modifier les informations de votre profil.</p>
            
            <hr>
                <div class="inlapro">
                    <label for="login"><b>Login</b></label>
                    <input type="text" placeholder="Login" name="login" value="<?php echo ($_SESSION["login"]);?>"required>

                    <label for="prenom"><b>Prénom</b></label>
                    <input type="text" placeholder="Votre Prénom" name="prenom" value="<?php echo ($prenom);?>"required>
                    
                    <label for="nom"><b>Nom</b></label>
                    <input type="text" placeholder="Votre Nom" name="nom" value="<?php echo ($nom);?>"required>
                    
                    <label for="password"><b>Mot de passe</b></label>
                    <input type="password" placeholder="Votre mot de passe actuel" name="password" value="<?php echo ($password);?>"required>

                    <label for="npassword"><b>Nouveau mot de passe</b></label>
                    <input type="password" placeholder="Votre nouveau mot de passe" name="npassword">

                    <label for="rnpassword"><b>Confirmation du nouveau mot de passe</b></label>
                    <input type="password" placeholder="Confirmation du nouveau mot de passe" name="rnpassword">
                </div>
            <hr>

            <div class="inp">
                <input type="submit" name="modification" class="button_inp" value="valider" action="">
                <input type="submit" name="annuler" class="button_inp" value="annuler" action="">
            </div>

        </div>
    </form>

    <footer>
        <div class="footer-content">
            <h3>module de connexion</h3>
            <p>Liens utiles:</p>
            <ul class="socials">
                <li><a href="https://www.youtube.com/watch?v=jEgzxXCB9-w"><i class="fa fa-youtube"></i></a></li>
                <li><a href="https://github.com/idrisse-mze-hamadi/module-connexion"><i class="fa fa-github"></i></a></li>
            </ul>
        </div>
    </footer>

</body>
</html>