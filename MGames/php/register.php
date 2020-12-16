<?php

  require_once("../includes/connection.php");

  function getRandString($num)
  {
      //Генерим массив из букв
      $letter = range('a', 'z');
      //Генерим массив из цифр
      $number = range(0, 9);
      //Создаем строку с маленькими и большими буквами и цифрами
      $letter = implode('',$letter);
      $letter = $letter.strtoupper($letter).implode('',$number);
      //Строка с генерированым паролем
      $randStr = '';
      for ($i = 0; $i < $num; $i++){
          //Прогоняем циклом столько, сколько нужно символов в строке
          $randStr .= $letter[rand(0, strlen($letter) - 1)];
      }
      return $randStr;
  }

  if (!empty($_POST['inputLogin']) && !empty($_POST['inputPassword']) && !empty($_POST['repeatPass']) && $_POST['inputPassword'] == $_POST['repeatPass'])
  {
    $login = $_POST['inputLogin'];
    $password = $_POST['inputPassword'];

    $query = "select * from users where login='$login'";

    $count = mysqli_num_rows(mysqli_query($connection, $query));

    if ($count == 0)
    {
      $salt = getRandString(12);
      $hashPassword = md5($password.$salt);
      $cookie = getRandString(20);

      $query = "INSERT INTO users (login, hash, salt, cookie) values ('$login', '$hashPassword', '$salt', '$cookie')";

      $status = mysqli_query($connection, $query);

      if ($status)
      {
        session_start();

        $_SESSION['auth'] = true;
        $_SESSION['id'] = $connection->insert_id;
        $_SESSION['login'] = $login;

        setcookie('login', $login, time() + 60*60*24*365, '/');
        setcookie('key', $cookie, time() + 60*60*24*365, '/');

        require_once("../includes/checkscores.php");
      }

      echo $status;
    }
    else
      echo '0';
  }
  else
    echo '0';

  mysqli_close($connection);

?>
