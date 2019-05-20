<?php 
	/**
	 * Classe respnsável por controlar os atrasos
	 */
	class Late extends Model
	{
		

		public function getLateForm()
		{
			return $this-> createForm('lates','Adicionar',0, array('sel_latestatus' =>1 ));
		}
		private function hoursToMinutes($time)
		{	
			$timesplit = explode(':', $time);
			$minutes = (intval($timesplit[0])*60)+intval($timesplit[1]);
			return $minutes;
		}

		private function getLates($id){
			$this -> query('SELECT * FROM users WHERE id = '.$id);
			$lates = "";
			foreach ($this-> result() as $key => $value) {
				$lates = $value['hrs_negativehours'];
			}

			return $this-> hoursToMinutes($lates);
		}
		private function minutesToHours($minutes){
			return str_pad(floor($minutes/60), 2, "0", STR_PAD_LEFT).":". str_pad($minutes%60, 2, "0", STR_PAD_LEFT);
		}
		public function addLate($data)
		{
			$lates = $this -> getLates($data['sel_users']) + $this->hoursToMinutes($data['hrs_hours']);
			$this-> update('users', array('hrs_negativehours' =>$this->minutesToHours($lates)),array('id'=>$data['sel_users']));
		
			$this-> insert('lates',$data);

			return true;	
		}
	
		public function getHours($id)
		{
		  $hours = 0;
		  $this -> query('SELECT * FROM users WHERE id IN (SELECT sel_users FROM lates WHERE id = '.$id.')');
		  foreach ($this->result() as $key => $value) {
		  		$hours = $value['hrs_hours'];
		  }

		  return $hours;
		}			
		public function updateLate($data,$id)
		{
			$this-> query('SELECT * FROM users WHERE id = '.$data['sel_users']);
			$late = 0;
			foreach ($this-> result() as $key => $value) {
				$late = $this->hoursToMinutes($value['hrs_negativehours']);
			}
			$this-> query("SELECT * FROM lates WHERE id = ".$id);
			foreach ($this->result() as $key => $value) {
				$oldhours = $this-> hoursToMinutes($value['hrs_hours']);
			}

			$hours = $late - $oldhours;

			$hours = $hours + $this-> hoursToMinutes($data['hrs_hours']);

			$hours = $this->minutesToHours($hours);

			$this-> update('users',array('hrs_negativehours' => $hours),array('id'=>$data['sel_users']));
			$this-> update('lates',$data,array('id'=>$id));


		}
		
		public function getUpdateLateForm($id)
		{
			return $this -> createForm('lates', 'Atualizar',$id,array('sel_latestatus'=>1));
		}


		public function deleteLate($id)
		{
			$this-> query('SELECT * FROM users WHERE id IN (SELECT sel_users FROM lates WHERE id = '.$id.');');
			$late = 0;
			$iduser = 0;
			foreach ($this->result() as $key => $value) {
				$late = $this->hoursToMinutes($value['hrs_negativehours']);
				$iduser = $value['id'];
			}

			$this-> query('SELECT * FROM lates WHERE id = '.$id);
			$oldhours = 0;

			foreach ($this->result() as $key => $value) {
				$oldhours = $this->hoursToMinutes($value['hrs_hours']);
			}

			$hours = $late - $oldhours;

			$hours = $this->minutesToHours($hours);

			$this-> update('users',array('hrs_negativehours'=> $hours),array('id'=> $iduser));
			$this-> delete('lates',array('id'=>$id));

		}

		public function useHour($id)
		{
			
			$iduser = 0;
			$late = 0;
			$users_hours = 0;
			$this-> query('SELECT * FROM lates WHERE id = '.$id);
			//1.pegar atrasos
			foreach ($this->result() as $value) {
				$iduser = $value['sel_users'];
				$late = $this->hoursToMinutes($value["hrs_hours"]);
			}

			//2.conseguir horas extras compensações e 
			$this -> query('SELECT * FROM users WHERE id ='.$iduser);
			foreach ($this->result() as $key => $value) {
				$user_hours = $this->hoursToMinutes($value['hrs_hours']); 
				$negative = $this->hoursToMinutes($value['hrs_negativehours']);
			}

			$total = $user_hours - $late;
			$total_negative = $negative - $late;

			if ($total < 0) {
				return false;
			}else{
			    $this -> update('users', array('hrs_hours'=>$this->minutesToHours($total),'hrs_negativehours'=>$this->minutesToHours($total_negative)),array('id' => $iduser));
			    $this-> update('lates',array('sel_latestatus'=>2),array('id'=> $id));
			    return true;
			}
		}


		public function useMoney($id)
		{
			
			$iduser = 0;
			$late = 0;
			$users_hours = 0;
			$this-> query('SELECT * FROM lates WHERE id = '.$id);
			//1.pegar atrasos
			foreach ($this->result() as $value) {
				$iduser = $value['sel_users'];
				$late = $this->hoursToMinutes($value["hrs_hours"]);
			}

			//2.conseguir horas extras compensações e 
			$this -> query('SELECT * FROM users WHERE id ='.$iduser);
			foreach ($this->result() as $key => $value) {
				$user_hours = $this->hoursToMinutes($value['hrs_hours']); 
				$negative = $this->hoursToMinutes($value['hrs_negativehours']);
			}

			$total_negative = $negative - $late;

			 $this -> update('users', array('hrs_negativehours'=>$this->minutesToHours($total_negative)),array('id' => $iduser));
		    	$this-> update('lates',array('sel_latestatus'=>3),array('id'=> $id));
			    return true;
		}	

		//modules
		public function listUserLates($id)
		{
			$html = '<div class="row module-div">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><h3 class="text-center">Banco de Horas</h3><p class="text-center">Lista de atrasos</p>
					
							'.$this-> createTable('lates',array('sel_users' =>$id),'AND',false) .'
						</div>
					</div>';
			return $html;
		}

		public function listAdminLates()
		{
			$html = '<div class="row module-div">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><h3 class="text-center">Banco de Horas</h3><p class="text-center">Lista de atrasos</p>
							<p class="text-center">
							<button type="button" data-path="'.BASE_URL.'" data-iduser="'.$_COOKIE['intra_user'].'" id="add_late_btn" class="btn btn-primary">Novo registro de atraso ou falta</button>
							</p>
							'.$this-> createTable('lates',array('sel_latestatus'=>1),'AND',true,array('sel_latestatus')) .'
						</div>
					</div>';
			return $html;
		}		
	}
 ?>