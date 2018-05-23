<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="vizzdoom@gmail.com">

    <title>Infosec Coffee</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="css/business-casual.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
</head>
<body>
<h1 class="site-heading text-center text-white d-none d-lg-block">
    <span class="site-heading-upper text-primary mb-3">Strong coffee, strong <u>roots</u></span>
    <span class="site-heading-lower">Infosec Coffee</span>
</h1>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
    <div class="container">
        <a class="navbar-brand text-uppercase text-expanded font-weight-bold d-lg-none" href="#">Start Bootstrap</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href=".">About Our Cafe</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="?page=store">Online Store</a>
                </li>

                    <?php
                    global $currentUser;
                    if ($currentUser->authenticated) {
                        echo '<li class="nav-item px-lg-4">
                                <a class="nav-link text-uppercase text-expanded" href="?page=account"><i class="fas fa-user"></i>&nbsp;&nbsp;Customer Panel';
                        if ($currentUser->cartBalance) {
                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-shopping-cart"></i>&nbsp;&nbsp;' . count($currentUser->cart) . '&nbsp;&nbsp;item(s):  ' . number_format($currentUser->cartBalance / 100, 2) . ' &euro;';
                        }
                        echo '</a>
                              </li>
                              <li class="nav-item px-lg-4"><a class="nav-link text-uppercase text-expanded" href="?page=logout"><i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp;Sign out</a></li>';
                    }
                    else {
                        echo '<li class="nav-item px-lg-4"><a class="nav-link text-uppercase text-expanded" href="?page=account">Sign in</a></li>';
                    }
                    ?>
            </ul>
        </div>
    </div>
</nav>
<?php
global $flash;
$flash = $flash.getFlash();
if ($flash){
    echo "<br/><div class='col-md-6 offset-3 text-center'><h5>$flash</h5>
</div>";
}
?>