<?php

class Controller {
	
	protected $f3;
	protected $db;

    function beforeroute() {
		// echo 'BEFORE';
	}
	function afterroute() {
		// echo 'AFTER';
	}

	function __construct() {
		
		$f3=Base::instance();
		$this->f3=$f3;

		$db=new DB\SQL(
			'mysql:host='.$this->f3->get('DB_HOST').';port=3306;dbname='.$this->f3->get('DB_NAME'),
			$f3->get('DB_USER'),
			$f3->get('DB_PASS'),
			//array( \PDO::ATTR_PERSISTENT => TRUE )
			array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION )
		);
		$this->db=$db;

	}

}