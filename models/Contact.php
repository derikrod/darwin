<?php /**
 * 
 */
class Contact extends model
{
	public function getContact($name)
	{
		$this-> query("SELECT * FROM users WHERE txt_name LIKE '%".$name."%'");
		$list = "<div>";
		foreach ($this->result() as $key => $value) {
			$list.= '<p><b>Nome:</b> '.$value['txt_name'].' <br><b>E-mail:</b> '.$value['eml_email'].'<br><b>Ramal:</b> '.$value['txt_branch'].'</p>';
		}
		$list .='</div>';

		return $list;
	}
	public function contactTable()
	{
		return '<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
									<div class="col-xs-12 module-div"><h3 class="text-center">Lista de Contatos</h3>'.$this->createTable('users',array(),'AND',false,array('txt_login','psw_pass','sel_companies','sel_departments','sel_users','txt_title','dat_birthdate','hrs_hours','hrs_negativehours','non_grant')).'
									</div>
							  </div>';
	}
	public function loadContactModule($idmodule,$iduser)
 	{
 		$hoursmodule = "";
	
			if (!$this->check_modules($idmodule,$iduser)) {
				return $contactmodule;
			}else{
				$contactmodule = '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                  <div class="col-xs-12 mymodule">
                  <div class="row module-card" style="background-image:url(\''.BASE_URL.'/assets/images/contacts.png\');background-position:bottom right;background-size:cover;">
                        
                  </div>
                  <div class="row">
                    
                    <div class="module-buttons">
                      <p class="module-title"><b>Procurar Contato (Lista de Ramais)</b></p>
                     <form action="" id="contact_form" style="margin-top:14px;margin-bottom:8px;" data-path="'.BASE_URL.'">
											<div class="form-group"><input type="text" id="txt_name" name="txt_name" required class="form-control" placeholder="Nome do colaborador"></div>
											
											<div class="text-right">
                     <input type="submit" value="Procurar" class="btn btn-success">&nbsp;&nbsp;<a href="'.BASE_URL.'/contacts" class="btn btn-primary">LISTA DE CONTATOS</a>
											</div>
										</form>
                    </div>
                  </div>              
                  </div>
                   </div>
               ';

				return $contactmodule;
			}
 	}
 

} 

?>