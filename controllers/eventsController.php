<?php 
	class eventsController extends controller{
		public function index($month = "",$year = "")
		{	

			if ($month == "") {
				$month = date('m');
			}

			if ($year == "") {
				$year = date('Y');
			}
			$u = new User();
			$e = new Event();
			$c = new Calendar();
			if (isset($_COOKIE["intra_user"])&& !empty($_COOKIE["intra_user"])) {
				$dados =  array();
				foreach ($u-> getUserInformation($_COOKIE["intra_user"]) as $key => $value) {
					$username = $value["txt_name"];
				}
				$dados["name"] = $username;
				$dados["eventmodule"] = $c-> ShowCalendars($month,$year);
				$this->loadTemplate('main',$dados);
			}else{
				$dados = array(
				'form'=> $u-> getLoginForm( array('txt_login','psw_pass'),'users','Entrar','login')
				);
				$this->loadTemplate('home',$dados);
			}
			
		}

		public function getaddform($id,$date ='')
		{
			$e = new Event();
			
			echo json_encode( array('form' => $e->getAddEventForm($id), 'date'=> $date));
		}

		public function addevents()
		{
			$e = new Event();
			$e-> addEvent($_POST); 
		}
	}
 ?>