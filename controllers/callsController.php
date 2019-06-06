<?php 
	/**
	 * 
	 */
	class callsController extends controller
	{
		public function index()
		{
			$u = new User();
			$cll = new Call();

			if (isset($_COOKIE["intra_user"])&& !empty($_COOKIE["intra_user"])) {
				$dados =  array();
				foreach ($u-> getUserInformation($_COOKIE["intra_user"]) as $key => $value) {
					$username = $value["txt_name"];
				}
				$dados["name"] = $username;
				$dados["callsmodule"] = $cll-> getUserTable($_COOKIE["intra_user"]);
				$this->loadTemplate('main',$dados);
			}else{
				$dados = array(
				'form'=> $u-> getLoginForm( array('txt_login','psw_pass'),'users','Entrar','login'));
				$this->loadTemplate('home',$dados);
			}
		}

		public function getuserform($iduser)
		{
			$cll = new Call();
			echo json_encode(array('form' => $cll-> getUserForm($iduser)));
		}
		public function updateForm($id){
			$cll = new Call();
			echo json_encode(array('form' => $cll-> updateUserForm($id)));
		}
		public function add(){
			$cll = new Call();
			if ($cll->addCall($_POST)) {
				echo json_encode(array('success'=>1,'iduser'=>$_COOKIE['intra_user'],'path'=> BASE_URL));
			}else{
				echo json_encode(array('success'=>0));
			}
			
		}


		public function update($id)
		{
			$cll = new Call();
			if($cll-> updateCall($_POST,$id)){
				echo json_encode(array('success'=>1));
			}else{
				echo json_encode(array('success'=>0));
			}
		}

		public function delete($id)
		{
			$cll = new Call();
			if($cll-> deleteCall($id)){
				echo json_encode(array('success'=>1));
			}else{
				echo json_encode(array('success'=>0));
			}
		}
	}

?>