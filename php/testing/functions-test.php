<?php
//распечатка массива
function print_arr($arr) {
  echo '<pre>' .print_r($arr, true). '</pre>';
}

//получение списка тестов
function get_tests(){
  global $db;
  $query = "SELECT * FROM `test` WHERE enable = '1'";
  $res = mysqli_query($db, $query);
  if (!$res) return false;
  $data = array();
  while($row = mysqli_fetch_assoc($res)) {
    $data[] = $row;
  }
  return $data;
}

//получение данных теста
function get_test_data($test_id) {
  if ($test_id == 7) {
    global $db;
    $user = $_COOKIE['user'];
    $countAtt = "SELECT * FROM `result` WHERE `name`='$user'";
    $result = mysqli_query($db, $countAtt);
    $count  =  mysqli_num_rows($result);
    
      if ($count < 3) {
        if (!$test_id) return; //возвращает NULL
        global $db;
        $query = "SELECT q.question, q.id_test, a.id, a.answer, a.id_question 
        FROM questions q LEFT JOIN answers a ON q.id = a.id_question 
        LEFT JOIN test ON test.id = q.id_test 
        WHERE q.id_test = $test_id AND test.enable = '1'";
        $res = mysqli_query($db, $query);
        $data = null;
        while ($row = mysqli_fetch_assoc($res)) {
          if (!$row['id_question']) return false; //возвращает false
          $data[$row['id_question']][0] = $row['question'];
          $data[$row['id_question']][$row['id']] = $row['answer'];
        }
        return $data; //возвращает массив
      }
  }


  else {
    if (!$test_id) return; //возвращает NULL
    global $db;
    $query = "SELECT q.question, q.id_test, a.id, a.answer, a.id_question 
    FROM questions q LEFT JOIN answers a ON q.id = a.id_question 
    LEFT JOIN test ON test.id = q.id_test 
    WHERE q.id_test = $test_id AND test.enable = '1'";
    $res = mysqli_query($db, $query);
    $data = null;
    while ($row = mysqli_fetch_assoc($res)) {
      if (!$row['id_question']) return false; //возвращает false
      $data[$row['id_question']][0] = $row['question'];
      $data[$row['id_question']][$row['id']] = $row['answer'];
    }
    return $data; //возвращает массив
}
}

//получение id вопрос/ответ
function get_correct_answer($test){
  if(!$test) return false;
  global $db;
  $query = "SELECT q.id AS question_id, a.id AS answer_id
  FROM questions q LEFT JOIN answers a ON q.id = a.id_question
  LEFT JOIN test ON test.id = q.id_test
  WHERE q.id_test = $test AND a.correct_answer = '1' AND test.enable = '1'";
  $res = mysqli_query($db, $query);
  $data = null;
  while ($row = mysqli_fetch_assoc($res)) {
    $data[$row['question_id']] = $row['answer_id'];
  }
  return $data;
}

//пагинация
function pagination($count_questions, $test_data) {
  $keys = array_keys($test_data);
  $pagination = '<div class="pagination">';
  for($i = 1; $i <= $count_questions; $i++) {
    $key = array_shift($keys);
    if ($i == 1) {
      $pagination .= '<a class="nav-active" href="#question-'.$key.'">'.$i.'</a>';
    } else {
      $pagination .= '<a href="#question-'.$key.'">'.$i.'</a>';
    }
  }
  $pagination .= '</div>';
  return $pagination;
}

//итоги
function get_test_data_result($test_all_data, $result, $post) {
  // заполняем массив $test_all_data правильными ответами и данными о неотвеченных вопросах
  foreach($result as $q => $a){
    $test_all_data[$q]['correct_answer'] = $a;
    // добавим в массив данные о неотвеченных вопросах
    if( !isset($post[$q]) ){
      $test_all_data[$q]['incorrect_answer'] = 0;
    }
  }

  // добавим неверный ответ, если таковой был
  foreach($post as $q => $a){
    // удалим из POST "левые" значения вопросов
    if( !isset($test_all_data[$q]) ){
      unset($post[$q]);
      continue;
    }

    // если есть "левые" значения ответов
    if( !isset($test_all_data[$q][$a]) ){
      $test_all_data[$q]['incorrect_answer'] = 0;
      continue;
    }

    // добавим неверный ответ
    if( $test_all_data[$q]['correct_answer'] != $a ){
      $test_all_data[$q]['incorrect_answer'] = $a;
    }
  }
  return $test_all_data;
}

//печать результатов
function print_result($test_all_data_result, $test) {
    
    global $db;
    $user = $_COOKIE['user'];
    $countAtt = "SELECT * FROM `result` WHERE `name`='$user'";
    $resultAt = mysqli_query($db, $countAtt);
    $countAt  =  mysqli_num_rows($resultAt);

//итоговый тест
  if ($test == 7) {
    if ($countAt < 3) {
      //переменные результатов
      $all_count = count($test_all_data_result); //количество вопросов
      $correct_answer_count = 0; //количество верных ответов
      $incorrect_answer_count = 0; //количество неверных ответов
      $percent = 0; //процент верных ответов

      // подсчет результатов
      foreach($test_all_data_result as $item){
        if( isset($item['incorrect_answer']) ) $incorrect_answer_count++;
      }
      $correct_answer_count = $all_count - $incorrect_answer_count;
      $percent = round( ($correct_answer_count / $all_count * 100), 2);

      // вывод результатов
      global $db;
      $user = $_COOKIE['user'];
      $query = "INSERT INTO `result` (`name` , `correct_count`, `percent_result`) VALUES ('$user', '$correct_answer_count', '$percent')";
      $result = mysqli_query($db, $query);

      if( $percent < 80 )return 'Вы набрали менее 80%, попробуйте пройти тест заново';
        global $db;
        $sql = "SELECT `sertif` FROM `users` WHERE `name` = '$user'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo "<p class='sertificTitle'>" . $row["sertif"]. "</p>";
        }
        } else {
          echo "<p class='sertificTitle'>Обратитесь в администрацию</p>";
        }

          $query = "UPDATE `users` SET `sertif_result`= '1' WHERE `name` = '$user'";
          $result = mysqli_query($db, $query);
    }
  }

//другие тесты
    else {
          //переменные результатов
    $all_count = count($test_all_data_result); //количество вопросов
    $correct_answer_count = 0; //количество верных ответов
    $incorrect_answer_count = 0; //количество неверных ответов
    $percent = 0; //процент верных ответов

    // подсчет результатов
    foreach($test_all_data_result as $item){
      if( isset($item['incorrect_answer']) ) $incorrect_answer_count++;
    }
    $correct_answer_count = $all_count - $incorrect_answer_count;
    $percent = round( ($correct_answer_count / $all_count * 100), 2);

    if( $percent < 50 )return 'Вы набрали менее 50%, попробуйте пройти тест заново';
    // вывод результатов
      $print_res = '<div class="test-data">';
      $print_res .= '<div class="count-res">';
        $print_res .= "<p>Всего вопросов: <b>{$all_count}</b></p>";
        $print_res .= "<p>Из них отвечено верно: <b>{$correct_answer_count}</b></p>";
        $print_res .= "<p>Из них отвечено неверно: <b>{$incorrect_answer_count}</b></p>";
        $print_res .= "<p>Процент верных ответов: <b>{$percent}</b> %</p>";
      $print_res .= '</div>';	// .count-res

      // вывод теста...
      foreach($test_all_data_result as $id_question => $item){ // получаем вопрос + ответы
        $correct_answer = $item['correct_answer'];
        $incorrect_answer = null;
        if( isset($item['incorrect_answer']) ){
          $incorrect_answer = $item['incorrect_answer'];
          $class = 'question-res error';
        }else{
          $class = 'question-res ok';
        }
        $print_res .= "<div class='$class'>";
        foreach($item as $id_answer => $answer){ // проходимся по массиву ответов
          if( $id_answer === 0 ){
            // вопрос
            $print_res .= "<p class='q'>$answer</p>";
          }elseif( is_numeric($id_answer) ){
            // ответ
            if( $id_answer == $correct_answer ){
              // если это верный ответ
              $class = 'a ok2';
            }elseif( $id_answer == $incorrect_answer ){
              // если это неверный ответ
              $class = 'a error2';
            }else{
              $class = 'a';
            }
            $print_res .= "<p class='$class'>$answer</p>";
          }
        }
        $print_res .= '</div>'; // .question-res
      }

    $print_res .= '</div>'; // .test-data

  return $print_res;
    }
}
