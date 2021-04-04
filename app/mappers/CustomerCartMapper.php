<?php

class CustomerCartMapper extends DB\SQL\Mapper{
    
    public function __construct(DB\SQL $db) {
        parent::__construct($db, 'customer_cart');
    }  
    
    public function listCart($uname) {
        $this->load(array('cus_uname=?', $uname));
        return $this->query;
    }

    public function addItemToCart($code, $uname) {
        $this->pi_code = $code;
        $this->cus_uname = $uname;
        $this->count = '1'; // initialize count
        $this->save();
    }

    public function getById($id) {
        $this->load(array('cc_id=?', $id));
        return $this->query;
    }

    public function updateItem($code) {
        if ($code) $this->load(array('pi_code=?', $code));
        $this->copyFrom('POST');
        //$this->load(array('pi_code=?', $code));
        $this->save();
    }

    public function deleteItem($code) {
        $this->load(array('pi_code=?', $code));
        $this->erase();
    }

}