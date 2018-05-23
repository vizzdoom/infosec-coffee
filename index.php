<?php
global $currentUser;
global $flash;

include("includes.php");
include("connection.php");

$currentPage = @$_GET['page'];
$currentAction = $_POST['action'] ?? @$_GET['action'];

if ($currentAction === "login"){
    $currentPage = "account";
    $authenticatedUser = $currentUser->login(@$_POST['login'], @$_POST['password']);
    if ($authenticatedUser){
        $currentUser = $authenticatedUser;
        $_SESSION['user'] = $currentUser;
        header("Location: .");
        die();
    }
    else {
        $flash = "<div class='alert alert-danger'>Wrong login and/or password</div>";
    }
}


if ($currentPage === "logout"){
    if (isset($_SESSION['authenticatedId'])) $_SESSION['authenticatedId'] = null;
    session_destroy();
    session_regenerate_id();
    header("Location: .");
    die();
}

$inclusionPage = null;

try {
    if ($currentPage === "store"){
        $inclusionPage = "views/store.php";
    }
    else if ($currentPage === "account"){
        if ($currentUser->authenticated && $currentAction){
            if ($currentAction === "add" && isset($_GET['id'])) {
                $currentUser->addToCart($_GET['id']);
                $flash = "<div class='alert alert-warning'>Product has been added to your cart.</div>";
            }
            else if ($currentAction === "duplicate" && isset($_GET['id'])) {
                $currentUser->duplicateInCart($_GET['id']);
                header("Location: ?page=account#cart");
                die();
            }
            else if ($currentAction === 'remove' && isset($_GET['id'])){
                $currentUser->removeFromCartByCartId($_GET['id']);
                header("Location: ?page=account#cart");
                die();
            }
            else if ($currentAction === 'clearCart'){
                $currentUser->clearCart();
            }
            else if ($currentAction === 'pay' && isset($_POST['products'])){
                $feedback = $currentUser->pay($_POST['products']);
                setFlash("<div class='alert alert-warning'>You have bought <strong>{$feedback['productsCount']} product(s)</strong> for <strong>{$feedback['totalPrice']}&euro;</strong></div>");
                header("Location: ?page=account&action=bought");
                die();
            }
            else if ($currentAction === 'claimed' || $currentAction='bought'){
                sleep(1);
            }
            if (strstr(@$_SERVER['HTTP_REFERER'], "page=store")){
                $inclusionPage = "views/store.php";
            }
            else {
                $inclusionPage = "views/account.php";
            }
        }
        $inclusionPage = "views/account.php";
    }
    else {
        $inclusionPage = "views/about.php";
    }
} catch (Exception $ex){

    $flash = "<br/><strong><div class='alert alert-danger text-center col-md-6 offset-3'>{$ex->getMessage()}</div></strong><br/>";
}
include("views/_head.php");
if ($inclusionPage) include($inclusionPage);
include("views/_tail.php");
?>
