<?php
	/**
	  * 
	  */
	 class newsController extends controller
	 {
	 	public function index()
		{	
			$h = new Hours();
			$u = new User();
			if (isset($_COOKIE["intra_user"])&& !empty($_COOKIE["intra_user"])) {
				$dados =  array();
				foreach ($u-> getUserInformation($_COOKIE["intra_user"]) as $key => $value) {
					$username = $value["txt_name"];
				}
				$dados["name"] = $username;
				$dados["bhmodule"] = $h->listHours($_COOKIE["intra_user"]);
				$this->loadTemplate('main',$dados);
			}else{
				$dados = array(
				'form'=> $u-> getLoginForm( array('txt_login','psw_pass'),'users','Entrar','login')
				);
				$this->loadTemplate('home',$dados);
			}	
		}
	 } 
 ?>