<?php
session_start();

// Détruire la session active
session_destroy();

// Rediriger vers la page de connexion (ou toute autre page souhaitée)
header("Location: index.php");
exit();
?>
