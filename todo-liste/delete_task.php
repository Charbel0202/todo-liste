<?php
session_start();
include("connexion.php");

// Vérifier si l'utilisateur est connecté (a une session active)
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Vérifier si l'ID de la liste est spécifié dans l'URL
    if (isset($_GET['listID']) && isset($_GET['task_id'])) {
        $list_id = $_GET['listID'];
        $task_id = $_GET['task_id'];

        // Vérifier si la tâche appartient à la liste de l'utilisateur actuel avant de la supprimer
        $req_check_task = $bdd->prepare("SELECT taskID FROM Tasks WHERE listID = :list_id AND taskID = :task_id");
        $req_check_task->bindParam(':list_id', $list_id, PDO::PARAM_INT);
        $req_check_task->bindParam(':task_id', $task_id, PDO::PARAM_INT);
        $req_check_task->execute();

        if ($req_check_task->rowCount() > 0) {
            // La tâche appartient à la liste de l'utilisateur, supprimez-la
            $req_delete_task = $bdd->prepare("DELETE FROM Tasks WHERE listID = :list_id AND taskID = :task_id");
            $req_delete_task->bindParam(':list_id', $list_id, PDO::PARAM_INT);
            $req_delete_task->bindParam(':task_id', $task_id, PDO::PARAM_INT);
            if ($req_delete_task->execute()) {
                echo "<script>alert('La tâche a été supprimée avec succès')</script>";
                // Rediriger l'utilisateur vers la page "liste.php" après la suppression de la tâche
                header("Location: liste.php?listID={$list_id}");
                exit();
            } else {
                echo "Erreur lors de la suppression de la tâche : " . $req_delete_task->errorInfo()[2];
            }
        } else {
            echo "<script>alert('Cette tâche ne vous appartient pas ou n'existe pas dans la liste spécifiée')</script>";
        }
    } else {
        echo "ID de liste ou d'utilisateur non spécifié dans l'URL";
        exit();
    }
} else {
    echo "L'identifiant de l'utilisateur n'existe pas";
    exit();
}
?>
