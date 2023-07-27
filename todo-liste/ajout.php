<?php
session_start();
include("connexion.php");

// Vérifier si l'utilisateur est connecté (a une session active)
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Vérifier si le formulaire d'ajout de tâche a été soumis
    if (isset($_POST['task_description']) && isset($_GET['listID'])) {
        $task_description = $_POST['task_description'];
        $list_id = $_GET['listID'];

        // Vérifier si l'utilisateur est autorisé à ajouter une tâche à cette liste
        $req_list = $bdd->prepare("SELECT * FROM ToDoLists WHERE listID = :list_id AND userID = :user_id");
        $req_list->bindParam(':list_id', $list_id, PDO::PARAM_INT);
        $req_list->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $req_list->execute();
        $list_details = $req_list->fetch(PDO::FETCH_ASSOC);

        if ($list_details) {
            // Insérer la nouvelle tâche dans la table Tasks
            $req_add_task = $bdd->prepare("INSERT INTO Tasks (listID, taskDescription, isCompleted) VALUES (:list_id, :task_desc, false)");
            $req_add_task->bindParam(':list_id', $list_id, PDO::PARAM_INT);
            $req_add_task->bindParam(':task_desc', $task_description, PDO::PARAM_STR);

            if ($req_add_task->execute()) {
                // Rediriger l'utilisateur vers la page "liste.php" après l'ajout de la tâche
                header("Location: liste.php?listID=$list_id");
                exit();
            } else {
                echo "Erreur d'insertion de la tâche : " . $req_add_task->errorInfo()[2];
                exit();
            }
        } else {
            echo "ID de liste invalide ou non autorisé pour cet utilisateur";
            exit();
        }
    } else {
        // Le formulaire d'ajout n'a pas été soumis correctement, rediriger vers la page "liste.php"
        header("Location: liste.php");
        exit();
    }
} else {
    echo "L'identifiant de l'utilisateur n'existe pas";
    exit();
}
?>
