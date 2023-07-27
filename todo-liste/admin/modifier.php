<?php
include("../connexion.php");

if (isset($_POST['valider'])) {
    $user_id = $_GET['num'];
    $nom = $_POST['s_Nom'];
    $prenom = $_POST['s_prenom']; // Ajout du champ prénom
    $email = $_POST['s_email'];
    $mdp = $_POST['s_mdp'];

    if (empty($nom) || empty($email) || empty($mdp)) {
        echo "<script>alert('Veuillez remplir tous les champs')</script>";
    } else {
        // Vérification de l'existence du compte
        $req1 = "SELECT * FROM users WHERE userID = $user_id";
        $reponse = $bdd->query($req1);
        $resultat = $reponse->fetchAll();

        // Vérification de la requête
        if (!$resultat) {
            echo "<script>alert('Ce matricule n'existe pas')</script>";
        } else {
            $req2 = "UPDATE users SET username = '$nom',  email = '$email', passwrd = '$mdp' WHERE userID = $user_id";

            if ($bdd->query($req2)) {
                header("Location: administrateur.php");
                exit();
                echo "<script>alert('Modification effectuée avec succès')</script>";
            } else {
                echo "<script>alert('Echec de la modification')</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/modifier.css">
    <title>Formulaire de modification</title>
    <link rel="icon" type="image/ico" href="favicon.png">
</head>
<body>
    <div class="container">
        <h1>Modification</h1>
        <form action="modifier.php?num=<?php echo $_GET['num']; ?>" method="POST">
            <label>Nom :</label>
            <input type="text" name="s_Nom" placeholder="Nom">
                        
            <label>Email :</label>
            <input type="email" name="s_email" placeholder="Adresse mail">
                        
            <label>Mot de passe :</label>
            <input type="password" name="s_mdp" placeholder="Mot de passe">
            <p>
                <input type="submit" name="valider" value="Valider">
                <input type="reset" value="Annuler">
            </p>
        </form>
    </div>
</body>
</html>
