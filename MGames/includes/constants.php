<?php
	// Константы базы данных
	define("DB_SERVER", "localhost");
	define("DB_USER", "id15324306_root");
	define("DB_PASS", "0mTq}yoh2sJ7E5N%");
    define("DB_NAME", "id15324306_mini_games");
    
    function getGUID(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);
            $uuid = 
                substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);
            return $uuid;
        }
    }
	?>