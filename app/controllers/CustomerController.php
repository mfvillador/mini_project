<?php

class CustomerController extends Controller {
	
	function renderLogin() {
		$this->f3->set('html_title','Customer Login');

		$this->f3->set('content','customer_log.htm');
		echo Template::instance()->render('layout.htm');
	}
	
	function loginCustomer() {
		$cus_log = new CustomerMapper($this->db);
		$cus_login = $cus_log->listCustomers();
		$cus_uname = $this->f3->get('POST.cus_uname');
		$cus_password = $this->f3->get('POST.cus_password');
		
		foreach($cus_login as $log){
			if($cus_uname == $log->cus_uname && $cus_password == $log->cus_password){
				$this->f3->reroute('/customer/' . $cus_uname);
			}
		}

		// else
		$this->f3->reroute('/customerlog');		
	}

	function renderSignUp() {
		$this->f3->set('html_title','Customer Sign Up');

		$this->f3->set('content','customer_signup.htm');
		echo Template::instance()->render('layout.htm');
	}

	function signUpCustomer() {
		$cus_add = new CustomerMapper($this->db);

		$cus_log = new CustomerMapper($this->db);
		$cus_sign = $cus_log->listCustomers();
		
		$cus_uname = $this->f3->get('POST.cus_uname');
		$cus_password = $this->f3->get('POST.cus_password');
		$cus_password2 = $this->f3->get('POST.cus_password2');
				
		// confrims password
		if($cus_password == $cus_password2){
			// checks if user name already exists
			foreach($cus_sign as $sign){
				if($cus_uname == $sign->cus_uname){
					// uname already exists
					$this->f3->reroute('/customersign');
				}	
			}
			$cus_add->addCustomer();
			$this->f3->reroute('/customerlog');
		}
		
		//else
		$this->f3->reroute('/customersign');
	}

	function render() {
		$this->f3->set('html_title','Customer Page');
		
		$uname = $this->f3->get('PARAMS.uname');
		$this->f3->set('uname', $uname);
		$this->f3->set('SESSION.uname', $uname);

        $display_prod = new ProductMapper($this->db);
		$products = $display_prod->viewItems();	

		$display_cart = new CustomerCartMapper($this->db);
		$cart = $display_cart->listCart($uname);

		//$del_prod = new ProductMapper($this->db);
		//$prod = $del_prod->deleteItem('B1')[0];
		//$this->f3->set('product1', $prod1);
		$this->f3->set('product', $products);
		$this->f3->set('cart', $cart);

		$this->f3->set('content','customer.htm');
		echo Template::instance()->render('layout.htm');   

	}

	function addToCart() {
		$add_to_cart = new CustomerCartMapper($this->db);

		$prod_code = $this->f3->get('PARAMS.code');
		$uname = $this->f3->get('SESSION.uname');

		$cart = new CustomerCartMapper($this->db);
		$cart_items = $cart->listCart($uname);

		foreach($cart_items as $item){
			if($item->pi_code == $prod_code && $item->cus_uname == $uname){
				// order already exist, increment only
				$add_to_cart->getById($item->cc_id);
				$add_to_cart->count++;
				$add_to_cart->save();
				
				$this->f3->reroute('/customer/' . $uname);
			}
		}

		$add_to_cart->addItemToCart($prod_code, $uname);
		$this->f3->reroute('/customer/' . $uname);
	}

	function reduceItemStocks($id) {
		$to_reduce = new ProductMapper($this->db);

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
		$id1 = $this->f3->get('PARAMS.id');

		$product = new ProductMapper($this->db);
		$product->load(array('pi_code=?', $code));
		$product->copyTo('POST');

		$this->f3->set('id', $id1);
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
		$code - $this->f3->get('PARAMS.code');

		$delete_item = new ProductMapper($this->db);
		$delete = $delete_item->deleteItem($code);
		
		//$this->f3->reroute('/owner');
	}
}