<?php
include("connexion.php");
$id = $_GET['task_id'];
$req = " DELETE from tasks where taskID = $id ";
$reponse = $bdd->query($req);
$resultat = $reponse->fetchAll();

if($bdd->query($req)==true)
{
  echo"<script>alert('Supprimé avec succes')</script>";
  header("Location: liste.php");
  exit();
}
else{
  echo"<script>alert('Echec de la suppression')</script>";
  header("Location: liste.php");
  exit();
}
?>