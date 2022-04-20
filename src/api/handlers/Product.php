<?php

namespace Api\Handlers;

class Product{
    function get($select= "", $where = "", $limit = 10, $page =1)
    {
        $products = array(
            array('select'=>$select , 'where'=> $where , 'limit'=> $limit , 'page' => $page),
            array('name' => 'Product 2' , 'price' => 40),
        );
        return json_encode($products);
    }
}