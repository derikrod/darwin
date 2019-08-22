<?php  
	/**
	 * 
	 */
	class Call2 extends model
	{
		public function getCall($id)
		{
			$description = '<p>Nenhum chamado aberto</p><p>&nbsp;</p>';
			$status = '';
			$this-> query('SELECT * FROM calls2 WHERE caller= '.$id.' ORDER BY id DESC LIMIT 1');

			foreach ($this->result() as $key => $value) {
				$description = '<b>Ultimo chamado</b>: '. $value['txt_motivation'];
				$status = '<b>Status:</b> '. $this->getStatus($value['sel_callstatus']);
			}


			return "<p>".$description." </p> <p>".$status."</p>";

		}

		public function getAdminCall()
		{
			$description = '<p>Nenhum chamado aberto</p><p>&nbsp;</p>';
			$status = '';
			$number = 0;
			$sql = 'SELECT * FROM calls2 WHERE sel_callstatus = 1';

			$this-> query($sql);

			$number = $this->numRows();

			$sql .= ' ORDER BY id DESC LIMIT 1';
			$this->query($sql);	
			foreach ($this->result() as $key => $value) {
				$description = '<b>Numero de chamados em aberto</b>: '. $number;
				$status = '<b>Último chamado:</b> '. $value['txt_motivation'];
			}


			return "<p>".$description." </p> <p>".$status."</p>";

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
			$table = $this-> createTable('calls2',array('caller'=>$iduser,'sel_callstatus'=>1),'AND',true,array('lgt_resolution','sponsor','caller'));
			return '<div class="col-xs-10 col-xs-offset-1 module-div" ><h3 class="text-center">Lista de Chamados</h3>'. $table."</div>";
		}
		function addCall($data){
			$this -> insert('calls2',$data);
			return true;
		}

		public function updateUserForm($idcall)
		{
			$iduser = $_COOKIE['intra_user'];
			$form = $this-> createForm('calls2','CADASTRAR',$idcall,array('lgt_resolution' => "",'sponsor'=> 0,'caller'=> $iduser,'sel_callstatus'=>1,'dat_date'=>date('Y-m-d H:i:s')));
			return $form;
		}

		public function updateCall($data,$id)
		{
			$this -> update('calls2',$data,array('id' => $id ));
			return true;
		}

		//delete
		public function deleteCall($id)
		{
			$this -> delete('calls2',array('id'=>$id));
			return true;
		}

		function getUserForm($iduser){
			$form = $this-> createForm('calls2','CADASTRAR',0,array('lgt_resolution' => "",'sponsor'=> 0,'caller'=> $iduser,'sel_callstatus'=>1,'dat_date'=>date('Y-m-d H:i:s')));
			return utf8_encode($form);
		}
		//loaduserModule
		public function loadCallsModule($idmodule,$iduser)
	 	{
	 		$callsmodule = "";
		
				if (!$this->check_modules($idmodule,$iduser) || $this->getCity($iduser) != 2) {
					return $callsmodule;
				}else{
					$callsmodule = '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                  <div class="col-xs-12 mymodule">
                  <div class="row module-card" style="background-image:url(\''.BASE_URL.'/assets/images/calls.png\');background-position:center center;background-size:cover;">
                        
                  </div>
                  <div class="row">
                    
                    <div class="module-buttons">
                      <p class="module-title"><b>Chamados da TI Indaiatuba</b></p>
                      '.$this-> getCall($iduser).'
                      <p class="text-right"><a href="'.BASE_URL.'/calls2" class="btn btn-success">Lista de chamados</a> &nbsp;&nbsp;<a href="#"  id="newcall2_btn" class="btn btn-primary" data-path="'.BASE_URL.'" data-id="'.$iduser.'">NOVO CHAMADO</a></p>
										</div>
                    </div>
                  </div>              
                  </div>
                </div>';

					return $callsmodule;
				}
	 	}


	 	//loadAdminmodule
	 	public function loadAdminCallsModule($idmodule,$iduser)
	 	{
	 		$callsmodule = "";
		
				if (!$this->check_modules($idmodule,$iduser) || $this->getCity($iduser) != 2) {
					return $callsmodule;
				}else{
					$callsmodule = '
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                  <div class="col-xs-12 mymodule">
                  	<div class="row module-card" style="background-image:url(\''.BASE_URL.'/assets/images/admincalls.png\');background-position:center center;background-size:cover;">                        
                  	</div>
                  <div class="row">
                    
                    <div class="module-buttons">
                      <p class="module-title"><b>Chamados da TI Indaiatuba(Administração)</b></p>
                      '.$this-> getAdminCall().'
                      <p class="text-right"><a href="'.BASE_URL.'/calls2/admin/1" class="btn btn-success">CHAMADOS</a>
										<a href="'.BASE_URL.'/calls2/admin/2" class="btn btn-primary">HISTÓRICO</a></div>
                    </div>
                  </div>              
                  </div>
                ';

					return $callsmodule;
				}
	 	}

	 	public function adminTable()
	 	{	
	 		return '<div id="admin_unsolvedcalls2_div" class="col-xs-10 col-xs-offset-1 module-div"><h3 class="text-center"> Lista de pendências</h3><p class="text-right"><a href="'.BASE_URL.'/calls2/admin/2"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Biblioteca de chamados</a></p>'.
	 		$this -> createTable('calls2',array('sel_callstatus'=> 2), 'AND', false, array('lgt_resolution','caller','sponsor'),'<>')
	 		.'</div>';
	 	}

	 	public function adminLibrary()
	 	{	return '<div id="admin_solvedcalls2_div" class="col-xs-10 col-xs-offset-1 module-div"><h3 class="text-center"> Chamados Resolvidos</h3><p class="text-right"><a href="'.BASE_URL.'/calls2/admin/1"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Chamdos Pendentes</a></p>'.
	 		$this -> createTable('calls2',array('sel_callstatus'=> 2), 'AND', false,array('lgt_resolution','caller'))  
	 		.'</div>';
	 	}

	 	public function getUserName($iduser)
	 	{
	 		$this -> query('SELECT * FROM users WHERE id='.$iduser);
	 		$username= "";
	 		foreach ($this->result() as $key => $value) {
	 			$username= $value['txt_name'];
	 			# code...
	 		}

	 		return $username;
	 	}

	 	public function getUpdateStatusForm($idcall)
	 	{	$this -> query("SELECT * FROM calls2 WHERE id = ".$idcall);
	 		$motivation = "";
	 		foreach ($this-> result() as $key => $value) {
	 			$motivation = "<p><b>Motivo do chamado:</b>".$value['txt_motivation']."</p>";
	 		}
	 		$form = $motivation;
	 		$form .= $this -> getSmForm(array('sel_callstatus','lgt_resolution'),'calls','ATUALIZAR','updatecallstatus',array('id'=>$idcall));
	 		return $form;

	 	}


	 	public function setUpdateStatus($data)
	 	{	$data['sponsor'] = $this-> getUserName($_COOKIE['intra_user']);
	 		$this -> update('calls2',$data,array('id'=> $data['id']));
	 	}


	 	public function getRelatory($id)
	 	{
	 		$this -> query('SELECT * FROM calls2 WHERE id ='.$id);
	 		$relatory = "";
	 		foreach ($this-> result() as $key => $value) {
	 			$relatory = "<p><b>Usuário com problemas: </b> ".$this-> getUserName($value['sel_users'])."</p>
	 						<p><b>Motivo: </b> ".$value['txt_motivation']."</p>
	 						<p><b>Descrição :</b> ".$value['lgt_desc']."</p>
	 						<p><b>Responsável pela resolução: </b> ".$value['sponsor']."</p>
	 						<p><b>Resolução:</b> ".$value['lgt_resolution']."</p>
	 						<br><br>";
	 		}

	 		return $relatory;

	 	}
	}

?>