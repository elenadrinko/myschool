<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="Width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Школа вожатых</title>
    <link rel="stylesheet" href="./css/lk.css">
    <?php 
  function get_result_test() {
    $mysqli = mysqli_connect ('localhost', 'elen', 'elen', 'school');
    $user = $_COOKIE['user'];
    $result = $mysqli->query("SELECT * FROM `result` WHERE `name` = '$user'");
    $mysqli->close();
    return result_to_array ($result);
  }
  function result_to_array ($result) {
    $array = array ();
    while (($row = $result->fetch_assoc()) != false)
      $array[] = $row;
    return $array;
  }
  $resultsTest = get_result_test ();

  ?>
  </head>
  <body class="main">
  <?php require "./blocks/header.php" ?>


  <div class="lk_name"> <p class="lk_nameItem">Имя: </p><p><?=$_COOKIE['user']?></p></div>
  
  <?php
        $db = new mysqli('localhost', 'elen', 'elen', 'school');
        $user = $_COOKIE['user'];
        $sql = "SELECT `class` FROM `users` WHERE `name` = '$user'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo "<div class='lk_class'><p class='lk_classItem'>Группа: </p><p>" . $row["class"]. "</p></div>";
        }
      }
  ?>
<div class="result">
<p class="resultsTest_title">Таблица результатов итогового тестирования: </p>
    <?php 
    for ($i = 0; $i < count($resultsTest); $i++) {
      echo "<div class=\"resultsTest\">";
        echo '<table class="resultsTest_table">
              <tr>
              <th>ФИО</th>
              <th>Количество правильных ответов</th>
              <th>Процент правильных ответов</th>
              <th>Дата прохождения теста</th>
              </tr>
              <tr>
              <td>'.$resultsTest[$i]["name"].'</td>
              <td>'.$resultsTest[$i]["correct_count"].'</td>
              <td>'.$resultsTest[$i]["percent_result"].'</td>
              <td>'.$resultsTest[$i]["data"].'</td>
              </tr>
              </table>
      </div>';
    }
    ?>
</div>
  <?php
        $db = new mysqli('localhost', 'elen', 'elen', 'school');
        $user = $_COOKIE['user'];
        $sql = "SELECT `ser_lk` FROM `users` WHERE `name` = '$user' && `sertif_result` = '1'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo "<div class='lk_sertific'><p class='lk_sertificItem'>Сертификат: </p><p class='lk_sertificImg'>" . $row["ser_lk"]. "</p></div>";
        }
        } else {
          echo "<div class='lk_sertific'><p class='lk_sertificItem'>Сертификат: </p><p class='lk_sertificText'>Пройдите тестирование для получения сертификата или обратитесь в администрацию</p></div>";
        }
  ?>
  
  <p class="lk_imgDec"><img class="lk_img" src="./img/lesson.jpg" alt="Фон" title="Фон">
  
  <?php require "./blocks/footer.php" ?>
  </body>
</html>