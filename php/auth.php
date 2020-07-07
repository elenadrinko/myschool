<?php
//обработка ошибок
  ini_set('display_errors', 0);
  ini_set('display_startup_errors', 0);
  error_reporting(0);

  $login = filter_var(trim($_POST['login']),
  FILTER_SANITIZE_STRING);
  $pass = filter_var(trim($_POST['pass']),
  FILTER_SANITIZE_STRING);

  $mysql = new mysqli('localhost', 'elen', 'elen', 'school');
  $result = $mysql->query("SELECT * FROM `users` WHERE `login` = '$login' AND `pass` = '$pass'");
  $user = $result->fetch_assoc();
  if(count($user) == 0) {
    echo "Такой пользователь не найден";
    exit();
  }
  setcookie('user', $user['name'], time() + 3600 * 24 * 30 * 12, "/");
  $mysql->close();
  header('location: ./main.php');

?>