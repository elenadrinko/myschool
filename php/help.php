<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="Width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Школа вожатых</title>
    <link rel="stylesheet" href="./css/help.css">
  </head>
  <body class="main">
  <?php require "./blocks/header.php" ?>

  <div class="form">

    <div class="formHelp">
      <p class="formHelp_title">Ваши вопросы</h1>
      <form action="./check.php" method="post">
        <input class="formHelp_name" type="text" class="form-control" name="name" id="name" placeholder="Введите имя" value="<?=$_COOKIE['user']?>"><br>
        <textarea class="formHelp_comment" name="comment" class="form-control" id="comment" cols="80" rows="15" placeholder="Введите вопрос"></textarea><br>
          <div class="formHelp_button">
          <input class="form-button" type="reset" value="Очистить">
          <button class="form-button" type="submit" name="send">Отправить</button>
          </div>
      </form>
    </div>
    <img class="formImg" src="./img/help.jpg" alt="Коллаж" title="Коллаж">
  </div>
  <?php require "./blocks/footer.php" ?>
  </body>
</html>