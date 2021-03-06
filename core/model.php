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
	public function upload($files,$dir)
	{	
		if (count($files)>0) {
			move_uploaded_file($files['tmp_name'], $dir."/".$files['name']);
			return $dir."/".$files['name'];
		}
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
	public function generateLink($link)
	{	
		$linksplit = explode('/', $link);
		return '<a href="'.BASE_URL."/".$link.'" target="_blank">'.end($linksplit).'</a>';
	}
	public function getGrant($iduser)
	{
		$this-> query("SELECT * FROM users WHERE id =".$iduser." AND non_grant <> '0'");
		if ($this-> numRows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function ptBRdate($date)
	{
		$split_date = explode('-', $date);
		$day_split = explode(" ", $split_date[2]);
		$day = "";
		$hours = "";
		if (count($day_split) > 1) {
			$day = $day_split[0];
			$hours = $day_split[1];
		}else{
			$day = $split_date[2];
		}


		return $day."/".$split_date[1]."/".$split_date[0]." ".$hours;
	}
	//construtor de formulários
	//1.selects
	private function get_select($table,$key,$required="",$selected = 0)
	{
		$this -> query("SELECT * FROM ".$table." WHERE visible = 0");
		$select = '<select name="'.$key.'" id="'.$key.'" '.$required.' class="form-control"><option value="">Selecione...</option>';
		foreach ($this->result() as $key => $value) {
			$selected_input ="";
			if ($value['id'] == $selected) {
				$selected_input = 'selected = "selected"';
			}
			$select .= 	'<option value="'.$value['id'].'" '.$selected_input.'>'.$value['txt_name'].'</option>';
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
			$radio .= '<label for="'.$name.$i.'">'.utf8_encode($value['txt_name']).'</label><input type="radio" name="'.$name.'" id="'.$name.'" '.$checked.' value="'.$value["id"].'" '.$required.'>';
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
			case 'lgt':
				$input = '<textarea name="'.$name.'" id="'.$name.'" cols="30" rows="10" class="form-control" '.$required.'>'.$value.'</textarea>';	
				break;
			case 'sel':
				$spliname = explode('_', $name);
				$input = $this-> get_select($spliname[1],$name,$required,$value);	
				break;
			case 'chk':
				$spliname = explode('_', $name);
				$input = $this-> get_checkbox($spliname[1],$name,$required,$value);	
				break;
			case 'rdo':
				$spliname = explode('_', $name);
				$input = $this-> get_radio($spliname[1],$name,$required,$value);	
				break;	
			case 'tel':
				$input = '<input type="text" name="'.$name.'" id="'.$name.'" value="'.$value.'" class="form-control phone" '.$required.'>';	
				break;
			case 'dat':
				$input = '<input type="date" name="'.$name.'" id="'.$name.'" value="'.$value.'" class="form-control date" '.$required.'>';
				break;
			case 'hrs':
				$input = '<input type="text" name ="'.$name.'" id="'.$name.'" value="'.$value.'" class="form-control hours" '.$required.'>';
				break;
			case 'eml':
				$input = '<input type="email" name ="'.$name.'" id="'.$name.'" value="'.$value.'" class="form-control" '.$required.'>';
				break;
			case 'fle':
				$input = '<input type="file" id="'.$name.'" name="'.$name.'" accept="application/pdf" '.$required.'>';
				break;		
			default:
				$input = '';
				break;		
		}

		return $input;
	}
	//criando formulário
	public function createForm($table,$submit_text,$id=0,$hiddens =array())
	{
		$form = "";

		if ($id == 0 ) {
			$sql = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".DB_NAME."' AND TABLE_NAME = '".$table."';";
			$this -> query($sql);
			$form = '<form  id="add_'.$table.'" data-path='.BASE_URL.' enctype="multipart/form-data"><span id="error_display" class="text-center"></span>';

			$exclude = array();

			if (count($hiddens) > 0) {
				foreach ($hiddens as $key => $value) {
					$form.= '<input type="hidden" id="'.$key.'" name="'.$key.'" value="'.$value.'">';
					array_push($exclude, $key);
				}
			}
			foreach ($this->result() as $key => $value) {
				$required = "";
				if ($value['IS_NULLABLE'] == 'NO') {
					$required = "required";
				}
				$split_key = explode('_', $value['COLUMN_NAME']);
				if ($value['COLUMN_NAME'] != 'id' && $split_key[0] != 'non' && !in_array($value['COLUMN_NAME'], $exclude)) {
					$form .= '<div class="form-group" id="div_'.$value["COLUMN_NAME"].'"><label for="'.$value['COLUMN_NAME'].'">'.$value['COLUMN_COMMENT'].'</label>'.$this->get_input($split_key[0],$value['COLUMN_NAME'],$required).'</div>';
				}	
			}
			
			$form.='<div id="btn_'.$table.'_form" class="text-center"><input type="submit" class="btn btn-success" value="'.$submit_text.'"></div></form>';
			return $form;
		}else{
			$sql = "SELECT * FROM ".$table." WHERE id = ".$id;
			$this->query($sql);
			$form = '<form  id="update_'.$table.'" data-path="'.BASE_URL.'"" data-id="'.$id.'" data-table="'.$table.'">';
			$exclude = array();

			if (count($hiddens) > 0) {
				foreach ($hiddens as $key => $value) {
					$form.= '<input type="hidden" id="'.$key.'" name="'.$key.'" value="'.$value.'">';
					array_push($exclude, $key);
				}
			}
			$res = $this -> result();
			foreach ($res[0] as $key => $value) {
				$sql_label = "";
				if(!is_numeric($key) && $key != 'id' && substr($key, 0,3) != 'psw' && !in_array($key, $exclude)){
				 	$sql_label = "SELECT COLUMN_COMMENT,IS_NULLABLE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".DB_NAME."' AND TABLE_NAME = '".$table."' AND COLUMN_NAME ='".$key."' ;";
				 		$this-> query($sql_label);
				 		$res = $this->result();
				 		$required = "";
				 		if ($res[0]['IS_NULLABLE'] == 'NO') {
				 			$required = "required";
				 		}
				 		$form .= '<div class="form-group" id="div_'.$key.'"><label for="'.$key.'">'.$res[0][0].'</label>'.$this->get_input(substr($key, 0,3),$key,$required,$value).'</div>';
				 		
				 }
				
				
			}
		
			$form.='<div class="text-center" id="btn_'.$table.'_form"><input type="submit" class="btn btn-success" value="'.$submit_text.'">&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger" id="remove_btn" data-id="'.$id.'" data-path="'.BASE_URL.'" data-table="'.$table.'">Remover</button></div> </form>';
			return $form;	
		}
		
	}

	//criador de formulários com campos específicos
	public function getSmForm($fields = array(),$table,$submit_text,$form_name,$hiddens = array())
	{
		$form = '<form id="'.$form_name.'_form" data-path='.BASE_URL.' enctype="multipart/form-data"><span id="error_display" class="text-center"></span>';
		foreach ($fields as $key => $value) {
			$fields[$key] = "COLUMN_NAME = '".$value."'";
		}

		$sql_fields = implode(' OR ', $fields);

		$sql = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".DB_NAME."' AND TABLE_NAME = '".$table."' AND (".$sql_fields.")";

		$this -> query($sql);
		if (count($hiddens) > 0) {
				foreach ($hiddens as $key => $value) {
					$form.= '<input type="hidden" id="'.$key.'" name="'.$key.'" value="'.$value.'">';
				}
			}
		foreach ($this->result() as $key => $value) {
			$required = "";
			if ($value['IS_NULLABLE'] == 'NO') {
				$required = "required";
			}

			
			$split_key = explode('_', $value['COLUMN_NAME']);
			$form .='<div class="form-group" id="div_'.$value["COLUMN_NAME"].'"><label for="'.$value['COLUMN_NAME'].'">'.utf8_encode($value['COLUMN_COMMENT']).'</label>'.$this->get_input($split_key[0],$value['COLUMN_NAME'],$required).'</div>';
		}

		$form .= '<div class="text-center" id="btn_'.$table.'_form"><input type="submit" class="btn btn-success" value="'.$submit_text.'"></div></form>';

		return $form;
	}

	//contador de registros
	public function countRegisters($table,$condition  = array(),$where_cond ="AND")
	{
		if (count($condition) == 0) {
			$sql = "SELECT * FROM ".$table;
			$this-> query($sql);
			return $this->numRows();
		}else{
			foreach ($condition as $key => $value) {
				$condition[$key] = $key ." = '".$value."'";
			}
			$rule = implode($where_cond, $condition);

			$sql = "SELECT * FROM ".$table." WHERE ".$rule;
			$this -> query($sql);
			return  $this->numRows();
		}
	}

	//criador de tabelas 
	public function get_options($key,$value)
	{
		$split_key = explode('_', $key);
		$sql ="SELECT * FROM ".$split_key[1]." WHERE id = ".$value;
		$option = "";
		$this -> query($sql);
		foreach ($this->result() as $key => $value) {
			$option = utf8_decode($value["txt_name"]);
		}

		return utf8_encode($option);
	}

	public function isexclude($exclude,$key)
	{
		if (in_array($key, $exclude)){
			return true;
		}else{
			return false;
		}
	}
	public function createTable($table_name,$condition = array(),$where_cond = 'AND',$editable = true,$exclude = array(),$operator = '=',$order ="")
	{
		$table = "";
		$sql = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".DB_NAME."' AND TABLE_NAME = '".$table_name."';";
		$this-> query($sql);
		$table ='<table class="table" id="'.$table_name.'_table"><thead>';
	 
		foreach ($this->result() as $key => $value) {
			if ($value['COLUMN_COMMENT'] != ""  && substr($value['COLUMN_NAME'],0, 3)!='psw' && !$this->isexclude($exclude,$value['COLUMN_NAME'])) {
				$table .=  '<th>'.$value['COLUMN_COMMENT'].'</th>';
			}	
		}

		$table .= '</thead><tbody>';
		$conditional = "";
		
		if (count($condition)>0) {
			foreach ($condition as $key => $value) {
				$condition[$key] = $key." ".$operator." '".$value."'";

			}
			$conditional = 'WHERE '.implode(' '.$where_cond.' ', $condition);
		}
		$sql = "SELECT * FROM ".$table_name." ".$conditional." ".$order;
		$this-> query($sql);
		$res = array();
		$i=0;
		
		foreach ($this->result() as $key => $value) {
			$res[$i] = $value;
			$i++;
		}
		
		foreach ($res as $key => $intraarray) {
			if ($editable) {
				$table .= '<tr class="inform-row" data-table="'.$table_name.'" data-id="'.$intraarray['id'].'" data-path="'.BASE_URL.'">';
			}else{
				$table .= '<tr data-id="'.$intraarray['id'].'" data-path="'.BASE_URL.'">';
			}
			
			foreach ($intraarray as $key => $value) {
				if (!is_numeric($key) && $key != 'id' && $key != 'visible' && substr($key,0, 3)!='non'  && substr($key,0, 3)!='psw' && !$this->isexclude($exclude,$key)) {
					if (substr($key,0, 3) == 'sel') {
					 	$table .= "<td>".$this->get_options($key,$value) ."</td>";
					}elseif (substr($key,0, 3) == 'dat') {
						$table .= "<td>".$this->ptBRdate($value)."</td>";
					}elseif (substr($key,0, 3) == 'fle'){
						$table .= "<td>".$this->generateLink($value)."</td>";
					}else{
						$table .= "<td>".$value."</td>";
					}
					
				}
				
			}
			$table.= '</tr>';
		}
		$table .= "</tbody></table>";

		return $table;
	}


	public function check_modules($idmodule,$iduser)
	{
		$department = 0;
		$permissions = array();
		$sql_module = "SELECT * FROM modules WHERE id = ".$idmodule;
		$this ->query($sql_module);
		foreach ($this->result() as $key => $value) {
			$permissions = explode(',', $value["permissions"]);
		}

		$sql_user = "SELECT * FROM users WHERE id = ".$iduser;
		$this ->query($sql_user);
		foreach ($this-> result() as $key => $value) {
			$department = $value["sel_departments"];
		}

		if (in_array($department, $permissions)) {
			return true;
		}else{
			return false;
		}
	}


	public function checkGrant($iduser)
	{
		$sql = "SELECT * FROM users WHERE id =".$id." AND non_grant <> 0;";
		$this-> query($sql);
		if ($this->numRows()>0){
			return true;
		}else{
			return false;
		}

	}

	public function getCity($iduser)
	{
		$this->query('SELECT * FROM users WHERE id = '.$iduser);
		$city = 0;
		foreach ($this->result() as $key => $value) {
			$city = $value['sel_cities'];
		}
		return $city;
	}
	
}