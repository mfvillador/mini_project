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
					// user name already exists
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
		
		$full_name = new CustomerMapper($this->db);
		$full_name->getByUserName($uname);
		
		$this->f3->set('uname', $uname);
		$this->f3->set('fname', $full_name->cus_fname);
		$this->f3->set('SESSION.uname', $uname);

        $display_prod = new ProductMapper($this->db);
		$products = $display_prod->customerView();	

		$display_cart = new CustomerCartMapper($this->db);
		$cart = $display_cart->listCart($uname);

		$display_order = new CustomerCheckoutMapper($this->db);
		$order = $display_order->listCheckout($uname);

		// totals the price of the checked out order
		$total_price = $this->getTotalPrice($uname);

		$this->f3->set('product', $products);
		$this->f3->set('cart', $cart);
		$this->f3->set('order', $order);
		$this->f3->set('total', $total_price);

		$this->f3->set('content','customer.htm');
		echo Template::instance()->render('layout.htm');   

	}

	function getTotalPrice($uname){
		$checkout = new CustomerCheckoutMapper($this->db);
		$order = $checkout->listCheckout($uname);

		$total_price = '0'; // initialize total price
 
		foreach($order as $ord){
			$total_price += $ord->order_price * $ord->order_count;
		}

		return $total_price;
	}

	function addToCart() {
		$add_to_cart = new CustomerCartMapper($this->db);

		$uname = $this->f3->get('SESSION.uname');
		$code = $this->f3->get('PARAMS.code');
		
		// get product infos by code
		$product = new ProductMapper($this->db);
		$product->getByCode($code);
		$name = $product->pi_name;
		$price = $product->pi_price;

		$cart = new CustomerCartMapper($this->db);
		$cart_items = $cart->listCart($uname);

		foreach($cart_items as $item){
			if($item->pi_code == $code && $item->cus_uname == $uname){
				// order already exist, increment only
				$add_to_cart->getById($item->cc_id);
				// check item availability
				if($product->pi_stock > $add_to_cart->order_count){
					$add_to_cart->order_count++;
					$add_to_cart->save();
				}	
				
				$this->f3->reroute('/customer/' . $uname);
			}
		}

		$add_to_cart->addItemToCart($uname, $code, $name, $price);
		$this->f3->reroute('/customer/' . $uname);
	}

	function removeOrder() {
		$uname = $this->f3->get('SESSION.uname');
		$id = $this->f3->get('PARAMS.id');

		$delete_item = new CustomerCartMapper($this->db);
		$delete = $delete_item->removeOrderFromCart($id);
		
		$this->f3->reroute('/customer/' . $uname);
	}

	function checkoutCart() {
		$uname = $this->f3->get('PARAMS.uname');
		
		$cart = new CustomerCartMapper($this->db);
		$order = $cart->listCart($uname);
		
		// copying from cart to checkout
		foreach($order as $ord){
			$checkout = new CustomerCheckoutMapper($this->db);
			$code = $ord->pi_code;
			$name = $ord->order_name;
			$price = $ord->order_price;
			$count = $ord->order_count;
			$checkout->addOrderToCheckout($uname, $code, $name, $price, $count);
			
			$remove = new CustomerCartMapper($this->db);
			$remove->removeOrderFromCart($ord->cc_id);
			$this->reduceItemStocks($code, $count);
		}	
		
		// 
		$prod_items = new ProductMapper($this->db);
		$items = $prod_items->viewItems();
		
		foreach($items as $i){
			$list_cart = new CustomerCartMapper($this->db);
			
			// removing items in cart with 0 stock
			if($i->pi_stock == '0'){
				$cart = $list_cart->listAllCart();
				foreach($cart as $c){
					if($c->pi_code == $i->pi_code){
						$remove = new CustomerCartMapper($this->db);
						$remove->removeOrderFromCart($c->cc_id);
					}
				}
				continue;
			}

			// reduce item count to max stock
			$cart = $list_cart->getByCode($i->pi_code);
			foreach($cart as $c){
				if($c->order_count > $i->pi_stock){
					$c->order_count = $i->pi_stock;
					$c->save();
				}
			}
		}
		
		$this->f3->reroute('/customer/' . $uname);
	}

	function reduceItemStocks($code, $count) {
		$to_reduce = new ProductMapper($this->db);
		$to_reduce->getByCode($code);
		$to_reduce->pi_stock -= $count;
		$to_reduce->save();
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