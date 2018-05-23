<?php
include("includes.php");
$feedbackMsg = "";
try {
    if (!@$_SESSION['authenticatedId'] || !isset($_POST['code'])){
        throw new Exception("Unauthorized operation");
    }
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

    $code = $conn->real_escape_string(@$_POST['code']);
    $res = $conn->query("SELECT `code`, `value`, `claimed` from `coupons` WHERE `code` = '$code' and `claimed` = 0");
    $data = $res->fetch_assoc();
    if ($data){
        $conn->query("UPDATE `users` inner join `coupons` SET `wallet`=`wallet`+{$data['value']}, claimed=1 WHERE `id`={$_SESSION['authenticatedId']} and code = '{$code}'", MYSQLI_ASYNC);
        $feedbackMsg = "Funds have been added to your wallet.";
    }
    else {
        $feedbackMsg = "Invalid voucher code or voucher has already been used. Make sure you entered the code correctly.";
    }
}
catch (Exception $ex){
    $feedbackMsg = $ex;
}
echo $feedbackMsg;
setFlash("<div class='alert alert-warning'>$feedbackMsg</div>");
header("Location: index.php?page=account&action=claimed");