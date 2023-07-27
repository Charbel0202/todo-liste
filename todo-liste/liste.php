<?php
session_start();
include("connexion.php");

// Vérifier si l'utilisateur est connecté (a une session active)
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Récupérer le nom d'utilisateur de l'utilisateur à partir de la base de données
    $req_user = $bdd->prepare("SELECT username FROM Users WHERE userID = :user_id");
    $req_user->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $req_user->execute();
    $user = $req_user->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'ID de la liste est spécifié dans l'URL
    if (isset($_GET['listID'])) {
        $list_id = $_GET['listID'];

        // Récupérer les détails de la liste de tâches de l'utilisateur depuis la base de données
        $req_list = $bdd->prepare("SELECT * FROM ToDoLists WHERE listID = :list_id AND userID = :user_id");
        $req_list->bindParam(':list_id', $list_id, PDO::PARAM_INT);
        $req_list->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $req_list->execute();
        $list_details = $req_list->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'ID de la liste récupéré est valide
        if ($list_details) {
            // Récupérer les tâches de la liste spécifique
            $req_tasks = $bdd->prepare("SELECT * FROM Tasks WHERE listID = :list_id");
            $req_tasks->bindParam(':list_id', $list_id, PDO::PARAM_INT);
            $req_tasks->execute();
            $tasks = $req_tasks->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "ID de liste invalide ou non autorisé pour cet utilisateur";
            exit();
        }
    } else {
        echo "ID de liste non spécifié dans l'URL";
        exit();
    }
} else {
    echo "L'identifiant de l'utilisateur n'existe pas";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue <?php echo $user['username']; ?></title>
    <link rel="stylesheet" href="css/taskListe.css">
    <link rel="icon" type="image/ico" href="favicon.png">
</head>
<body>
    <div class="container">
        <h1>Bienvenue <?php echo $user['username']; ?> !</h1>
        <?php if ($list_details) { ?>
            <h2>Votre Todo List: <?php echo $list_details['listName']; ?></h2>
            <ul>
                <?php foreach ($tasks as $task) { ?>
                    <li><span><?php echo $task['taskDescription']; ?></span> <span class="lien">  <a class="supr" href="delete_task.php?listID=<?php echo $list_id; ?>&task_id=<?php echo $task['taskID']; ?>">Supprimer</a></span></li>
                <?php } ?>
            </ul>
            <form action="ajout.php?listID=<?php echo $list_id; ?>" method="POST">
                <input type="text" name="task_description" placeholder="Nouvelle tache" required>
                <input type="submit" value="Ajouter">
            </form>
        <?php } else { ?>
            <h2>Liste non trouvée</h2>
        <?php } ?>
        
        <form style="text-align: right;" action="deconnexion.php" method="POST">
            <input type="submit" value="Déconnexion">
        </form>
    </div>
</body>
</html>
