<?php
  $name = filter_var(trim($_POST['name']),
  FILTER_SANITIZE_STRING);
  $comment = filter_var(trim($_POST['comment']),
  FILTER_SANITIZE_STRING);

  if(mb_strlen($name) < 1 || mb_strlen($name) > 50) {
    echo "Недопустимая длина имени";
    exit();
  } else if(empty($comment)) {
    echo "Введите вопрос";
    exit();
  }

//хеширование пароля
//$pass = md5($pass."sch73");

//подключение к бд и запись данных
  $mysql = new mysqli('localhost', 'elen', 'elen', 'school');
  $result = $mysql->query("INSERT INTO `comment` (`name` , `comment`) 
  VALUES('$name', '$comment')");
  if ($result == 'true'){
    echo "Информация занесена в базу данных";
  }else{
    echo "Информация не занесена в базу данных";
  }
//закрытие подключения к бд
$mysql->close();
//возврат на страницу
  header('location: ./help.php');
?>