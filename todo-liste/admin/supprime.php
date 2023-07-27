<?php
include("../connexion.php");

if (isset($_GET['num'])) {
    $user_id = $_GET['num'];

    // Récupérer toutes les listes de tâches de l'utilisateur
    $req_lists = $bdd->prepare("SELECT listID FROM todolists WHERE userID = :user_id");
    $req_lists->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $req_lists->execute();
    $lists = $req_lists->fetchAll(PDO::FETCH_ASSOC);

    // Supprimer toutes les tâches associées aux listes de tâches de l'utilisateur
    foreach ($lists as $list) {
        $list_id = $list['listID'];
        $req_delete_tasks = $bdd->prepare("DELETE FROM tasks WHERE listID = :list_id");
        $req_delete_tasks->bindParam(':list_id', $list_id, PDO::PARAM_INT);
        $req_delete_tasks->execute();
    }

    // Supprimer toutes les listes de tâches associées à l'utilisateur
    $req_delete_lists = $bdd->prepare("DELETE FROM todolists WHERE userID = :user_id");
    $req_delete_lists->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $req_delete_lists->execute();

    // Supprimer l'utilisateur
    $req_delete_user = $bdd->prepare("DELETE FROM users WHERE userID = :user_id");
    $req_delete_user->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    if ($req_delete_user->execute()) {
        // Rediriger vers la page administrateur après la suppression de l'utilisateur
        echo"<script>alert('supprime avec succes')</script>";
        header("Location: administrateur.php");
        exit();
    } else {
        echo "Erreur lors de la suppression de l'utilisateur : " . $req_delete_user->errorInfo()[2];
    }
} else {
    echo "ID d'utilisateur non spécifié dans l'URL";
}
?>
