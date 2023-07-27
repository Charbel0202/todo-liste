
<?php
include("connexion.php");


if (isset($_POST['modifier'])){
    if(empty($_POST['task_update']))
    {
        echo"<script>alert('Champs vide !') </script>";
    } else {
        $id = $_GET['task_id'];
        $task = $_POST['task_update'];
        $req ="UPDATE tasks set taskDescription='$task' where taskID = '$id' ";
        
        if($bdd->query($req)==true)
        {
          echo"<script>alert('Modifié avec succes')</script>";
        }
        else{
          echo"<script>alert('Echec de la modification')</script>";
          header("Location: liste.php");
          exit();
        }
    }
}else {
    if (isset($_POST['annuler'])){
        header("Location: liste.php");
        exit();
    }
}


?>
