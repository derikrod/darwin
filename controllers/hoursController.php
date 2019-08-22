<?php 
	class hoursController extends controller{
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
		public function admin($value='')
		{
			$h = new Hours();
			$u = new User();
			if (isset($_COOKIE["intra_user"])&& !empty($_COOKIE["intra_user"])) {
				$dados =  array();
				foreach ($u-> getUserInformation($_COOKIE["intra_user"]) as $key => $value) {
					$username = $value["txt_name"];
				}
				$dados["name"] = $username;
				$dados["bhmodule"] = $h->listAdminHours();
				$this->loadTemplate('main',$dados);
			}else{
				$dados = array(
				'form'=> $u-> getLoginForm( array('txt_login','psw_pass'),'users','Entrar','login')
				);
				$this->loadTemplate('home',$dados);
			}
		}

		public function update($id)
		{
			$h = new Hours();
			if($h-> updateHours($_POST,$id)){
				echo json_encode(array('success'=>1));
			}else{
				echo json_encode(array('success'=>0));
			}
		}

		public function delete($id)
		{
			$h = new Hours();
			if($h-> deleteHours($id)){
				echo json_encode(array('success'=>1));
			}else{
				echo json_encode(array('success'=>0));
			}
		}
		public function updateForm($id){
			$h = new Hours();
			$form = $h-> getUpdateHourForm($id);
			echo json_encode(array('form' =>$form));
		}

		public function getuseraddform($id)
		{	
			$h = new Hours();
			$form =  $h->userHourForm($id);
			echo json_encode(array('form'=>$form)) ;
		}


		public function approve($id)
		{	
			$h = new Hours();
			if ($h-> approveHours($id)) {
				echo json_encode(array('success'=> 1));
			}else{
				echo json_encode(array('success'=> 0));
			}
			
			
		}

		
	}
 ?>