<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="Width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Школа вожатых</title>
    <link rel="stylesheet" href="./css/lesson_cmp.css">
    <?php 
      function getLes($id) {
        $mysqli = mysqli_connect ('localhost', 'elen', 'elen', 'school');
        if ($id)
          $where = "WHERE `id` = ".$id;
        $result = $mysqli->query("SELECT * FROM `lesson` $where ORDER BY `id`");
        $mysqli->close();
        if (!$id)
          return resultToArray ($result);
        else
          return $result->fetch_assoc();
      }
      function resultToArray ($result) {
        $array = array ();
        while (($row = $result->fetch_assoc()) != false)
          $array[] = $row;
        return $array;
      }
      $les = getLes ($_GET["id"]);
      $title = $les["name"];
    ?>
  </head>
  <body class="main">
  <?php require "./blocks/header.php" ?>
  <p><a name="top"></a></p>
  <?php 
    echo '<div class="competenceLesson">
    <p class="competenceLesson_name">'.$les["name"].'</p>
    <p class="competenceLesson_description">'.$les["description"].'</p>
    </div>';
  ?>
  <p class="competenceLesson_img"><a href="#top"><img src="./img/top.png" alt="Наверх" title="Наверх"></a></p>

  <?php require "./blocks/footer.php" ?>
  </body>
</html>