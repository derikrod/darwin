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

		public function compareevent($id,$startdate,$enddate){
			$e = new Event();
			$res = $e -> checkEvent($id,$startdate,$enddate);
			if ($res["events"]){
				$hidden_form = '<h3 class="text-center">Existem eventos já criados para esse período</h3><div class="row"><div class="col-xs-12">'.$res["list"].'</div></div><form method="post" action="" id="hidden_add_event_form" data-path="'.BASE_URL.'">';
				foreach ($_POST as $key => $value) {
					$hidden_form .= '<input type="hidden" id="'.$key.'" name="'.$key.'" value="'.$value.'">';
				}
				$hidden_form .='<input type="button" value="Cancelar Cadastro" class="btn btn-info reload-btn">&nbsp;&nbsp;<input type="submit" value="Cadastrar Novo Evento" class="btn btn-sucess">
				</form>';
				echo json_encode(array('success' =>1, 'form'=>$hidden_form));
			}else{
				$e = new Event();

				if($e ->addEvent($_POST)){
				echo json_encode(array('success' =>0, 'form'=>'<p>Evento cadastrado</p><input type="button" value="Recarregar página" class="btn btn-succes reload-btn">'));
				}else{
					echo json_encode(array('success' =>0, 'form'=>'<p>Ocorreu um erro inesperado</p><input type="button" value="Recarregar página" class="btn btn-succes reload-btn">'));
				}
			}
		}
		public function openevent($date)
		{
			$e = new Event();
			echo json_encode(array('events'=>$e-> getEvents($_COOKIE["intra_user"],$date)));
		}
		public function add()
		{
			$e = new Event();
			if ($e-> addEvent($_POST)) {
				echo json_encode(array('success' => 1 ));
			}else{
				echo json_encode(array('success' => 0 ));
			}
		}
		
	
	}
 ?>