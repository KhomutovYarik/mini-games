<?php
  require_once("includes/connection.php");  

	if(isset($_POST['regButton']))
    {
        $err = 0;

    if(!preg_match("/^[a-zA-Z0-9]+$/",@$_POST['inputLogin']))
    {
        echo "<script type='text/javascript'>alert( 'Логин может состоять только из букв английского алфавита и цифр' );</script>";
        $err++;
    }

    if(!preg_match("/(?=.*\d)(?=.*[A-Z]).{8,}/", $_POST['inputPassword']))
    {
        echo "<script type='text/javascript'>alert( 'Пароль должен быть не менее 8 символов, содержащих хотя бы одну букву в верхнем регистре и одну цифру' );</script>";
        $err++;
    }
    if($_POST['inputPassword'] != $_POST['inputSecondPassword'])
    {
        echo "<script type='text/javascript'>alert( 'Пароли не совпадают' );</script>";
        $err++;
    }

    $query = mysqli_query($connection, "SELECT id FROM users WHERE login='".mysqli_real_escape_string($connection, $_POST['inputLogin'])."'");
    if(mysqli_num_rows($query) > 0)
    {
        echo "<script type='text/javascript'>alert( 'Пользователь с таким логином уже существует в базе данных' );</script>";
        $err++;
    }

    if($err == 0)
    {
        $login = $_POST['inputLogin'];
        $log = mysqli_real_escape_string($connection, $_POST['inputLogin']);
        $password = $_POST['inputPassword'];
        $guid = getGUID();
        $hashPassword = sha1($password . $guid);
        mysqli_query($connection,"INSERT INTO users SET login='" . $login . "', salt='".$guid."', hash='".$hashPassword."'");
        $data = mysqli_fetch_assoc($query);
        header("Location: index.html");
         exit();
    }
}
	?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="fonts/10115.otf">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>
<body>
    <!-- navbar -->  
    
<header>
   <nav class="navbar navbar-expand-lg  ">  <!--fixed-top-->
      <a class="navbar-brand" href="/index.html">MGames</a>
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">  
      <span class="navbar-toggler-icon"></span>
     </button>
     <div class="collapse navbar-collapse " id="navbarSupportedContent">     <ul class="navbar-nav mr-4">
      <li class="nav-item">
          <a class="nav-link" data-value="login" href="/">Войти</a>        </li>  
      <li class="nav-item">
          <a class="nav-link" data-value="login" href="/registration.php">Зарегестрироваться</a>        </li>     
      <li class="nav-item"> 
          <a class="nav-link " data-value="contact" href="/about.html">Контаты</a>       </li> 
     </ul> 
     </div>
   </nav>
</header>
   <!-- информация -->  
   <body class="text-center">
    <form method="post" class="form-signin">
  <img class="mb-4" width="300" src="img/brand.png" alt="" >
  <h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>
    <label for="inLogin" class="sr-only">Логин</label>
    <input type="text" name="inputLogin" id="inLogin" class="form-control" placeholder="Логин" required autofocus>
  <label for="inputPass" class="sr-only">Пароль</label>
  <input type="password" name="inputPassword" id="inputPass" class="form-control" placeholder="Пароль" required>
  <label for="inputSecondPass" class="sr-only">Повторите пароль</label>
  <input type="password" id="inputSecondPass" name="inputSecondPassword" class="form-control" placeholder="Повторите Пароль" required>
 
  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" value="remember-me"> Запомнить меня
    </label>
  </div>
  <input type="submit" name="regButton" class="next action-button" id="reg" value="Зарегистрироваться" />
  <button id="regButto" class="btn btn-lg btn-primary btn-block" type="submit">Зарегестрироваться</button>
</form>
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
 -->