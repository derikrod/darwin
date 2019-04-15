<?php 
	/**
	 * 
	 */
	class Trello extends model
	{
		
		public function loadTrelloModule($idmodule,$iduser )
		{				
			
			ob_start();
			require 'apis/trelloapi.php';
			$html = ob_get_contents();
			ob_end_clean();

			$usermodule = "";
			if (!$this->check_modules($idmodule,$iduser)) {
				return $usermodule;
			}else{
				$usermodule = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="col-xs-12 module-div">
										<br><h3>Eventos</h3><br>
										'.$html.'						
									</div>
							  </div>';

				return $usermodule;
			}
		}
	}
 ?>