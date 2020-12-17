<?php

  require_once("../includes/connection.php");

  session_start();

  if (empty($_SESSION['auth']) or !($_SESSION['auth'])) {

    if ( !empty($_COOKIE['login']) and !empty($_COOKIE['key']) ) {

      $login = $_COOKIE['login'];
      $key = $_COOKIE['key'];

      $query = "select * from users where login='$login' and cookie='$key'";

      $result = mysqli_fetch_assoc(mysqli_query($connection, $query));

      if (!empty($result)) {

        $_SESSION['auth'] = true;

        $_SESSION['id'] = $user['id'];
        $_SESSION['login'] = $user['login'];
      }
    }
  }

?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Змейка</title>
  <link rel="stylesheet" href="../js/jquery-ui-1.12.1/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
   <nav class="navbar navbar-expand-lg  ">  <!--fixed-top-->
      <a class="navbar-brand" href="../index.php">MGames</a>
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
     </button>
     <div class="collapse navbar-collapse " id="navbarSupportedContent">     <ul class="navbar-nav mr-4">
     <?php if ($_SESSION['auth']) {?>
        <li class="nav-item">
          <span class="nav-link" >Добро пожаловать, <?php echo $_SESSION['login']; ?></span></li>
          <li class="nav-item">
          <a href="../php/logout.php" id="logout" class="nav-link" >Выйти</a></li>
         <?php } else { ?>
         <li class="nav-item">
          <span class="nav-link" onclick="document.getElementById('modal-auth').style.display='block'" data-value="login">Войти</span></li>  <!-- модальное окно входа -->
      <li class="nav-item">
         <a class="nav-link" data-value="register" href="/registration.php">Зарегистрироваться</a>
      </li>
         <?php } ?>
<!--
     <li class="nav-item">
      <a class="nav-link " data-value="contact" href="/about.html">Контаты</a></li>
      <li class="nav-item">
         <a class="nav-link " data-value="test" href="/test.html">ТЕСТ</a></li>
-->
     </ul>
     </div>
   </nav>
</header>
<div class="container">
    <class class="row justify-content-md-center">
        <div class="col-md-8">
        <div id="main-game">
   <img id="reload-game" src="../img/reload.png" title="Перезапустить игру">
    <canvas id="game-canvas" width="608" height="608"></canvas>
  </div>
    </div>
  </div>
         </div>
       <div class="col-md-4 ">
            <table class="table table-sm table-bordered">
                <thead class="thead-inverse">
                <tr>
                    <th>Имя</th>
                    <th>Рекорд</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Ник</td>
                    <td>Рекорд</td>
                </tr>
                <tr>
                    <td>Ник</td>
                    <td>Рекорд</td>
                </tr>
                <tr>
                    <td>Ник</td>
                    <td>Рекорд</td>
                </tr>
                <tr>
                    <td>Ник</td>
                    <td>Рекорд</td>
                </tr>
                <tr>
                    <td>Ник</td>
                    <td>Рекорд</td>
                </tr>
                </tbody>
            </table>
       </div>
    </class>
</div>


   
  <div id="game-over" class="modalAuth">
      <div id="game-over-form">
        <div class="game-over-label">Игра окончена</div>
        <div class="form-label">Ваш счёт: <span id="score"></span></div>
        <div class="form-label">Ваш рекорд: <span id="record"><?php

          if (!empty($_SESSION['auth']) && $_SESSION['auth']){
            $user_id = $_SESSION['id'];

            $query = "select value from records where user_id = $user_id and game_id = 3";

            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) > 0)
              echo mysqli_fetch_row($result)[0];
          }
          else if (!empty($_SESSION['snake']))
              echo $_SESSION['snake'];
          else
            echo '0';

          mysqli_close($connection);
          ?></span></div>
        <button class="restart" id="restart">Начать заново</button>
      </div>
    </div>
  <div id="modal-auth" class="modalAuth">

      <form class="modal-auth animate" action="auth.php" method="POST">
        <div class="imgcontainer">
          <span onclick="document.getElementById('modal-auth').style.display='none'" class="close" title="Close Modal">×</span>
          <img src="../img/brand-mini.png" alt="MGames" class="avatar">
        </div>

        <div class="containerAuth">
          <label for="login"><b>Логин</b></label>
          <input id="login" type="text" placeholder="Введите логин" name="login" required>

          <label for="password"><b>Пароль</b></label>
          <input id="password" type="password" placeholder="Введите пароль" name="password" required>

          <input name="AuthButton" id="signin-button" type="button" value="Войти" class="btn btn-lg btn-success btn-block">

        </div>

        <div class="containerAuth" style="background-color:#f1f1f1">
          <button type="button" onclick="document.getElementById('modal-auth').style.display='none'" class="btn btn-lg btn-danger">Отмена</button>
          <a href="registration.php"><button id="modal-register" type="button" class="psw btn btn-lg btn-info ">Регистрация</button></a>
        </div>
      </form>
    </div>
    <div id="dialog">
      <pre class="dialog-text"></pre>
    </div>
    <script type="text/javascript" src="../js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui-1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="../js/auth.js"></script>
  <script src="scripts.js"></script>
</body>
</html>
