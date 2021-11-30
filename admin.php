<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ici.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <title>Document</title>
</head>

<?php
    
    session_start();
    
    if(isset($_POST["deconnexion"]))
    {
        session_destroy();
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
                echo "<a href='profil.php'>Mon profil</a> ";
                
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
    <table class="tabadmin">

        <?php

            $bdd = mysqli_connect("localhost", "root", "", "moduleconnexion");
            $rqt = mysqli_query($bdd, "SELECT * FROM utilisateurs");
            $rec = mysqli_fetch_assoc($rqt); // on récupère toutes les informations
            $rslt = mysqli_fetch_all($rqt);

            foreach($rec as $key=>$values)
            {
                echo "<th> $key </th>"; //et on les affiches ici et
            }
            echo "<thead><tr></tr></thead>";

            foreach($rslt as $key=>$values)
            {
                echo "<tr>";
                foreach($values as $key=>$values)
                {
                    echo "<td> $values </td>"; // ici.
                }
                echo "</tr>";
            }

        ?>

    </table>

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