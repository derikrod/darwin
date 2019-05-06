<?php 
	class usersController extends controller{
		public function index()
		{	
			$u = new User();
			
			if (isset($_COOKIE["intra_user"])&& !empty($_COOKIE["intra_user"])) {
				$dados =  array();
				foreach ($u-> getUserInformation($_COOKIE["intra_user"]) as $key => $value) {
					$username = $value["txt_name"];
				}
				$dados["name"] = $username;
				$dados["usermodule"] = $u->loadUserTable();
				$this->loadTemplate('main',$dados);
			}else{
				$dados = array(
				'form'=> $u-> getLoginForm( array('txt_login','psw_pass'),'users','Entrar','login')
				);
				$this->loadTemplate('home',$dados);
			}
			
		}

		public function addForm(){
			$u = new User();
			echo json_encode(array('user_form'=> $u->getUserForm()));
		}

		public function updateForm($id){
			$u = new User();
			echo json_encode(array('form' => $u->getUpdateUserForm($id)));
		}

		public function adduser()
		{
			$u = new User();
			foreach ($_POST as $key => $value) {
				if (substr($key, 0,3) == 'psw') {
					$_POST[$key] = md5($value);
				}
			}

			if($u-> addUser($_POST)){
				echo json_encode(array('success' => 1));
			}else{
				echo json_encode(array('success' => 0));
			}
		}


		public function update($id)
		{
			$u = new User();
			if($u-> updateUser($_POST,$id)){
				echo json_encode(array('success' => 1));
			}else{
				echo json_encode(array('success' => 0));
			}
		}


		public function delete($id)
		{
			$u = new User();
			if($u-> deleteUser($id)){
				echo json_encode(array('success' => 1));
			}else{
				echo json_encode(array('success' => 0));
			}
		}
	}
?>