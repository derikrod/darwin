<?php 
		/**
		 * 
		 */
	class Suggestion extends model
	{
			
			public function loadSuggestionModule($idmodule,$iduser)
		{
			$suggestionmodule = "";
	
			if (!$this->check_modules($idmodule,$iduser)) {
				return $suggestionmodule;
			}else{
				$suggestionmodule = '
							<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="col-xs-12 mymodule">
									<div class="row module-card" style="background-image:url(\''.BASE_URL.'/assets/images/suggestion.jpg\');background-position:bottom right;background-size:cover;">
												
									</div>
									<div class="row">
										
										<div class="module-buttons">
											<p class="module-title"><b>Sugestões</b></p>
											<p></p><p>Sua sugestão é muito importante para nós 😄</p>
											<p></p><p>&nbsp;</p>
											<p class="text-right"><a href="'.BASE_URL.'/suggestions/index/'.$iduser.'" class="btn btn-success" data-id="'.$iduser.'" >Lista de Sugestões</a>&nbsp;&nbsp;<a href="#"  id="newsuggestion_btn"class="btn btn-primary" data-id="'.$iduser.'" >NOVA SUGESTÃO</a></p>
										</div>
									</div>							
									</div>
							  </div>
							';

				return $suggestionmodule;
			}


		}

			public function loadSuggestionAdminModule($idmodule,$iduser)
		{
			$suggestionmodule = "";
	
			if (!$this->check_modules($idmodule,$iduser)) {
				return $suggestionmodule;
			}else{
				$suggestionmodule = '
							<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="col-xs-12 mymodule">
									<div class="row module-card" style="background-image:url(\''.BASE_URL.'/assets/images/suggestion.jpg\');background-position:bottom right;background-size:cover;">
												
									</div>
									<div class="row">
										
										<div class="module-buttons">
											<p class="module-title"><b>Sugestões Adminnistração</b></p>
											<p></p><p>Area de sujestões do administrador</p>
											<p></p><p>&nbsp;</p>
											<p class="text-right"><a href="'.BASE_URL.'/suggestions/admin" class="btn btn-success">Lista de Sugestões</a></p>
										</div>
									</div>							
									</div>
							  </div>
							';

				return $suggestionmodule;
			}


		}

		public function getSuggestionForm($iduser)
		{
			$form = $this -> createForm('suggestions','Sugerir',0,array('users'=>$iduser, 	'txt_response' => ''));
			return $form;
		}

		public function setSuggestions($data)
		{
			
			$this->insert('suggestions',$data);
			return true;
		}	


		public function suggestionsTable($id)
		{	$table = '<div class="col-sm-10 col-sm-offset-1 module-div"><h3 class="text-center">Sugestões</h3>'.$this -> createTable('suggestions',array('users'=>$id),'AND',true,array('users')).'</div>';
			return $table;
		}

		public function suggestionsAdminTable()
		{	$table = '<div class="col-sm-10 col-sm-offset-1 module-div" id="admin_suggestions_div"><h3 class="text-center">Sugestões Administração</h3>'.$this -> createTable('suggestions',array(),'AND',false,array('users')).'</div>';
			return $table;
		}


		public function getUpdateForm($id)
			{
				return $this -> createForm('suggestions','Atualizar',$id,array('txt_response'=>'','users'=>$_COOKIE['intra_user']));
			}	

		public function updateSuggestions($data,$id)
			{
				$this-> update('suggestions', $data, array('id'=>$id));
				return true;
			}
		public function deleteSuggestions($id)
				{
					$this->delete('suggestions', array('id' => $id));
					return true;
				}		
	}



 ?>