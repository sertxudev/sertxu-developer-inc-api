<?php

define("_LOGS_FOLDER_", "logs/");

if(file_exists(_LOGS_FOLDER_."logging")){
    define("logging", true);
}else{
    define("logging", false);
}

if(logging){
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

define("_HOST_", "localhost");
define("_BBDD_", "database");
define("_USER_", "username");
define("_PASS_", "password");
define("_TYPE_", "mysql");

spl_autoload_register(function ($class) {
    if(strstr($class, 'Controller')) {
        include './controllers/'.$class.'.php';
    } else {
        include './models/'.$class.'.php';
    }
});