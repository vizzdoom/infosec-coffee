<?php
include("config.php");
require("classess/User.php");
require("classess/Product.php");
require("classess/Storage.php");

session_start();
global $currentUser;
$currentUser = @$_SESSION['user'] ?? new User();

function setFlash($message){
    $_SESSION['flash'] = $message;
}

function getFlash(){
    if (isset($_SESSION['flash'])){
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return "";
}