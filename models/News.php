<?php 
	/**
	 * 
	 */
	class News extends model
	{
		
		public function getLastNews()
		{
			$this-> query('SELECT * FROM news ORDER BY id  ASC LIMIT 1');
			$last = "";
			foreach ($this->result() as $key => $value) {
				$last = "<b>Ultimo boletim:</b> <a href=news/".$value['fle_file'].">".$value["txt_name"]."</a>";
			}
		}

		function newsTable(){
			$this -> createTable('news',array());
		}

		public function loadNewsModule($idmodule,$iduser)
		{
			$newsmodule = "";
	
			if (!$this->check_modules($idmodule,$iduser)) {
				return $newsmodule;
			}else{
				$newsmodule = '
							<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="col-xs-12 mymodule">
									<div class="row module-card" style="background-image:url(\''.BASE_URL.'/assets/images/news.jpg\');background-position:bottom right;background-size:cover;">
												
									</div>
									<div class="row">
										
										<div class="module-buttons">
											<p><b>Boletim</b></p>
											<p>'.$this-> getLastNews().'</p><p>&nbsp;</p>
											<p>&nbsp;</p>
											<p class="text-right"><a href="'.BASE_URL.'/news" class="btn btn-success">Boletins</a>
										</div>
									</div>							
									</div>
							  </div>
							';

				return $newsmodule;
			}
		}

		public function loadAdminNewsModule($idmodule,$iduser)
		{
			$newsmodule = "";
	
			if (!$this->check_modules($idmodule,$iduser)) {
				return $newsmodule;
			}else{
				$newsmodule = '
							<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="col-xs-12 mymodule">
									<div class="row module-card" style="background-image:url(\''.BASE_URL.'/assets/images/newsadmin.jpg\');background-position:bottom right;background-size:cover;">
												
									</div>
									<div class="row">
										
										<div class="module-buttons">
											<p><b>Boletim (Administração)</b></p>
											<p>'.$this-> getLastNews().'</p><p>&nbsp;</p>
											<p>&nbsp;</p>
											<p class="text-right"><a href="'.BASE_URL.'/news/admin" class="btn btn-success">Boletins</a>
										</div>
									</div>							
									</div>
							  </div>
							';

				return $newsmodule;
			}
		}
	}
 ?>