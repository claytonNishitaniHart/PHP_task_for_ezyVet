<?php
// Product class that holds the supplied array
class Products
{
    public $products;

    function __construct()
    {
        $this->products = [
            ["name" => "Sledgehammer", "price" => 125.75],
            ["name" => "Axe", "price" => 190.50],
            ["name" => "Bandsaw", "price" => 562.131],
            ["name" => "Chisel", "price" => 12.9],
            ["name" => "Hacksaw", "price" => 18.45]
        ];
    }

    function getProductsArray()
    {
        return $this->products;
    }
}
