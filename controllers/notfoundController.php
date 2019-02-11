<?php 
	class notfoundController extends controller{
		function index()
		{	
			$this->loadTemplate('404',array());
		}
	}
 ?>