<?php 
	/**
	 * 
	 */
	class suggestionsController extends controller
	{
		
		public function index($id)
		{	
			$s = new Suggestion();
			$u = new User();
			if (isset($_COOKIE["intra_user"])&& !empty($_COOKIE["intra_user"])) {
				$dados =  array();
				foreach ($u-> getUserInformation($_COOKIE["intra_user"]) as $key => $value) {
					$username = $value["txt_name"];
				}
				$dados["name"] = $username;
				$dados["suggestionmodule"] = $s->suggestionsTable($_COOKIE['intra_user']);
				$this->loadTemplate('main',$dados);
			}else{
				$dados = array(
				'form'=> $u-> getLoginForm( array('txt_login','psw_pass'),'users','Entrar','login')
				);
				$this->loadTemplate('home',$dados);
			}	
		}

		public function admin()
		{	
			$s = new Suggestion();
			$u = new User();
			if (isset($_COOKIE["intra_user"])&& !empty($_COOKIE["intra_user"])) {
				$dados =  array();
				foreach ($u-> getUserInformation($_COOKIE["intra_user"]) as $key => $value) {
					$username = $value["txt_name"];
				}
				$dados["name"] = $username;
				$dados["suggestionmodule"] = $s->suggestionsAdminTable();
				$this->loadTemplate('main',$dados);
			}else{
				$dados = array(
				'form'=> $u-> getLoginForm( array('txt_login','psw_pass'),'users','Entrar','login')
				);
				$this->loadTemplate('home',$dados);
			}	
		}
		public function getForm($id){
			$su = new Suggestion();
			echo json_encode( array('form' => $su -> getSuggestionForm($id)));
		}

		public function insert()
		{
			$su = new Suggestion();
			if ($su-> setSuggestions($_POST)) {
				echo json_encode(array('success'=>1));
			}else{
				echo json_encode(array('success'=>0));
			}
		}

		public function updateForm($id)
			{
				$su = new Suggestion();
				echo json_encode(array('form' => $su-> getUpdateForm($id)));
			}

		public function update($id)
			{
				$su = new Suggestion();
				if ($su-> updateSuggestions($_POST,$id)) {
				echo json_encode(array('success'=>1));
			}else{
				echo json_encode(array('success'=>0));
			}
		}

		public function delete($id)
		{
			$su = new Suggestion();
				if ($su-> deleteSuggestions($id)) {
				echo json_encode(array('success'=>1));
			}else{
				echo json_encode(array('success'=>0));
			}
		}	
	}

 ?>