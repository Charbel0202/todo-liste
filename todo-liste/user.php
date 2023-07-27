<?php
session_start();
include("connexion.php");

// Vérifiez si l'utilisateur est connecté (a une session active)
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    if (isset($_POST['valider'])) {
        if (empty($_POST['z_liste'])) {
            echo "<script>alert('Veuillez renseigner le nom de la liste de tâches')</script>";
        } else {
            $liste = $_POST['z_liste'];

            // Vérifiez si la liste existe déjà pour cet utilisateur
            $req1 = $bdd->prepare("SELECT listID FROM todolists WHERE userID = :user_id AND listName = :liste_name");
            $req1->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $req1->bindParam(':liste_name', $liste, PDO::PARAM_STR);
            $req1->execute();

            if ($req1->rowCount() > 0) {
                echo "<script>alert('La liste existe déjà pour cet utilisateur')</script>";
            } else {
                // La liste n'existe pas encore, insérer dans la table
                $req2 = $bdd->prepare("INSERT INTO toDoLists (userID, listName) VALUES (:user_id, :liste_name)");
                $req2->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $req2->bindParam(':liste_name', $liste, PDO::PARAM_STR);

                if ($req2->execute()) {
                    echo "<script>alert('Création effectuée avec succès')</script>";
                    // Récupérer l'ID de la nouvelle liste insérée
                    $new_list_id = $bdd->lastInsertId();

                    // Rediriger vers la page "liste.php" en incluant l'ID de la nouvelle liste dans l'URL
                    header("Location: liste.php?listID={$new_list_id}");
                    exit();
                } else {
                    echo "Erreur d'insertion : " . $req2->errorInfo()[2];
                }
            }
        }
    }

    // Code pour supprimer une liste
    if (isset($_GET['delete_list'])) {
        $listID = $_GET['delete_list'];

        // Vérifiez si la liste appartient à l'utilisateur actuel avant de la supprimer
        $req3 = $bdd->prepare("SELECT listID FROM todolists WHERE userID = :user_id AND listID = :list_id");
        $req3->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $req3->bindParam(':list_id', $listID, PDO::PARAM_INT);
        $req3->execute();

        if ($req3->rowCount() > 0) {
            // La liste appartient à l'utilisateur, supprimez-la
            $req4 = $bdd->prepare("DELETE FROM todolists WHERE listID = :list_id");
            $req4->bindParam(':list_id', $listID, PDO::PARAM_INT);
            if ($req4->execute()) {
                echo "<script>alert('La liste a été supprimée avec succès')</script>";
            } else {
                echo "Erreur lors de la suppression de la liste : " . $req4->errorInfo()[2];
            }
        } else {
            echo "<script>alert('Cette liste ne vous appartient pas')</script>";
        }
    }

    // Code pour afficher toutes les listes créées par l'utilisateur
    $req5 = $bdd->prepare("SELECT listID, listName FROM todolists WHERE userID = :user_id");
    $req5->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $req5->execute();
    $user_lists = $req5->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "L'identifiant de l'utilisateur n'existe pas";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Espace utilisateur</title>
    <link rel="stylesheet" type="text/css" href="css/registration.css">
    <link rel="icon" type="image/ico" href="favicon.png">
</head>
<body>
    <div class="container">
        <h1>Bonjouuuuur !!!!</h1>
        <h2>bienvenue dans votre ToDoList</h2>
        <form action="user.php" method="POST">

            <label for="liste">Nom de la liste:</label>
            <input type="text" id="liste" name="z_liste" placeholder="Veuillez entrer le nom de la liste">

            <input type="submit" name="valider" value="Creer une liste">

        </form>

        <h2>Listes existantes :</h2>
        <ul style="list-style-type: none;">
            <?php
            if (isset($user_lists) && !empty($user_lists)) {
                foreach ($user_lists as $list) {
                    echo "<li style='display: flex; align-items: center;'> <img style='height: 16px; width: 16px;' src='favicon.png' alt='favicon' /> - <a href='liste.php?listID={$list['listID']}'>{$list['listName']}</a></li>";
                }
            } else {
                echo "<li style='display: flex; align-items: center;'><img style='height: 16px; width: 16px;' src='favicon.png' alt='favicon' /> Aucune liste trouvée</li>";
            }
            ?>
        </ul>
    </div>
</body>
</html>
