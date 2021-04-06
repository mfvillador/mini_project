<?php

class OwnerMapper extends DB\SQL\Mapper{
    
    public function __construct(DB\SQL $db) {
        parent::__construct($db, 'owner');
    }  
    
    public function listOwner() {
        $this->load();
        return $this->query;
    }

    public function addCustomer() {
        $this->copyFrom('POST');
        $this->save();
    }

    public function getByUserName($uname) {
        $this->load(array('cus_uname=?', $uname));
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