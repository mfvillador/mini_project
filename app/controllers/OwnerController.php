<?php

class OwnerController extends Controller {
	
	function render() {
		$this->f3->set('html_title','Owner Page');
		
		$display_prod = new ProductMapper($this->db);
		$products = $display_prod->viewItems();	

		$display_order = new CustomerCheckoutMapper($this->db);
		$orders = $display_order->listAllCheckout();

		$this->f3->set('product', $products);
		$this->f3->set('order', $orders);

		$this->f3->set('content','owner.htm');
		echo Template::instance()->render('layout.htm');   

	}

	function renderAdd() {
		$this->f3->set('html_title','Owner Add Item');
		
		$this->f3->set('content','owner_add.htm');
		echo Template::instance()->render('layout.htm');
	}

	function addItem() {
		$add_item = new ProductMapper($this->db);
		$add =  $add_item->addItem();
		
		$this->f3->reroute('/owner');
	}

	function renderUpdate() {
		$this->f3->set('html_title','Owner Update Item');
		
		$code = $this->f3->get('PARAMS.code');

		$product = new ProductMapper($this->db);
		$product->load(array('pi_code=?', $code));
		$product->copyTo('POST');

		$this->f3->set('content','owner_update.htm');
		echo Template::instance()->render('layout.htm');
	}
	
	function updateItem() {
		$code = $this->f3->get('PARAMS.code');

		$update_item = new ProductMapper($this->db);
		$update = $update_item->updateItem($code);
		
		$this->f3->reroute('/owner');
	}

	function deleteItem() {
		$code = $this->f3->get('PARAMS.code');

		$delete_item = new ProductMapper($this->db);
		$delete = $delete_item->deleteItem($code);
		
		$this->f3->reroute('/owner');
	}

	function deliveredItem() {
		$id = $this->f3->get('PARAMS.id');
		
		// delete item from checkout data
		$remove_item = new CustomerCheckoutMapper($this->db);
		$remove = $remove_item->removeItem($id);
		
		$this->f3->reroute('/owner');
	}
}