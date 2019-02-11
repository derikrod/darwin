<?php
class model{
	protected $pdo;
	private $numRows;
	private $array;
	
	public function __construct(){
		global $db;
		$this->pdo = $db;
	}

	public function query($sql) {
		$query = $this->pdo->query($sql);
		$this->numRows = $query->rowCount();
		$this->array = $query->fetchAll();
	}

	public function result() {
		return $this->array;
	}

	public function numRows() {
		return $this->numRows;
	}

	public function insert($table, $data) {
		if(!empty($table) && ( is_array($data) && count($data) > 0 )) {
			$sql = "INSERT INTO ".$table." SET ";
			$dados = array();
			foreach($data as $chave => $valor) {
				$dados[] = $chave." = '".addslashes($valor)."'";
			}
			$sql = $sql.implode(", ", $dados);
			$this->pdo->query($sql);
		}
	}

	public function update($table, $data, $where = array(), $where_cond = "AND") {

		if(!empty($table) && ( is_array($data) && count($data) > 0) && is_array($where)) {
			$sql = "UPDATE ".$table." SET ";
			$dados = array();
			foreach($data as $chave => $valor) {
				$dados[] = $chave." = '".addslashes($valor)."'";
			}
			$sql = $sql.implode(", ", $dados);

			if(count($where) > 0) {
				$dados = array();
				foreach($where as $chave => $valor) {
					$dados[] = $chave." = '".addslashes($valor)."'";
				}
				$sql = $sql." WHERE ".implode(" ".$where_cond." ", $dados);
			}

			$this->pdo->query($sql);
		}

	}

	public function delete($table, $where, $where_cond = "AND") {
		if(!empty($table) && ( is_array($where) && count($where) > 0 )) {
			$sql = "DELETE FROM ".$table;

			if(count($where) > 0) {
				$dados = array();
				foreach($where as $chave => $valor) {
					$dados[] = $chave." = '".addslashes($valor)."'";
				}
				$sql = $sql." WHERE ".implode(" ".$where_cond." ", $dados);
			}

			$this->pdo->query($sql);

		}
	}


	//construtor de formulários
	//1.selects
	private function get_select($table,$key,$required="",$value = 0)
	{
		$this -> query("SELECT * FROM ".$table);
		$select = '<select name="'.$key.'" id="'.$key.'" '.$required.'><option value="">Selecione uma opção.</option>';
		foreach ($this->result() as $key => $value) {
			$select .= 	'<option value="'.$value['id'].'">'.utf8_encode($value['txt_name']).'</option>';
		}

		$select.='</select>';

		return $select;
	}
	//2.checkbox
	private function get_checkbox($table,$name,$required="",$checked = 0){
		$this-> query("SELECT * FROM".$table);
		$checkbox = "";
		$i = 0;
		foreach ($this->result() as $value) {
			$selected = "";
			if ($value["id"] == $checked) {
				$selected = 'checked = "checked"';
			}
			$checkbox .= '<label for="'.$name.$i.'">'.utf8_encode($value['txt_name']).'</label><input type="ceckbox" name="'.$name.'" id="'.$name.$i.'" value="'.$value['id'].'" '.$require.'>';
		}
	}
	//3.radios
	private function get_radio($table,$name,$required="",$checked = 0)
	{
		$this -> query("SELECT * FROM $table");
		$radio = "";
		$selected = "";
		foreach ($this->result() as $key => $value) {
			if ($value['id'] == $checked) {
				$selected = 'checked = "checked"';
			}
			$radio .= '<label for="'.$name.$i.'">'.utf8_encode($value['txt_name']).'</label><input type="radio" name="'.$name.'" id="'.$name.'" '.$selected.' value="'.$value["id"].'" '.$required.'>';
		}

		return $radio;
	}
	//construindo inputs
	private function get_input($key,$name,$required="",$value="")
	{	
		$input  = "";
		switch ($key) {
			case 'txt':
				$input = '<input type="text" id="'.$name.'" name="'.$name.'"  value="'.$value.'" class="form-control" '.$required.'>';
				break;
			case 'psw':
				$input = '<input type="password" id="'.$name.'" name="'.$name.'" value="'.$value.'" class="form-control" '.$required.'>';
				break;
			case 'lgtxt':
				$input = '<textarea name="'.$name.'" id="'.$name.'" cols="30" rows="10" class="form-control" '.$required.'>"'.$value.'"</textarea>';	
				break;
			case 'sel':
				$spliname = explode('_', $name);
				$input = $this-> get_select($spliname[1],$name);	
				break;
			case 'chk':
				$spliname = explode('_', $name);
				$input = $this-> get_checkbox($spliname[1],$name);	
				break;
			case 'rdo':
				$spliname = explode('_', $name);
				$input = $this-> get_radio($spliname[1],$name);	
				break;	
			case 'tel':
				$input = '<input type="text" name="'.$name.'" id="'.$name.'" value="'.$value.'" class="form-control phone" >';	
				break;
			case 'dat':
				$input = '<input type="date" name="'.$name.'" id="'.$name.'" value="'.$value.'" class="form-control date" >';
				break;
			case 'hrs':
				$input = '<input type="text" name ="'.$name.'" id="'.$name.'" value="'.$value.'" class="form-control hours">';
				break;
			default:
				$input = "";
				break;		
		}

		return $input;
	}
	//criando formulário
	public function createForm($table,$submit_text,$id=0)
	{
		$form = "";

		if ($id == 0 ) {
			$sql = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".DB_NAME."' AND TABLE_NAME = '".$table."';";
			$this -> query($sql);
			$form = '<form  id="add_'.$table.'" data-path='.BASE_URL.'>';

			foreach ($this->result() as $key => $value) {
				$required = "";
				if ($value['IS_NULLABLE'] == 'NO') {
					$required = "required";
				}
				$split_key = explode('_', $value['COLUMN_NAME']);
				if ($value['COLUMN_NAME'] != 'id') {
					$form .= '<div class="form-group"><label for="'.$value['COLUMN_NAME'].'">'.utf8_encode($value['COLUMN_COMMENT']).'</label>'.$this->get_input($split_key[0],$value['COLUMN_NAME'],$required).'</div>';
				}	
			}

			$form.='<div class="text-center"><input type="submit" class="btn btn-success" value="'.$submit_text.'"></div></form>';
			return $form;
		}else{
			$sql = "SELECT * FROM ".$table." WHERE id =".$id;
			$this -> query($sql);
			$form = '<form  id="update_'.$table.'">';
			foreach ($this->result() as $key => $value) {
				$split_key = explode('_', $key);
				if ($value['COLUMN_NAME'] != 'id') {	
				$form .= '<div class="form-group"><label for="'.$value['COLUMN_NAME'].'">'.utf8_encode($value['COLUMN_COMMENT']).'</label>"'.$this-> get_input($split_key[0],$value['COLUMN_NAME']).'"</div>';	
				}
			}

			$form.='<div class="text-center"><input type="submit" value="'.$submit_text.'"></div></form>';
			return $form;
		}
		
	}

	//criador de formulários com campos específicos
	public function getSmForm($fields = array(),$table,$submit_text)
		{
			$form = '<form id="login_form" data-path='.BASE_URL.'><span id="error_display"></span>';
			foreach ($fields as $key => $value) {
				$fields[$key] = "COLUMN_NAME = '".$value."'";
			}

			$sql_fields = implode(' OR ', $fields);

			$sql = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'darwin' AND TABLE_NAME = 'users' AND (".$sql_fields.")";

			$this -> query($sql);
			foreach ($this->result() as $key => $value) {
				$required = "";
				if ($value['IS_NULLABLE'] == 'NO') {
					$required = "required";
				}
				$split_key = explode('_', $value['COLUMN_NAME']);
				$form .='<div class="form-group"><label for="'.$value['COLUMN_NAME'].'">'.utf8_encode($value['COLUMN_COMMENT']).'</label>'.$this->get_input($split_key[0],$value['COLUMN_NAME'],$required).'</div>';
			}

			$form .= '<div class="text-center"><input type="submit" class="btn btn-success" value="'.$submit_text.'"></div></form>';

			return $form;
		}



	//criador de tabelas 
	public function createTable($table)
	{
		$sql = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".DB_NAME."' AND TABLE_NAME = '".$table."';";
		$this-> query($sql);
		$table ='<table class="table" id="'.$table.'_table"><thead>';
	 
		foreach ($this->result() as $key => $value) {
			$table .=  '<th>'.$value['COLUMN_COMMENT'].'</th>';
		}

		$table .= '</thead><tbody>';
		

	}
	
}