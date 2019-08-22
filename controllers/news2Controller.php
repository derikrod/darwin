<?php
	/**
	  * 
	  */
	 class news2Controller extends controller
	 {
	 	public function index()
		{	
			$n = new News2();
			$u = new User();
			if (isset($_COOKIE["intra_user"])&& !empty($_COOKIE["intra_user"])) {
				$dados =  array();
				foreach ($u-> getUserInformation($_COOKIE["intra_user"]) as $key => $value) {
					$username = $value["txt_name"];
				}
				$dados["name"] = $username;
				$dados["newsmodule"] = $n->newsTable();
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
			$n = new News2();
			$u = new User();
			if (isset($_COOKIE["intra_user"])&& !empty($_COOKIE["intra_user"])) {
				$dados =  array();
				foreach ($u-> getUserInformation($_COOKIE["intra_user"]) as $key => $value) {
					$username = $value["txt_name"];
				}
				$dados["name"] = $username;
				$dados["newsmodule"] = $n->newsadminTable();
				$this->loadTemplate('main',$dados);
			}else{
				$dados = array(
				'form'=> $u-> getLoginForm( array('txt_login','psw_pass'),'users','Entrar','login')
				);
				$this->loadTemplate('home',$dados);
			}	
		}

		public function getform($value='')
		{
			$n = new News2();
			$form = $n-> newsForm();
			echo json_encode(array('form'=>$form));
		}

		public function add()
		{
			$n = new News2();
			$n -> addnews($_POST,$_FILES['fle_file']);
			echo '<p>Novo boletim cadastrado.</p><button type="button" class="btn btn-success reload-btn">Recarregar Página</button>';
		}


		public function updateForm($id)
		{
			$n = new News2();
			$form = $n-> getUpdateForm($id);
			echo json_encode(array('form' => $form));
		}

		public function delete($id)
		{
			$u = new News2();
			if($u-> deleteNews($id)){
				echo json_encode(array('success' => 1));
			}else{
				echo json_encode(array('success' => 0));
			}
		}

		public function update($id)
		{
			$u = new News2();
			if($u-> updateNews($_POST,$id)){
				echo json_encode(array('success' => 1));
			}else{
				echo json_encode(array('success' => 0));
			}
		}

		public function fileuploader($id)
		{
			$n = new News2();
			echo json_encode(array('form'=> $n->getUpdateFile($id)));
		}

		public function upgradefile()
		{
			$n = new News2();
			$n -> updateNewsFile($_POST,$_FILES['fle_file']);

			echo '<p>Documento alterado com sucesso.</p><button type="button" class="btn btn-success reload-btn">Recarregar Página</button>';
		}
	 } 
 ?>