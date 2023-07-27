<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification</title>
    <link rel="stylesheet" href="css/taskListe.css">
    <link rel="icon" type="image/ico" href="favicon.png">
</head>
<body>
    <div class="container">
        <h1>Modification</h1>
        <form class="forMod" action="mod.php" method="POST">
            <input type="text" name="task_update" placeholder="Modifier la tache" required>
            <input type="submit" name="modifier" value="Modifier">
            <input type="submit" name="annuler" value="Annuler">
        </form>
    </div>
</body>
</html>



