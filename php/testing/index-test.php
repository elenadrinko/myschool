<?php 

ini_set("display_errors", 1);
error_reporting(-1);
require_once 'config.php';
require_once 'functions-test.php';

if (isset($_GET['test'])) {
  $test_id = (int)$_GET['test'];
  $test_data = get_test_data($test_id);
  if (is_array($test_data)) {
    $count_questions = count($test_data);
    $pagination = pagination($count_questions, $test_data);
  }
}

if (isset($_POST['test'])) { //массив $_POST - ответы пользователя
  $test = (int)$_POST['test'];
  unset($_POST['test']);
  $result = get_correct_answer($test); // массив $result - правильные ответы
  if (!is_array($result)) exit('Ошибка');
  //данные теста
  $test_all_data = get_test_data($test); // массив $test_all_data - вопросы и все ответы
  $test_all_data_result = get_test_data_result($test_all_data, $result, $_POST);
  echo print_result($test_all_data_result, $test);
  if ($test == 7) {
    global $db;
    $user = $_COOKIE['user'];
    $countAtt = "SELECT * FROM `result` WHERE `name`='$user'";
    $result = mysqli_query($db, $countAtt);
    $count  =  mysqli_num_rows($result);
      
    $attempts = 3 - $count;
    printf("<div> Попыток осталось: ".$attempts." </div>");
  }
  die;
}

// список тестов
$tests = get_tests();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Система тестирования</title>
	<link rel="stylesheet" href="./index-test.css">
</head>
<body>
  <div class="wrap">
    <?php if($tests): ?>
      <p class="wrapTitle">Список тестов:</p>
      <?php foreach($tests as $test): ?>
        <p class="wrapName"><a class="wrapName_test" href="?test=<?=$test['id']?>"><?=$test['test_name']?></a></p>
      <?php endforeach; ?>

        <br><hr><br>
        <div class="content">
          <?php if(isset($test_data)): ?>

              <p class="contentTitle">Всего вопросов: <?=$count_questions?></p>
              <?=$pagination?>

              <span class="none" id="test-id"><?=$test_id?></span>

              <div class="test_data">
                <?php foreach($test_data as $id_question => $item): //получаем каждый вопрос и ответы?> 
                  <div class="question" data-id="<?=$id_question?>" id="question-<?=$id_question?>">
                    <?php foreach($item as $id_answer => $answer): //проходимся по массиву вопрос/ответ?>
                      <?php if(!$id_answer): //вывод вопроса ?>
                        <p class="q"><?=$answer?></p>
                      <?php else: //вывод вариантов ответов ?>
                        <p class="a">
                        <input type="radio" id="answer-<?=$id_answer?>" name="question-<?=$id_question?>" value="<?=$id_answer?>">
                        <label for="answer-<?=$id_answer?>"><?=$answer?></label>
                        </p>
                      <?php endif; //$id_answer?>
                    <?php endforeach; //$item?>
                  </div><!-- question -->
                <?php endforeach; //$test_data?>
              </div><!-- test_data -->
              
            <div class="buttons">
              <button class="center btn" id="btn" >Закончить тест</button>
            </div><!-- buttons -->
          
          <?php else: //(isset($test_data))?>
            <p class="contentTitle">Выберите тест</p>
          <?php endif; //(isset($test_data))?>
        </div><!-- content -->

    <?php else: //$tests?>
      <<p class="contentTitle">>Нет тестов</p>
    <?php endif; //$tests?>
  </div><!-- wrap -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="./scripts-test.js"></script>

</body>
</html>