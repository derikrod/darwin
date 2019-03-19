<?php 
	/**
	 * 
	 */
	class Event extends model
	{	
		//create form
		public function getAddEventForm($iduser)
		{
			return $this-> createForm('events','Criar Evento',0, array('non_users' => $iduser));
		}
		//create table
		//count events
		public function count_events($iduser)
		{
			$this ->query("SELECT * FROM events WHERE non_users = ".$iduser." AND non_status = 1 ;" );
			return $this -> numRows();
		}

		private function ptbrdate($date)
		{
			$split_date = explode('-', $date);
			return $split_date[2]."/".$split_date[1]."/".$split_date[0];
		}

			public function checkEvent($iduser,$date_start,$date_end)
		{
			$event_list = "";
			$has_results = false;
			$this -> query("SELECT * FROM events WHERE non_users = ".$iduser." AND '".$date_start."' BETWEEN dat_startdate AND dat_enddate");
			if ($this-> numRows() > 0) {
				$has_results = true;
				foreach ($this-> result() as $key => $value) {
					$event_list .= "<p>".$this-> ptbrdate($value['dat_startdate'])." ".utf8_encode($value["txt_name"])."</p>";
				}
			}

			$this -> query("SELECT * FROM events WHERE non_users = ".$iduser." AND '".$date_end."' BETWEEN dat_startdate AND dat_enddate");
			if ($this-> numRows() > 0) {
				$has_results = true;
				foreach ($this-> result() as $key => $value) {
					$event_list .= "<p>".$this-> ptbrdate($value['dat_startdate'])." ".utf8_encode($value["txt_name"])."</p>";
				}
			}

			return  array('events' => $has_results, 'list' = $event_list);
		}
		

		public function addEvent($data)
		{
			$this-> insert('events',$data);
		}
		//load module
		public function loadEventModule($idmodule,$iduser )
		{				
			$usermodule = "";
			if (!$this->check_modules($idmodule,$iduser)) {
				return $usermodule;
			}else{
				$eventmodule = '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="col-xs-12 module-div">
										<br><h3>Eventos</h3><br>
										<p><b>Eventos em aberto: </b> '.$this-> count_events($iduser).'</p>
										<br>
										<hr>
										<p class="text-right"><a href="'.BASE_URL.'/events" class="btn btn-success">Lista de eventos</a></p>
									</div>
							  </div>';

				return $eventmodule;
			}
		}
	
	}

 ?>