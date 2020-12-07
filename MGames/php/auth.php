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

  $login = mysqli_real_escape_string($connection, $_POST['login']);
  $password = $_POST['password'];

  $query = "select id, salt, hash from users where login='$login'";

  $result = mysqli_query($connection, $query);

  $count = mysqli_num_rows($result);

  $ans = '';

  if ($count > 0)
  {
    $data = mysqli_fetch_row($result);
    if ($data[2] == md5($password.$data[1]))
    {
      session_start();

      $_SESSION['auth'] = true;
      $_SESSION['id'] = $data[0];
      $_SESSION['login'] = $login;

      $cookie = getRandString(20);

      $query = "update set cookie='$cookie' where id=$data[0]";

      mysqli_query($connection, $query);

      setcookie('login', $login, time() + 60*60*24*365, '/');
      setcookie('key', $cookie, time() + 60*60*24*365, '/');

      $ans = '1';
    }
    else
      $ans = '2';
  }
  else
      $ans = '0';

  echo $ans;

  mysqli_close($connection);

?>
