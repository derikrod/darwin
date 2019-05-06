<?php 
	/**
	 * Classe respnsável por controlar os atrasos
	 */
	class Late extends Model
	{
		public function listUserLates($id)
		{
			$html = '<div class="row module-div">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><h3 class="text-center">Banco de Horas</h3><p class="text-center">Lista de atrasos</p>
					
							'.$this-> createTable('lates',array('sel_users' =>$id),'AND',false) .'
						</div>
					</div>';
			return $html;
		}

		public function listAdminLates()
		{
			$html = '<div class="row module-div">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><h3 class="text-center">Banco de Horas</h3><p class="text-center">Lista de atrasos</p>
							<p class="text-center">
							<button type="button" data-path="'.BASE_URL.'" data-iduser="'.$_COOKIE['intra_user'].'" id="add_bh_btn" class="btn btn-primary">Novo formulário de banco de horas</button>
							</p>
							'.$this-> createTable('lates') .'
						</div>
					</div>';
			return $html;
		}


			
	}
 ?>