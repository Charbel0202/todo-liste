<!DOCTYPE html>
<html>
<head>
  <title>Création de compte</title>
  <link rel="stylesheet" type="text/css" href="css/registration.css">
    <link rel="icon" type="image/ico" href="favicon.png">
</head>
<body>
  <div class="container">
    <h1>Creer un compte</h1>
    <form action="registration.php" method="POST">

      <label for="pseudo">Pseudo:</label>
      <input type="text" id="pseudo" name="z_pseudo" placeholder="Pseudo">

      <label for="email">Email:</label>
      <input type="email" id="email" name="z_email" placeholder="Email">

      <label for="password">Mot de passe:</label>
      <input type="password" id="password" name="z_password1" placeholder="Mot de passe">

      <label for="password">Confirmation du Mot de passe:</label>
      <input type="password" id="password" name="z_password2" placeholder="Mot de passe">

      <input type="submit" name="valider" value="Creer un compte">

    </form>
    <a href="index.php">Avez-vous deja un compte ?</a>
  </div>
</body>
</html>


<?php
include ("connexion.php");
session_start();

if (isset($_POST['valider']))
{
    if (empty($_POST['z_pseudo']))
    {
        echo "<script>alert('Veuillez renseigner votre nom d'utilisateur') </script>";
    }
    else{
        if (empty($_POST['z_email']))
        {
            echo "<script>alert('Veuillez renseigner votre mail') </script>";
        }
        else{
            if (empty($_POST['z_password1']))  
            {
                echo "<script>alert('Veuillez renseigner le mot de passe') </script>";
            }
            else{
                if (empty($_POST['z_password2']))  
                {
                    echo "<script>alert('Veuillez renseigner de nouveau le mot de passe') </script>";
                }
                else{
                    $pseudo =$_POST['z_pseudo'];
                    $email = $_POST['z_email'];
                    $pass1 = $_POST['z_password1'];
                    $pass2 = $_POST['z_password2'];
                    if ($pass1!=$pass2) {
                        echo"<script>alert('Mot de passe incorrect') </script>";
                        header("Location: registration.php");
                    } else {
                        $req1 = "INSERT into users values('','$pseudo','$email','$pass2')";
                        if ($bdd ->query($req1)==true)
                        {
                    $_SESSION['user_id'] = $resultats[0]['userID'];
                             echo "<script>alert('Création effectué avec succes') </script>";
                             header("Location: index.php");
                        }
                         else{
                             echo "<script>alert('Echec') </script>";
                         }
                    }

                }
                    
            }
                
        }
            
    }
        
}

?>