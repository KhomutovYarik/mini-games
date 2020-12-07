<?php

  require_once("../includes/connection.php");

  $login = mysqli_real_escape_string($connection, $_POST['login']);

  $query = "select * from users where login='$login'";

  $count = mysqli_num_rows(mysqli_query($connection, $query));

  if ($count > 0)
      $ans = '0';
  else
      $ans = '1';

  echo $ans;

  mysqli_close($connection);

?>
