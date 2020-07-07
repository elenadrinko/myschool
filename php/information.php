<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="Width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Школа вожатых</title>
    <link rel="stylesheet" href="./css/information.css">
    <?php 
  function getNews($limit) {
    $mysqli = mysqli_connect ('localhost', 'elen', 'elen', 'school');
    $result = $mysqli->query("SELECT * FROM `news` ORDER BY `id` DESC LIMIT $limit");
    $mysqli->close();
    return resultToArray ($result);
  }
  function resultToArray ($result) {
    $array = array ();
    while (($row = $result->fetch_assoc()) != false)
      $array[] = $row;
    return $array;
  }
  $news = getNews (3);
  ?>
  </head>
  <body class="main">
  <?php require "./blocks/header.php" ?>
  <p class="infoTitle">Новости</p>
  
  <div class="articleAll">
  <?php 
  for ($i = 0; $i < count($news); $i++) {
    echo "<div class=\"article\">";
      echo '<div><img class="articleImg" src="./img/article/'.$news[$i]["id"].'.jpg" 
      alt="Статья '.$news[$i]["id"].'" title="Статья '.$news[$i]["id"].'"></div>

      <div class="articleText">
      <p class="articleTitle">'.$news[$i]["title"].'</p>
      <p class="articleIntro">'.$news[$i]["intro_text"].'</p>
      <a href="./article.php?id='.$news[$i]["id"].'">
        <div class="articleMore">Далее</div>
      </a>
      </div>

    </div>';
  }
  ?>
  </div>
  <?php require "./blocks/footer.php" ?>
  </body>
</html>