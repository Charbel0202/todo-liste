<?php
include("../connexion.php");

// Requête SQL pour sélectionner toutes les colonnes de la table "users"
$req = "SELECT * FROM users";

// Exécution de la requête
$reponse = $bdd->query($req);

// Récupération de tous les résultats sous forme d'un tableau associatif
$resultat = $reponse->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Interface Administrateur</title>
    <link rel="stylesheet" type="text/css" href="../css/administrateur.css">
</head>
<body>
    <div class="container">
        <h1>Interface Administrateur</h1>
        <h2>Liste de tous les utilisateurs :</h2>
        
        <table width="900" bgcolor="#bbbbbb">
            <!--entête du tableau-->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Mail</th>
                    <th>MDP</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <!--Corps du tableau-->
            <tbody>
            <?php foreach ($resultat as $user) { ?>
                <tr bgcolor="#eeeeee">
                    <td><?= $user['userID'] ?></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['passwrd'] ?></td>
                    <td align="center"><a href="modifier.php?num=<?= $user['userID'] ?>">Modifier</a></td>
                    <td align="center"><a href="supprime.php?num=<?= $user['userID'] ?>">Supprimer</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        
        <form style="text-align: right;" action="../deconnexion.php" method="POST">
            <input style="margin-top: 20px;" type="submit" value="Déconnexion">
        </form>
    </div>
</body>
</html>
