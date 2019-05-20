<?php
	/**
	  * 
	  */
	 class latesController extends Controller
	 {
	 	
	 	public function index()
		{	
			$l = new Late();
			$u = new User();
			if (isset($_COOKIE["intra_user"])&& !empty($_COOKIE["intra_user"])) {
				$dados =  array();
				foreach ($u-> getUserInformation($_COOKIE["intra_user"]) as $key => $value) {
					$username = $value["txt_name"];
				}
				$dados["name"] = $username;
				$dados["bhmodule"] = $l->listUserLates($_COOKIE["intra_user"]);
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
			$l = new Late();
			$u = new User();
			if (isset($_COOKIE["intra_user"])&& !empty($_COOKIE["intra_user"])) {
				$dados =  array();
				foreach ($u-> getUserInformation($_COOKIE["intra_user"]) as $key => $value) {
					$username = $value["txt_name"];
				}
				$dados["name"] = $username;
				$dados["bhmodule"] = $l->listAdminLates($_COOKIE["intra_user"]);
				$this->loadTemplate('main',$dados);
			}else{
				$dados = array(
				'form'=> $u-> getLoginForm( array('txt_login','psw_pass'),'users','Entrar','login')
				);
				$this->loadTemplate('home',$dados);
			}	
		}

		public function addform()
		{
			$l = new Late();
			echo json_encode(array('form'=>$l-> getLateForm()));
		}
		public function updateForm($id){
			$l = new Late();
			echo json_encode(array('form' =>$l-> getUpdateLateForm($id),'hours'=> $l->getHours($id)));
		}

		public function addlate()
		{
			$l = new Late();
			if ($l->addLate($_POST)) {
				echo json_encode(array('success' => 1));
			}else{
				echo json_encode(array('success' => 0));
			}
		}

		public function update($id)
		{
			$l = new Late();
			$l-> updateLate($_POST,$id);
			echo json_encode(array('success'=> 1));
		}


		public function delete($id)
		{
			$l = new Late();
			$l-> deleteLate($id);
			echo json_encode(array('success'=> 1));
		}

		public function use_hours($id)
		{
			$l = new Late();
			if ($l-> useHour($id)){
				echo json_encode(array('success'=>1));
			}else{
				echo json_encode(array('success'=>0));
			}
		}

		public function descount($id)
		{
			$l = new Late();
			if ($l-> useMoney($id)){
				echo json_encode(array('success'=>1));
			}else{
				echo json_encode(array('success'=>0));
			}
		}
	 } 
 ?>