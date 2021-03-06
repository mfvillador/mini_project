<?php

class CustomerCartMapper extends DB\SQL\Mapper{
    
    public function __construct(DB\SQL $db) {
        parent::__construct($db, 'customer_cart');
    }  
    
    public function listCart($uname) {
        $this->load(array('cus_uname=?', $uname));
        return $this->query;
    }

    public function listAllCart() {
        $this->load();
        return $this->query;
    }

    public function addItemToCart($uname, $code, $name, $price) {
        $this->cus_uname = $uname;
        $this->pi_code = $code;
        $this->order_name = $name;
        $this->order_price = $price;
        $this->order_count = '1'; // initialize count
        $this->save();
    }

    public function getById($id) {
        $this->load(array('cc_id=?', $id));
        return $this->query;
    }

    public function getByCode($code) {
        $this->load(array('pi_code=?', $code));
        return $this->query;
    }

    public function removeOrderFromCart($id) {
        $this->load(array('cc_id=?', $id));
        $this->erase();
    }

    public function removeByCode($code) {
        $this->load(array('pi_code=?', $code));
        $this->erase();
    }
}