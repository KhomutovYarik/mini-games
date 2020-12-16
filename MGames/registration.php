<?php

  require_once("includes/connection.php");

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

        header('Location: index.php');
      }
    }
  }
  else
    header('Location: index.php');

mysqli_close($connection);

?>


<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма регистрации</title>
    <link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <!-- navbar -->

<header>
   <nav class="navbar navbar-expand-lg">  <!--fixed-top-->
      <a class="navbar-brand" href="/index.php">MGames</a>
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
     </button>
     <div class="collapse navbar-collapse " id="navbarSupportedContent">     <ul class="navbar-nav mr-4">
      <li class="nav-item">
          <span class="nav-link" onclick="document.getElementById('modal-auth').style.display='block'" data-value="login">Войти</span></li>
      <li class="nav-item">
          <a class="nav-link" data-value="login" href="/registration.php">Зарегистрироваться</a>        </li>
<!--
      <li class="nav-item">
          <a class="nav-link " data-value="contact" href="/about.html">Контаты</a>       </li>
-->
     </ul>
     </div>
   </nav>
</header>
   <!-- информация -->
   <div class="text-center">
    <form method="post" class="form-signin">
     <img width="180" src="img/brand.png" alt="" >
      <h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>
      <label for="inLogin" class="sr-only">Логин</label>
      <input type="text" name="inputLogin" id="inLogin" class="form-control" placeholder="Логин" required autofocus>
      <label for="inputPass" class="sr-only">Пароль</label>
      <input type="password" name="inputPassword" id="inputPass" class="form-control" placeholder="Пароль" required>
      <label for="inputSecondPass" class="sr-only">Повторите пароль</label>
      <input type="password" name="repeatPass" id="inputSecondPass" class="form-control" placeholder="Повторите пароль" required>
      <input type="button" value="Зарегистрироваться" id="regButt" name="regButton" class="btn btn-lg btn-primary btn-block">
    </form>
  </div>
  <div id="modal-auth" class="modalAuth">

      <form class="modal-auth animate" action="auth.php" method="POST">
        <div class="imgcontainer">
          <span onclick="document.getElementById('modal-auth').style.display='none'" class="close" title="Close Modal">×</span>
          <img src="img/brand-mini.png" alt="MGames" class="avatar">
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
        </div>
      </form>
    </div>
  <div id="dialog">
      <pre class="dialog-text"></pre>
  </div>
  <script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-1.12.1/jquery-ui.js"></script>
  <script type="text/javascript" src="js/register-page.js"></script>
  <script type="text/javascript" src="js/auth.js"></script>
</body>
</html>


 <!--

<nav class="navbar navbar-expand-lg fixed-top ">
   <a class="navbar-brand" href="#">MGames</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
   <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse " id="navbarSupportedContent">     <ul class="navbar-nav mr-4">
   <li class="nav-item">
       <a class="nav-link" data-value="login" href="#">Войти</a>        </li>
  <li class="nav-item">
   <a class="nav-link " data-value="contact" href="#">Контаты</a>       </li>
  </ul>
  </div>
</nav>

  <input type="submit" name="regButton" class="next action-button" id="reg" value="Зарегистрироваться" />

 -->
