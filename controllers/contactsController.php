<?php class contactsController extends controller{
function index()
		{	
			$u = new User();
			$cont = new Contact();

			if (isset($_COOKIE["intra_user"])&& !empty($_COOKIE["intra_user"])) {
				$dados =  array();
				foreach ($u-> getUserInformation($_COOKIE["intra_user"]) as $key => $value) {
					$username = $value["txt_name"];
				}
				$dados["name"] = $username;
				$dados["contactmodule"] = $cont-> contactTable();
				$this->loadTemplate('main',$dados);
			}else{
				$dados = array(
				'form'=> $u-> getLoginForm( array('txt_login','psw_pass'),'users','Entrar','login'));
				$this->loadTemplate('home',$dados);
			}
			
		}


		function get(){
			$c = new Contact();
			echo json_encode(array('list' => $c-> getContact($_POST['txt_name']))); 
		}
}?>