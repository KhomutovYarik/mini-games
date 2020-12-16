<?php

  session_start();

  $game_id = $_POST['game'];
  $score = $_POST['record'];

  if (!empty($_SESSION['auth']) && $_SESSION['auth']){
    require_once("../includes/connection.php");

    $user_id = $_SESSION['id'];

    $query = "select value from records where user_id = $user_id and game_id = $game_id";

    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) == 0)
    {
      $query = "insert into records (user_id, game_id, value) values ($user_id, $game_id, $score)";
      mysqli_query($connection, $query);
    }
    else
    {
      $data = mysqli_fetch_row($result);
      if ($data[0] < $score){
        $query = "update records set value = $score where user_id = $user_id and game_id = $game_id";
        mysqli_query($connection, $query);
      }
    }


    mysqli_close($connection);
  }
  require_once("../includes/gameslist.php");
  if (empty($_SESSION[$games_list[$game_id-1]]) || !empty($_SESSION[$games_list[$game_id-1]] ) && $_SESSION[$games_list[$game_id-1]] < $score)
  $_SESSION[$games_list[$game_id-1]] = $score;

?>
