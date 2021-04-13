<?php

class CustomerCheckoutMapper extends DB\SQL\Mapper{
    
    public function __construct(DB\SQL $db) {
        parent::__construct($db, 'customer_checkout');
    }  
    
    public function listAllCheckout(){
        $this->load();
        return $this->query;
    }

    public function listCheckout($uname) {
        $this->load(array('cus_uname=?', $uname));
        return $this->query;
    }

    public function addOrderToCheckout($uname, $code, $name, $price, $count) {
        $this->cus_uname = $uname;
        $this->pi_code = $code;
        $this->order_name = $name;
        $this->order_price = $price;
        $this->order_count = $count; // initialize count
        $this->save();
    }

    public function getById($id) {
        $this->load(array('cch_id=?', $id));
        return $this->query;
    }

    public function removeItem($id) {
        $this->load(array('cch_id=?', $id));
        $this->erase();
    }

}