<?php
include_once('../tools/autoload.php');
session_start();
if(count($_SESSION) > 0) {
     include_once('../tools/header.php'); 
     include_once('../tools/navbar.php');
     $task = new task();
     $todolist = $task->getAllTask();
     $row = count($todolist);
     if(isset($_POST["modify"])) {
          $_SESSION['idtache'] = $_POST['id'];
          header('Location: ./ModifTask.php');
          $_SESSION['last'] = "admin";
     }
     if(isset($_POST["comment"])) {
          $_SESSION['idtache'] = $_POST['id'];
          header('Location: ./CommentTask.php');
     }
     if(isset($_POST["delete"])) {
          $_SESSION['idtache'] = $_POST['id'];
          $_SESSION['tache'] = $_POST['nom'];
          $task->delTask();
     }
     ?>
     
<h1 class="text-center">Liste des Taches</h1>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="width:3%">Id</th>
      <th scope="col" style="width:10%">Nom</th>
      <th scope="col" style="width:auto">Détail</th>
      <th scope="col" style="width:5%; text-align:center;">A faire</th>
      <th scope="col" style="width:5%; text-align:center;">En cours</th>
      <th scope="col" style="width:5%; text-align:center;">Fait</th>
      <th scope="col" style="width:7%; text-align:center;">Modifier</th>
      <th scope="col" style="width:7%; text-align:center;">Commentaire</th>
      <?php if ($_SESSION["type"] == 'ADMIN'){ ?> <th scope="col" style="width:7%">Supprimer</th> <?php } ?>
    </tr>
  </thead>
  <tbody>
     <?php for($i=0;$i<$row;$i++){ ?>
          <tr>
          <th scope="row"><?php echo $todolist[$i]["Id"] ?></th>
          <td><?php echo $todolist[$i]["Name"] ?></td>
          <td><?php echo $todolist[$i]["Detail"] ?></td>
          <?php if($todolist[$i]["State"] == "ToDo"){
                    ?><td style="text-align:center ;">X</td><td></td><td></td>
                <?php } else { if($todolist[$i]["State"] == "Doing"){
                                   ?><td></td><td style="text-align:center ;">X</td><td></td><?php
                              }
                              else {
                                   ?><td></td><td></td><td style="text-align:center ;">X</td><?php
                              }
                         }  ?>
          <td>
               <form method="post">
                    <input type="hidden" id="id" name="id" value="<?php echo $todolist[$i]["Id"] ?>">
                    <input type="hidden" id="nom" name="nom" value="<?php echo $todolist[$i]["Name"] ?>">
                    <input type="submit" value="Modifier" name="modify">
                    </td><td>
                    <input type="submit" value="Voir" name="comment">
                    </td>
                    <?php if ($_SESSION["type"] == 'ADMIN'){ ?>
                         <td>
                         <input type="submit" value="Supprimer" name="delete">
                    <?php } ?>
               </form>
          </td>
          </tr>
     <?php } ?>
  </tbody>
</table>
<div class="text-center">
     <a class="btn btn-primary" href="./addTask.php" role="button">Ajouter une tâche</a>
</div>
</body>
</html>

<?php
}else echo "<h1>Please login first .</h1>";
?>