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
											<p><b>Sugestões</b></p>
											<p></p><p>Sua sugestão é muito importante para nós 😄</p>
											<p></p><p>&nbsp;</p>
											<p class="text-right"><a href="'.BASE_URL.'/suggestion" class="btn btn-success" data-id="'.$iduser.'" >Lista de Sugestões</a>&nbsp;&nbsp;<a href="#"  id="newsuggestion_btn"class="btn btn-primary" data-id="'.$iduser.'" >NOVA SUGESTÃO</a></p>
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
				return utf8_decode($form);
			}
		}
 ?>