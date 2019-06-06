<?php  
	/**
	 * 
	 */
	class Call extends model
	{
		public function getCall($id)
		{
			$description = 'Nenhum chamado aberto';
			$status = '';
			$this-> query('SELECT * FROM calls WHERE caller= '.$id.' ORDER BY id DESC LIMIT 1');

			foreach ($this->result() as $key => $value) {
				$description = '<b>Ultimo chamado</b>:'. $value['txt_motivation'];
				$status = '<b>Status:</b>'. $this->getStatus($value['sel_callstatus']);
			}


			return "<br><p>".$description." </p> <p>".$status."</p>";

		}

		public function getStatus($id)
		{
			$this-> query('SELECT * FROM callstatus WHERE id ='.$id);
			foreach ($this-> result() as $key => $value) {
				$name = $value['txt_name'];
			}

			return $name;
		}

		function getUserTable($iduser){
			$table = $this-> createTable('calls',array('caller'=>$iduser,'sel_callstatus'=>1),'AND',true,array('lgt_resolution','sponsor','caller'));
			return '<div class="col-xs-10 col-xs-offset-1 module-div" ><h3 class="text-center">Lista de Chamados</h3>'. $table."</div>";
		}
		function addCall($data){
			$this -> insert('calls',$data);
			return true;
		}

		public function updateUserForm($idcall)
		{
			$iduser = $_COOKIE['intra_user'];
			$form = $this-> createForm('calls','CADASTRAR',$idcall,array('lgt_resolution' => "",'sponsor'=> 0,'caller'=> $iduser,'sel_callstatus'=>1,'dat_date'=>date('Y-m-d H:i:s')));
			return $form;
		}

		public function updateCall($data,$id)
		{
			$this -> update('calls',$data,array('id' => $id ));
			return true;
		}

		//delete
		public function deleteCall($id)
		{
			$this -> delete('calls',array('id'=>$id));
			return true;
		}

		function getUserForm($iduser){
			$form = $this-> createForm('calls','CADASTRAR',0,array('lgt_resolution' => "",'sponsor'=> 0,'caller'=> $iduser,'sel_callstatus'=>1,'dat_date'=>date('Y-m-d H:i:s')));
			return $form;
		}
		//loaduserModule
		public function loadCallsModule($idmodule,$iduser)
	 	{
	 		$hoursmodule = "";
		
				if (!$this->check_modules($idmodule,$iduser)) {
					return $contactmodule;
				}else{
					$contactmodule = '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
										
										<div class="col-xs-12 module-div">
											<br><h3>Lista de Chamados</h3>
											'.$this-> getCall($iduser).'
											<br>
									<hr>
									<p class="text-right"><a href="'.BASE_URL.'/calls" class="btn btn-success">Lista de chamados</a> &nbsp;&nbsp;<a href="#"  id="newcall_btn" class="btn btn-primary" data-path="'.BASE_URL.'" data-id="'.$iduser.'">NOVO CHAMADO</a></p>
										</div>
								  </div>';

					return $contactmodule;
				}
	 	}

	}

?>