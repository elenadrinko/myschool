<?php

define("HOST", "localhost");
define("USER", "elen");
define("PASS", "elen");
define("DB", "school");

$db = @mysqli_connect(HOST, USER, PASS, DB) or die('Нет соединения с БД');
mysqli_set_charset($db, 'utf8') or die('Не установлена кодировка соединения');