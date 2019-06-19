<?php /**
 * 
 */
class Manuals extends model
{
	public function manualLink($id)
	{
		$this -> query("SELECT * FROM users WHERE id =".$id);
		foreach ($this-> result() as $key => $value) {
			$company = $value['sel_companies'];
		}

		$link = '<a href="'.BASE_URL.'/assets/manals/'.$company.'.pdf" target="blank" class="btn btn-success">Munal de conduta</a>';

		return $link;
	}

	public function loadManualsModule($idmodule,$iduser)
		{
			$manualsmodule = "";
	
			if (!$this->check_modules($idmodule,$iduser)) {
				return $manualsmodule;
			}else{
				$manualsmodule = '
							<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="col-xs-12 mymodule">
									<div class="row module-card" style="background-image:url(\''.BASE_URL.'/assets/images/manual.jpg\');background-position:bottom right;background-size:cover;">
												
									</div>
									<div class="row">
										
										<div class="module-buttons">
											<p><b> Manual de Conduta</b></p>
											<p>Conheça melhor seus direitos e deveres dentro da empresa.</p><p>&nbsp;</p>
											<p class="text-right">'.$this->manualLink($iduser).'</p>
										</div>
									</div>							
									</div>
							  </div>
							';

				return $manualsmodule;
			}
		}
} ?>