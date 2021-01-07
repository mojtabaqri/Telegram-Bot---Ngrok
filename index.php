<?php
set_time_limit(0);
ob_start();
spl_autoload_register(function ($classname){
    require "class/".$classname.".php";
});
$bot=new Message(file_get_contents('php://input'));
$user=new User($bot->user());
