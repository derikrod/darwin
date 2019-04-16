<?php 
	class homeController extends controller{
		function index()
		{	
			$u = new User();
			$e = new Event();
			$t = new Trello();
			$h = new Hours();

			if (isset($_COOKIE["intra_user"])&& !empty($_COOKIE["intra_user"])) {
				$dados =  array();
				foreach ($u-> getUserInformation($_COOKIE["intra_user"]) as $key => $value) {
					$username = $value["txt_name"];
				}
				$dados["name"] = $username;
				$dados["usermodule"] = $u-> loadUserModule(1,$_COOKIE["intra_user"] );
				$dados["eventmodule"] = $e-> loadEventModule(2,$_COOKIE["intra_user"] );
				$dados["trellomodule"] = $t-> loadTrelloModule(3,$_COOKIE["intra_user"] );
				$dados["bhmodule"] = $h-> loadUserHoursModule(4,$_COOKIE["intra_user"]);
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