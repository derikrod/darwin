<?php 
	/**
	 * Classe respnsável por controlar os atrasos
	 */
	class Late extends Model
	{
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
							'.$this-> createTable('lates') .'
						</div>
					</div>';
			return $html;
		}

		public function getLateForm()
		{
			return $this-> createForm('lates','Adicionar');
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
		public function updateForm($id){
			$l = new Late();
			echo json_encode(array('form' =>$l-> getUpdateLateForm($id)));
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
			return $this -> createForm('lates', 'Atualizar',$id);
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
	}
 ?>