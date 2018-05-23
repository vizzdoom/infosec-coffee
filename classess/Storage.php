<?php

require_once("Product.php");

class Storage {

    protected static $instance;

    public $bakeryProducts = [];
    public $beansProducts = [];

    private function __construct()
    {
        $conn = new PDO(DB_CONNECTION_STRING, DB_USERNAME, DB_PASSWORD);
        $q = $conn->prepare("SELECT `id`, `name`, `category`, `price` from `products`");
        $q->execute();
        $result = $q->fetchAll();

        foreach ($result as $product){
            if ($product['category'] == 0){
                $this->bakeryProducts[] = new Product($product['id'], $product['name'], $product['category'], $product['price']);
            }
            else {
                $this->beansProducts[] = new Product($product['id'], $product['name'], $product['category'], $product['price']);
            }
        }
    }

    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getProductById($pId){
        foreach ($this->bakeryProducts as $p){
            if ($pId == $p->id)
                return $p;
        }
        foreach ($this->beansProducts as $p){
            if ($pId == $p->id)
                return $p;
        }
        throw new Exception("There is no product with id $pId");
    }


}