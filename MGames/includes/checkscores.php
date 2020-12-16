<?php
    require_once("gameslist.php");

    $user_id = $_SESSION['id'];

    for ($i = 0; $i < count($games_list); $i++){
      if (!empty($_SESSION[$games_list[$i]])){
        $game_id = $i+1;
        $value = $_SESSION[$games_list[$i]];
        $query = "select value from records where user_id = $user_id and game_id = $game_id";

        $res = mysqli_query($connection, $query);

        if (mysqli_num_rows($res) > 0){
          $data = mysqli_fetch_row($res);
          if ($data[0] < $value){
            $query = "update records set value = $score where user_id = $user_id and game_id = $game_id";
            mysqli_query($connection, $query);
          }
        }
        else
        {
          $query = "insert into records (user_id, game_id, value) values ($user_id, $game_id, $value)";
          mysqli_query($connection, $query);
        }
      }
    }

?>
