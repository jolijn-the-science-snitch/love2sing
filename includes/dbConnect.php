<?php

session_start();

//DATABASE CONNECT

class DbHelper{
    var $connect;

    //maakt de DB connectie aan
    public function __construct(){
        $this -> connect = new PDO('mysql:host=localhost; dbname=love2sing;','wienerdoggo','123');
    } 

?>
