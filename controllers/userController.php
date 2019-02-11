<?php 
	/**
	 * 
	 */
	class userController extends controller
	{
		public function index()
		{
			$u = new User();
			echo $u -> getUserForm();
		}

		public function login_form()
		{
			$u = new User();
			echo $u-> getLoginForm( array('txt_login','psw_pass'),'users','Entrar');
		}

		public function log()
		{
			$u = new User();
			echo $u -> log('users',  array('txt_login' => 'webmaster', 'psw_pass' => '1234' ));
		}
	}
?>