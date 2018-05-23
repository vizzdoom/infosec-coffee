<?php
global $flash;
global $currentUser;

$signInFormBody = $authenticatedViewBody = "";

///Show authenticated user account panel
if ($currentUser->authenticated){
    $sectionTitle = $currentUser->login." customer panel";
    $itemHtmlList = "";

    //region Infosec Club Card Summary
    $authenticatedViewBody = "
<div class='row' style='margin-top: 50px; margin-bottom: 20px;'>
    <div class='col-md-6'> <img style='border-radius: 15px; height: 210px; border: 2px solid black' src='img/infosec-cc.png' /></div>
    <div class='col-md-6'>
        <div class='row' style='margin-top: 5px;'>
            <h4 class=\"section-heading mb-4\">You have</h4> 
        </div>
        <div class='row' style='margin-top: -10px'>
            <h1 class=\"section-heading mb-4\">{$currentUser->getWallet()} </h1>
        </div>        
        <div class='row'>
            <h4 class=\"section-heading mb-4\">Infosec Club points</h4>
        </div>
        <div class='row'>
            <h3 class=\"section-heading mb-4\">(".number_format($currentUser->getWallet()/100, 2)." &euro;)</h3>
        </div>
    </div>
</div>
<div class='row' style='margin-bottom: 20px'>
    <div class='col-md-6 text-right'><h5>Redeem your gift card</h5></div>
    <div>
        <form action='claim.php' method='post'>
            <div class='input-group mb-4' style='margin-top: -5px;'>
                <input name='code' class='form-control' placeholder='Voucher code' autocomplete='off'>
                <div class='input-group-append'>
                    <button class='btn btn-warning' type='submit'>Claim</button>
                </div>
            </div>
        </form>
    </div>
</div>
";
    //endregion
    //region Shopping cart
    $authenticatedViewBody .= "<h3 id='cart' class=\"section-heading mb-4\">Your shopping cart</h3>";
    if (count($currentUser->cart) === 0){
        $authenticatedViewBody .= "Your shopping cart is empty. <br/>Have you seen our <a href='?page=store'>store</a>?";
    } else {
        $productNumberInBag = 0;
        foreach ($currentUser->cart as $item){
            $product = Storage::getInstance()->getProductById($item);
            $itemHtmlList .= "<li>".$product->getDescription()."&nbsp;&nbsp;&nbsp;&nbsp;
                              <a href='?page=account&action=duplicate&id={$productNumberInBag}'><i class=\"fas fa-plus\"></i></a>&nbsp;&nbsp;
                              <a href='?page=account&action=remove&id={$productNumberInBag}'><i class=\"fas fa-minus\"></i></a></li>";
            $productNumberInBag++;
        }
        $authenticatedViewBody .= "<ul>$itemHtmlList</ul>
                  <h4 class='col-lg-4' style='margin-top: 30px'>Total: ".number_format($currentUser->cartBalance/100, 2)." &euro;</h4>
                  <br/>
                   <a href='?page=account&action=clearCart'><input class='btn btn-dark' value='Clear your cart'></a><br/><br/>
                   <form action='?page=account&action=pay' method='post'>
                    <input class='btn btn-success' type='submit' value='Pay with your Infosec Coffee points'>
                    <input type='hidden' name='products' value='".implode(",",$currentUser->cart)."'>
                   </form>
                   ";
    }
    //endregion

    //region Transactions
    $transactions = $currentUser->fetchTransactions();
    $totalTranscationsSum = 0;
    $body = "";

    if (!$transactions){
        $body  .= "<p>Normally there is an impressive list of your transactions.<br/>But you did't visit our <a href='?page=store'>store</a> yet.</p>";
    }
    else {
        foreach ($transactions as $t){
            $totalTranscationsSum += (int)($t['total_price']);
            $body .= "<h6 style='font-weight: bold'>TRANSACTION {$t['transaction_id']} from {$t['date']} for ".number_format($t['total_price']/100, 2)." &euro;</h6><ul>";
            foreach ($t['products'] as $p){
                $body .= "<li>{$p->getDescription()}</li>";
            }
            $body .= "</ul>";
        }
    }
    $authenticatedViewBody .= "<h3 class='section-heading mb-4' style='margin-top: 40px'>Your transactions (Total: ".number_format($totalTranscationsSum/100, 2)." &euro;)</h3> $body";
    //endregion
}
/// Show sign in form
else {
    $sectionTitle = "Sign in";
    $signInFormBody = '
<div class="authForm">
    <form method="post" action="index.php">
        <input type="hidden" name="action" value="login">
        <div class="form-group row">
            <label for="login" class="col-sm-2 col-form-label">Login</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="login" name="login" autofocus autocomplete="off">
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-sm-2 col-form-label" >Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password" autocomplete="off">
            </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-4 offset-2">
              <input type="submit" class="form-control btn btn-dark" value="Sign In" >
          </div>
        </div>
  </form>
</div>';
}
?>

<br/>
<section class="page-section about-heading">
  <div class="container">
    <div class="about-heading-content">
      <div class="row">
        <div class="col-xl-9 col-lg-10 mx-auto">
          <div class="bg-faded rounded p-5">
            <h2 class="section-heading mb-4">
                <span class="section-heading-lower"><strong><?php echo $sectionTitle ?></strong></span>
            </h2>
              <?php
                echo $authenticatedViewBody . $signInFormBody;
              ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>