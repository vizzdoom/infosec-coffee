<?php
/**
 * Created by IntelliJ IDEA.
 * User: amichalczyk
 * Date: 10/05/2018
 * Time: 18:15
 */

class User
{
    public function __construct($id = 0, $login = "", $wallet = 0, $authenticated = false)
    {
        $this->id = $id;
        $this->login = $login;
        $this->wallet = $wallet;
        $this->authenticated = $authenticated;
    }

    public $id = 0;
    public $login = "";
    public $cart = [];
    private $wallet = 0;
    public $cartBalance = 0;
    public $authenticated = false;

    public function getWallet(): int{
        $conn = new PDO(DB_CONNECTION_STRING, DB_USERNAME, DB_PASSWORD);
        $q = $conn->prepare("SELECT `wallet` from `users` WHERE id = :userId");
        $q->bindParam(":userId", $this->id);
        $q->execute();
        $this->wallet = (int)$q->fetch()['wallet'];
        return $this->wallet;
    }

    public function login($login, $password){
        try {
            global $conn;
            $q = $conn->prepare("SELECT * from `users` WHERE login = :login AND password = :password");
            $q->bindParam(":login", $login);
            $hashedPassword = hash('sha256', $password);
            $q->bindParam(":password",$hashedPassword);
            $q->execute();
            $result = $q->fetch();
            $_SESSION['authenticatedId'] = $result['id'];
            if ($result){
                return new User($result['id'], $result['login'], $result['wallet'], true);
            }
            return null;

        } catch (Exception $ex) {
            throw new Exception($ex);
        }
    }

    public function addToCart($productId): int
    {
        array_push($this->cart, $productId);
        $product = Storage::getInstance()->getProductById($productId);
        $this->cartBalance += $product->price;
        return $this->cartBalance;
    }

    public function duplicateInCart($id): int
    {
        $product = Storage::getInstance()->getProductById($this->cart[$id]);
        array_push($this->cart, $product->id);
        $this->cartBalance += $product->price;
        return $this->cartBalance;
    }

    public function removeFromCartByProductId($productId): int
    {
        if (($key = array_search($productId, $this->cart)) !== false) {
            $product = Storage::getInstance()->getProductById($productId);
            $this->cartBalance -= $product->price;
            unset($this->cart[$key]);
        }
        return $this->cartBalance;
    }

    public function removeFromCartByCartId($id): int
    {
        $product = Storage::getInstance()->getProductById($this->cart[$id]);
        $this->cartBalance -= $product->price;
        unset($this->cart[$id]);
        $this->cart = array_values($this->cart);
        return $this->cartBalance;
    }
    
    public function fetchTransactions() {
        global $currentUser;
        $conn = new PDO(DB_CONNECTION_STRING, DB_USERNAME, DB_PASSWORD);
        $q = $conn->prepare("SELECT `transaction_id`,`date`, `products_list`, `total_price` FROM `transactions` WHERE `user_id` = :userId");
        $q->bindParam(":userId", $currentUser->id);
        $q->execute();
        $transactions = $q->fetchAll();
        if (!$transactions){
            return null;
        }

        $transactionsList = [];
        foreach ($transactions as $t){
            $transaction = [];
            $transaction['transaction_id'] = $t['transaction_id'];
            $transaction['date'] = $t['date'];
            $transaction['total_price'] = $t['total_price'];
            $transaction['products'] = [];
            $productsIDs = explode(",", $t['products_list']);
            foreach ($productsIDs as $p){
                $transaction['products'][] = Storage::getInstance()->getProductById($p);
            }
            $transactionsList [] = $transaction;
        }
        return $transactionsList;
    }

    public function pay($productsList){
        $conn = new mysqli(DB_HOST,DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
        global $currentUser;
        $q = $conn->query("SELECT `wallet` from `users` WHERE id = {$currentUser->id}");
        $currentUserWallet = $q->fetch_assoc()['wallet'];

        $q = $conn->prepare("SELECT price from `products` WHERE id = ?");
        $totalPriceServerSide = 0;
        $products = explode(",", $productsList);
        foreach ($products as $p){
            $q->bind_param("i", $p);
            $q->execute();
            $q->bind_result($result);
            $q->fetch();
            if (!$result){
                throw new Exception("Cannot find product in the database");
            }
            $totalPriceServerSide += (int)$result;
        }

        if ($currentUserWallet < $totalPriceServerSide){
            throw new Exception("Insufficient funds!");
        }

        $conn = new mysqli(DB_HOST,DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
        $q1 = $conn->query("INSERT INTO `transactions` (`user_id`, `products_list`, `total_price`) VALUES ($currentUser->id, '{$productsList}', '{$totalPriceServerSide}')");
        $conn->commit();

        $price = $currentUserWallet-$totalPriceServerSide;
        $q2 = $conn->query("UPDATE `users` SET `wallet` = $price", MYSQLI_ASYNC);
        $currentUser->wallet -= $totalPriceServerSide;
        $currentUser->cart = [];
        $currentUser->cartBalance = 0;

        $result = ["productsCount" => count($products), "totalPrice" => number_format($totalPriceServerSide/100, 2), $q1, $q2];
        var_dump($result);

        return $result;
    }

    public function getTransactionsList(){
        global $conn;
        global $currentUser;
        $q = $conn->prepare("SELECT `date`, `products_list`, `total_price` from `transactions` WHERE `userid` = :userId");
        $q->bindParam(":userId", $currentUser->id);
        $q->execute();
        return $q->fetchAll();
    }

    public function clearCart(){
        $this->cart = [];
        $this->cartBalance = 0;
    }
}