<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="Width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Школа вожатых</title>
    <link rel="stylesheet" href="./css/article.css">
    <?php 
      function getNews($limit, $id) {
        $mysqli = mysqli_connect ('localhost', 'elen', 'elen', 'school');
        if ($id)
          $where = "WHERE `id` = ".$id;
        $result = $mysqli->query("SELECT * FROM `news` $where ORDER BY `id` DESC LIMIT $limit");
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
      $news = getNews (1, $_GET["id"]);
      $title = $news["title"];
    ?>
  </head>
  <body class="main">
  <?php require "./blocks/header.php" ?>

  <?php 
    echo '<div id="oneArticle">
    
    <p class="oneArticle_title">'.$news["title"].'</p>
    <p class="img"><img class="oneArticle_img" src="./img/article/'.$news["id"].'.jpg"
    alt="Статья '.$news["id"].'" title="Статья '.$news["id"].'"></p>
    <p>'.$news["full_text"].'</p>
    </div>';
  ?>

  <?php require "./blocks/footer.php" ?>
  </body>
</html>