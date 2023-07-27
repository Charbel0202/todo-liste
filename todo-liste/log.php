<?php
session_start();
include("connexion.php");
if (isset($_POST['valider'])){
    if(empty($_POST['s_username']))
    {
        echo"<script>alert('Veuillez entrer votre nom d'utilisateur') </script>";
        header("Location: my-tdl.rf.gd");
        exit();
    } else {
        if(empty($_POST['s_email']))
        {
            echo"<script>alert('Veuillez entrer votre adresse mail')</script>";
            header("Location: my-tdl.rf.gd");
            exit();
        } else {
            if (empty($_POST['s_password']))
            {
                echo"<script>alert('Veuillez entrer votre mot de passe')</script>";
                header("Location: my-tdl.rf.gd");
                exit();
            } else {
                $username = $_POST['s_username'];
                $email = $_POST['s_email'];
                $password = $_POST['s_password'];
                if ($username == "CharbAdmin02"  && $email == "hnzcharbel@gmail.com" && $password == "Charb@0202") {
                    header("Location: admin/administrateur.php");
                    exit();
                } else {
                    $req1 = "SELECT * FROM users WHERE username='$username' AND email='$email' AND passwrd='$password'";
                    $reponse = $bdd->query($req1);
                    $resultats =  $reponse-> fetchAll();
                    
                    if ($resultats) {
                        $_SESSION['user_id'] = $resultats[0]['userID'];
                        header("Location: user.php");
                        exit();
                    }else {
                        header("Location: registration.php");
                        exit();
                    }
                }

            }
            
        }
    }
}
?>