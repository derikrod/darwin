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


		public function getLoginForm($fields = array(),$table,$submit_text)
		{
			return $this->getSmForm($fields,$table,$submit_text);
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
			if ($this->result()>0) {
				return true;
			}else{
				return false;
			}	
		}
	}
 ?>