<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="Width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Школа вожатых</title>
    <link rel="stylesheet" href="./css/lesson_cm.css">
    <?php 
  function get_lesson_name($id) {
    $mysqli = mysqli_connect ('localhost', 'elen', 'elen', 'school');
    if ($id)
    $query = "SELECT `id`, `name`, `id_comp`  FROM `lesson` WHERE `id_comp` = ".$id;
    $result = mysqli_query($mysqli, $query);
    if (!$id)
      if (!$result) return false;
      $data = array();
      while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
      }
      return $data;
    $mysqli->close();
  }
  $lesson = get_lesson_name ($_GET["id"]);
  //print_r($lesson);
  ?>
  </head>
  <body class="main">
  <?php require "./blocks/header.php" ?>
  <div class="lesson">
  
    <?php 
      for ($i = 0; $i < count($lesson); $i++) {
        echo "<div class=\"lesson_item\">";
        echo '<a href="./lesson_cmp.php?id='.$lesson[$i]["id"].'"><ul><li class="lesson_name">'.$lesson[$i]["name"].'</li><ul></a>
        </div>';
      }
    ?>

    <img class="lesson__img" src="./img/lesson.jpg" alt="Фон" title="Фон">
  </div>
<?php require "./blocks/footer.php" ?>
  </body>
</html>