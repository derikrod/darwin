<?php 
	/**
	 * 
	 */
	class suggestionsController extends controller
	{
		
		public function getForm($id){
			$su = new Suggestion();
			echo json_encode( array('form' => $su -> getSuggestionForm($id)));
		}		
	}

 ?>