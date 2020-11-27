<?php
require_once("includes/connection.php");  
if(isset($_POST['AuthButton']))
    {
        $log = $_POST[login];
        $query = mysqli_query($connection,"SELECT id, login, salt, hash FROM users WHERE login='$log'");
        $data = mysqli_fetch_assoc($query);
        $hash = sha1(($_POST['password']) . $data['salt'] );
        if($data['hash'] === $hash)
        {
           setcookie("id", $data['id'], time()+60*60*24*30);
            setcookie("login", $data['login'], time()+60*60*24*30);
            header("Location: index.html"); 
            exit();
        }
        else
        {
            echo "<script type='text/javascript'>alert( 'Неверные логин или пароль!' );</script>";
        }
    }
    ?>