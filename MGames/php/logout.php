<?php

  session_start();

  if (!empty($_SESSION['auth']) and $_SESSION['auth']) {
    session_destroy();

    setcookie('login', '', time(), '/');
    setcookie('key', '', time(), '/');

    header("Location: ".$_SERVER['HTTP_REFERER']);
  }

?>
