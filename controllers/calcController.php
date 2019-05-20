<?php
	/**
	  * 
	  */
	 class calcController extends controller
	 {
	 	
	 	public function index()
		{	
			$c = new Calc();
			echo json_encode(array('form'=>$c->getCalc() ));
		
		}
	 } 
 ?>