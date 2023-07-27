<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/ico" href="favicon.png">
</head>
<body>
    <div class="container">
        <h1>connexion</h1>
        <form action="log.php" method="POST">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="s_username" placeholder="Nom d'utilisateur">

            <label for="password">Email:</label>
            <input type="email" id="email" name="s_email" placeholder="Email">

            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="s_password" placeholder="Mot de passe">

            <input type="submit" name="valider" value="Se connecter">
            <a href="registration.php">creer un compte</a>
        </form>
    </div>
</body>
</html>

