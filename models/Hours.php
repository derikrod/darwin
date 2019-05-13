<?php  
	Class Hours Extends model{
		public function hoursForm()
		{
			return $this-> createForm('hours','Cadastrar');
		}

		public function getExtras($id)
		{
			$this -> query("SELECT * FROM users WHERE id =".$id);
			$extras = "";
			foreach ($this-> result() as $key => $value) {
				$extras = $value['hrs_hours'];
			}
		}

		public function hoursToMinutes($time)
		{
			$t = explode(':', $time);
			$minutes = (intval($t[0])*60)+$t[1];
			return $minutes;

		}

		private function minutesToHours($time)
		{
			$hours = floor($time/60);
			$minutes = $time%60;
			return $hours.":".$minutes;

		}


		public function weekday($mydate)//format Y-m-d
		{	
			$split = explode('-', $mydate);
			$weekday = jddayofweek( cal_to_jd(CAL_GREGORIAN, $split[1],$split[2],$split[0]) , 0 );
			return $weekday;
		}

		 private function getHolidays($ano){
	      $dia = 86400;
	      $datas = array();
	      $datas['pascoa'] = easter_date($ano);
	      $datas['sexta_santa'] = $datas['pascoa'] - (2 * $dia);
	      $datas['carnaval'] = $datas['pascoa'] - (47 * $dia);
	      $datas['corpus_cristi'] = $datas['pascoa'] + (60 * $dia);
	      $feriados = array (
	            'Ano novo' => $ano.'-01-01',
	             'Anivesário de São Paulo' => $ano.'-01-25',//aniversário
	              'Carnaval'=> $ano.'-'.date('m-d',$datas['carnaval']),
	              'Sexta feira santa' =>   $ano.'-'.date('m-d',$datas['sexta_santa']),
	                 'Páscoa' => $ano.'-'.date('m-d',$datas['pascoa']),
	                  'Tiradentes' => $ano.'-04-21',
	                  'Dia do trabalho' => $ano.'-05-01',
	                  'Corpus Cristi' => $ano.'-'.date('m-d',$datas['corpus_cristi']),
	                  'Revolução constitucionalista' => $ano.'-07-09',
	                  'Independência do Brasil'=> $ano.'-09-07',
	                  'Nossa senhora de aparecida' => $ano.'-10-12',
	                  'Finados' => $ano.'-11-02',
	                  'Proclamação da República' =>$ano.'-11-15',
	                  'Dia da conciência negra' => $ano.'-11-20',
	                  'Natal' =>$ano.'-12-25',
	               );
	      return $feriados;
	  	 }

	  	 public function ptbrdate($date)
	  	 {
	  	 	return date("d/m/Y", strtotime($date));
	  	 }
	  	 public function compareHoliday($mydate)//format Y-m-d
	  	 {
	  	 	$split = explode('-', $mydate);
	  	 	$isholiday = false;
	  	 	$holidayname = "";
	  	 	foreach ($this-> getHolidays($split[0]) as $key => $value) {
	  	 		if (strtotime($mydate) == strtotime($value)) {
	  	 			$holidayname = $key;
	  	 		}
	  	 	}
	  	 	
	  	 	return $holidayname;
	  	 

	  	 }
		public function getDayName($date)
		{
			$name ="";
			$res = $this->compareHoliday($date);
			
				if ($res != "") {
					$name= 'Feriado '.$res;	
					return $name;# code...
				}
				
				switch ($this->weekday($date)) {
					case 0:
						$name = "Domingo";
						break;
					case 1:
						$name = "Segunda Feira";
						break;
					case 2:
						$name = "Terça Feira";
						break;		
					case 3:
						$name = "Quarta Feira";
						break;
					case 4:
						$name = "Quinta Feira";
						break;
					case 5:
						$name = "Sexta Feira";
						break;
					case 6:
						$name = "Sábado";
						break;			
					
				}

				return $name;

 
		}

		public function calcHours($time,$date)
		{
			$hours = 0;
			$seconds = 0;

			$weekday = $this-> weekday($date);
			$minutes = $this-> hoursToMinutes($time);
			if ($weekday == 0 || $this->compareHoliday($date) != "" ) {
				$minutes = intval($minutes) *2;
				return floor($minutes/60).":".str_pad(($minutes%60), 2, '0', STR_PAD_LEFT).":00 (+100%)";
			}else{
				
				$fifthpercent = 0;
				if($minutes%2 != 0){
					$seconds = $minutes*60;

					$seconds = $seconds/2;

					$minutes =$minutes + floor($seconds/60);
					$seconds = $seconds%60;
					$hours = floor($minutes/60).":".str_pad(($minutes%60), 2, '0', STR_PAD_LEFT).":".str_pad($seconds, 2, '0', STR_PAD_LEFT)." (+50%)";
					return $hours;
				}else{
					$fifthpercent = $minutes/2;
					$minutes = $minutes + $fifthpercent;
					$hours = $hour = floor($minutes/60).":".str_pad(($minutes%60), 2, '0', STR_PAD_LEFT).":00 (+50%)";
					return $hours;
				}
			}
		}

		public function getPercents($date){
			
			$percents = 0;
			$res = $this->compareHoliday($date);
			
				if ($res != "") {
					$percents = 100;
				}
				
				switch ($this->weekday($date)) {
					case 0:
						$percents = 100;
						break;
					case 1:
						$percents = 50;
						break;
					case 2:
						$percents = 50;
						break;		
					case 3:
						$percents = 50;
						break;
					case 4:
						$percents = 50;
						break;
					case 5:
						$percents = 50;
						break;
					case 6:
						$percents = 50;
						break;			
					
				}

				return $percents;
			
		}

		public function getUpdateHourForm($id)
		{
			return $this -> createForm('hours', 'Atualizar',$id);
		}


		public function insertHours($data)
		{
			$this-> insert('hours',$data);
		}

		public function isNegative($id)
		{
			$this-> query('SELECT * FROM users WHERE id ='.$id);
			$hours = "";
			foreach ($this-> result() as $key => $value) {
				$hours = $value['hrs_negativehours'];
			}

			if ($this->hoursToMinutes($hours)> 0) {
				return true;
			}else{
				return false;
			}
		}


		public function listHours($id)
		{	
			$lates = 0;
			if ($this-> isNegative($id)) {
				$lates = 1;
			}
			$html = '<div class="row module-div">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><h3 class="text-center">Banco de Horas</h3><p class="text-center">Lista de horas aprovadas</p>
						<p class="text-center">
							<button type="button" data-path="'.BASE_URL.'" data-iduser="'.$_COOKIE['intra_user'].'" id="add_bh_btn" data-lates="'.$lates.'" class="btn btn-primary">Novo formulário de banco de horas</button>
						</p>
							'.$this-> createTable('hours',array('sel_users' =>$id),'AND',false) .'

						</div>
					</div>';
			return $html;
		}
		public function listAdminHours()
		{
			$html = '<div class="row module-div">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><h3 class="text-center">Banco de Horas</h3><p class="text-center">Lista de horas </p>
						<p class="text-center">
						
							'.$this-> createTable('hours',array('sel_bhstatus' => 1),'AND',true,array('sel_bhstatus')) .'
						</div>
					</div>';
			return $html;
		}
		public function getUser($id)
		{
			$this-> query('SELECT * FROM users WHERE id = '. $id);
			$user = "";
			foreach ($this-> result() as  $value) {
				$user = $value["txt_name"];
			}
			return $user;
		}
		public function updateHours($data,$id)
		{
			$this->update('hours',$data,array('id'=>$id));
			return true;
		}

		//delete
		public function deleteHours($id)
		{
			$this -> delete('hours',array('id'=>$id));
			return true;
		}

		//auxiliares
		public function getCompany($id)
		{
			$this-> query('SELECT * FROM companies WHERE id IN (SELECT sel_companies FROM users WHERE id = '.$id.')');
			return $this->result();
		}

		public function getDepartment($id){
			$this-> query('SELECT * FROM departments WHERE id IN (SELECT sel_departments FROM users WHERE id ='.$id.')');
			$department = "";
			foreach ($this-> result() as $key => $value) {
				$department = $value['txt_name'];
			}

			return $department;
		}




		public function getBoss($id)
		{
			$this-> query('SELECT * FROM users WHERE id IN (SELECT sel_users FROM users WHERE id = '.$id.')');
			$boss = "";
			foreach ($this-> result() as $key => $value) {
				$boss = $value['txt_name'];
			}
			return $boss;
		}
		//auxiliares
		public function userHourForm($id)
		{
			# code...
			$this-> query('SELECT * FROM users WHERE id ='.$id);
			foreach ($this-> result() as $key => $value) {
				$form = $this-> getSmForm(array('sel_bhtypes','hrs_hours','dat_hourdate','txt_motivation','txt_locale','lgt_desc'),'hours','Gerar Formulário','bh_pdf',array('sel_users'=> $id));
				return $form;
			}
		}
		public function getType($type)
		{
			$this ->query('SELECT * FROM bhtypes WHERE id ='.$type);
			$type = "";
			foreach ($this-> result() as $key => $value) {
				$type = $value["txt_name"];
			}
			return $type;
		}
		public function getTitle($id)
		{
			$this-> query('SELECT * FROM users WHERE id = '. $id);
			$title = "";
			foreach ($this-> result() as  $value) {
				$title = $value["txt_title"];
			}
			return $title;
		}

		public function getPositiveHours($id)
		{
			$this-> query('SELECT * FROM users WHERE id ='.$id);
			$hours = "";
			foreach ($this-> result() as $key => $value) {
				$hours = $value['hrs_hours'];
			}

			return $hours;
		}

		
		public function getNegative($id)
		{
			$this-> query('SELECT * FROM users WHERE id ='.$id);
			$hours = "";
			foreach ($this-> result() as $key => $value) {
				$hours = $value['hrs_negativehours'];
			}

			return $hours;
		}

		public function approveHours($id)
		{
			$iduser = 0;
			$negative = 0;
			$hours = 0;
			$this -> query("SELECT * FROM hours WHERE id =".$id);
			foreach ($this-> result() as $key => $value) {
				$iduser = $value["sel_users"];
				$hours = $value["hrs_hours"];
			}
			$this->query('SELECT * FROM users WHERE id ='.$iduser);
			foreach ($this->result() as $key => $value) {
				$negative = $value['hrs_negativehours'];
			}

			$total = $this-> hoursToMinutes($negative) - $this-> hoursToMinutes($hours);

			if ($total < 0 ) {
				$total = -($total);
				$total = $this->minutesToHours($total);
				$this->update('users',array('hrs_negativehours' =>'00:00','hrs_hours'=> $total),array('id'=> $iduser));
				$this->update('hours',array('sel_bhstatus' =>2),array('id'=>$id));
			}else{
				$total = $this->minutesToHours($total);
				$this->update('users',array('hrs_negativehours'=>$total), array('id' =>$iduser));
				$this->update('hours',array('sel_bhstatus'=>2),array('id'=>$id));
			}


			return true;

		}

		//load modules
		public function loadUserHoursModule($idmodule,$iduser)
		{
			$hoursmodule = "";
	
			if (!$this->check_modules($idmodule,$iduser)) {
				return $hoursmodule;
			}else{
				$hoursmodule = '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="col-xs-12 module-div">
										<br><h3>Banco de Horas</h3><br>
										<p><b>Horas extras</b> '.$this-> getPositiveHours($iduser).'</p>
										<p><b>Horas negativas</b> '.$this-> getNegative($iduser).'</p>
										<br>
										<hr>
										<p class="text-right"><a href="'.BASE_URL.'/hours" class="btn btn-success">Banco de horas</a>&nbsp;&nbsp;<a href="'.BASE_URL.'/lates" class="btn btn-danger">Meus Atrasos</a></p>
									</div>
							  </div>';

				return $hoursmodule;
			}
			
		}

		public function loadAdminHoursModule($idmodule,$iduser)
		{
			$hoursmodule = "";
	
			if (!$this->check_modules($idmodule,$iduser)) {
				return $hoursmodule;
			}else{
				$hoursmodule = '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="col-xs-12 module-div">
										<br><h3>Banco de Horas (administração)</h3><br>
										<br>
										<br>
										<br>
										<br>
										<hr>
										<p class="text-right"><a href="'.BASE_URL.'/hours/admin" class="btn btn-success">Banco de horas</a>&nbsp;&nbsp;<a href="'.BASE_URL.'/lates/admin" class="btn btn-danger">Cadastrar Atrasos</a></p>
									</div>
							  </div>';

				return $hoursmodule;
			}
		}
	}

?>