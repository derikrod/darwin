<?php 
	/**
	 * 
	 */
	class User extends model
	{
		public function getUserForm()
		{
			return $this -> createForm('users', 'Cadastrar');
		}

		public function getUpdateUserForm($id)
		{
			return $this -> createForm('users', 'Atualizar',$id);
		}


		public function getLoginForm($fields = array(),$table,$submit_text,$form_name)
		{
			return $this->getSmForm($fields,$table,$submit_text,$form_name);
		}

		public function log($table,$data = array())
		{
			$fields = "";
			foreach ($data as $key => $value) {
				$split_key = explode('_', $key);
				if ($split_key[0] == 'psw') {
					$value = md5($value);
				}
				$data[$key] = $key." = '".$value."'";
			}

			$fields = implode(' AND ', $data);
			$sql  = "SELECT * FROM ".$table." WHERE ".$fields;
			$this -> query($sql);
			if ($this->numRows() > 0) {
				return $sql;
			}else{
				return false;
			}	
		}

		public function getIdByname($name){
			$sql = "SELECT * FROM users WHERE txt_login ='".$name."'";
			$this -> query($sql);
			$id = 0;
			foreach ($this-> result() as $key => $value) {
				$id = $value["id"];			
			}
			return $id;
		}

		public function getUserInformation($id){
			$sql = "SELECT * FROM users WHERE id = ".$id;
			$this-> query($sql);
			return $this-> result();
		}
		public function count_users()
		{
			$this-> query("SELECT * FROM users");
			return $this -> numRows();
		}
	
		//create
		public function addUser($data)
		{
			$this-> insert('users',$data);
			return true;
		}

		

		
		//read
		public function loadUserTable(){
			$user_table = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ">
			
										<div class="col-xs-12 module-div" style="overflow-x:scroll;><h3 class="text-center">Lista de usuários <a href="#" id="add_user_btn" data-path="'.BASE_URL.'"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></a></h3>'.$this -> createTable('users').'</div>
								  </div>';
			return $user_table;
		}
		//update
		public function updateUser($data,$id)
		{
			$this -> update('users',$data,array('id' => $id ));
			return true;
		}
		
		//delete
		public function deleteUser($id)
		{
			$this -> delete('users',array('id'=>$id));
			return true;
		}
		//load module
		public function loadUserModule($idmodule,$iduser )
		{				
			$usermodule = "";
			if (!$this->check_modules($idmodule,$iduser)) {
				return $usermodule;
			}else{
				$usermodule = '
							<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="col-xs-12 mymodule">
									<div class="row module-card" style="background-image:url(\''.BASE_URL.'/assets/images/users.png\')">
												
									</div>
									<div class="row">
										
										<div class="module-buttons">
											<p class="module-title"><b>Usuários</b></p>
											<p><b>Número de usuários cadastrados: </b> '.$this-> count_users().'</p>
											<p>&nbsp;</p>
											<p class="text-right"><a href="'.BASE_URL.'/users" class="btn btn-success">Lista de usuários</a></p>
										</div>
									</div>							
									</div>
							  </div>';

				return $usermodule;
			}
		}
			
	}
 ?>