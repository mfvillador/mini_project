<?php

class ProductMapper extends DB\SQL\Mapper{
    
    public function __construct(DB\SQL $db) {
        parent::__construct($db, 'product_items');
    }  
    
    public function viewItems() {
        $this->load();
        return $this->query;
    }

    public function addItem() {
        $this->copyFrom('POST');
        $this->save();
    }

    public function getByCode($code) {
        $this->load(array('pi_code=?', $code));
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
        $this->delete();
    }

}