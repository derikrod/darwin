<?php  
	/**
	 * 
	 */
	class Calls extends model
	{
		public function getCall($id)
		{
			$this-> query('SELECT * FROM calls WHERE sel_users= '.$id.' ORDER BY id DESC LIMIT 1');

			foreach ($this->result() as $key => $value) {
				$description = $value['lgt_desc'];
				$status = $this->getStatus($value['sel_callstatus']);
			}


			return "<p>Ultimo chamado: ".$description." <br> Status: ".$status."</p>";

		}

		public function getStatus($id)
		{
			$this-> query('SELECT * FROM callstatus WHERE id ='.$id);
			foreach ($this-> result() as $key => $value) {
				$name = $value['txt_name'];
			}

			return $name;
		}


		public function loadCallsModule($idmodule,$iduser)
	 	{
	 		$hoursmodule = "";
		
				if (!$this->check_modules($idmodule,$iduser)) {
					return $contactmodule;
				}else{
					$contactmodule = '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
										
										<div class="col-xs-12 module-div">
											<h3>Lista de Chamados</h3>
											'.$this-> getCall($iduser).'
										</div>
								  </div>';

					return $contactmodule;
				}
	 	}

	}

?>