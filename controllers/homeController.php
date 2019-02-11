<?php 
	class homeController extends controller{
		function index()
		{	
			$u = new User();
			$dados = array(
				'form'=> $u-> getLoginForm( array('txt_login','psw_pass'),'users','Entrar')
			);
			$this->loadTemplate('home',$dados);
		}
	}
 ?>