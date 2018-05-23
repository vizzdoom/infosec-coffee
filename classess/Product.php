<?php
/**
 * Created by IntelliJ IDEA.
 * User: amichalczyk
 * Date: 10/05/2018
 * Time: 18:59
 */

class Product
{
    public function __construct($id = 0, $name = "", $category = "", $price = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
    }


    public $id = 0;
    public $name = "";
    public $category = "";
    public $price = 0;

    public function getDescription(){
        return $this->name." - ".number_format($this->price/100, 2)." &euro;";
    }
}