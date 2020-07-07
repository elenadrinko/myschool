<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="Width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Школа вожатых</title>
    <link rel="stylesheet" href="./css/lesson.css">
    <?php 
  function get_name_comp() {
    $mysqli = mysqli_connect ('localhost', 'elen', 'elen', 'school');
    $result = $mysqli->query("SELECT * FROM `competences`");
    $mysqli->close();
    return result_to_array ($result);
  }
  function result_to_array ($result) {
    $array = array ();
    while (($row = $result->fetch_assoc()) != false)
      $array[] = $row;
    return $array;
  }
  $comp = get_name_comp ();

  ?>
  </head>
  <body class="main">
  <?php require "./blocks/header.php" ?>
  <div class="main__competences">
    <?php 
    for ($i = 0; $i < count($comp); $i++) {
      echo "<div class=\"competences\">";
        echo '<img class="competences__img" src="./img/lessons/'.$comp[$i]["id"].'.jpg"
        alt="Компетенция '.$comp[$i]["name"].'" title="Компетенция '.$comp[$i]["name"].'">
        <a href="./lesson_cm.php?id='.$comp[$i]["id"].'"><p class="competences__name">'.$comp[$i]["name"].'</p></a>
        <p class="competences__description">'.$comp[$i]["description"].'</p><br>
      </div>';
    }
    ?>
      
      <div class="competences">
        <img class="competences__img" src="./img/lessons/test.jpg" alt="Тесты" title="Тесты">
        <a href="./test.php"><p class="competences__name">Тесты</p></a>
        <p class="competences__description">Тесторование. Самопроверка ваших знаний. </p><br>
      </div>
  </div>
  
  <?php require "./blocks/footer.php" ?>
  </body>
</html>