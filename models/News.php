<?php 
	/**
	 * 
	 */
	class News extends model
	{
		
		public function getLastNews()
		{
			$this-> query('SELECT * FROM news ORDER BY id  DESC LIMIT 1');
			$last = "";
			foreach ($this->result() as $key => $value) {
				$last = "<b>Último boletim:</b> <a href=".BASE_URL."/".$value['fle_file']." target=\"_blank\">".$value["txt_name"]."</a>";
			}

			return $last;
		}
		public function newsForm(){
			$form = $this-> createForm('news','ENVIAR');
			return $form;
		}
		public function addNews($data,$files)
		{
			$data['fle_file'] = $this -> upload($files,'assets/uploads');
			$this-> insert('news',$data);
		}


		public function updateNewsFile($data,$files)
		{
			$data['fle_file'] = $this -> upload($files,'assets/uploads');
			$this -> update('news',$data,array('id'=>$data['id']));
		}


		public function newsTable(){
			$table = '<div class="col-sm-10 col-sm-offset-1 module-div"><h3 class="text-center">Boletins</h3>'.$this -> createTable('news',array(),'AND',false).'</div>';
			return $table;
		}

		public function newsadminTable(){
			$table = '<div class="col-sm-10 col-sm-offset-1 module-div"><h3 class="text-center">Boletins Administração</h3>'.$this -> createTable('news',array(),'AND',true).'</div>';
			return $table;
		}

		
		public function getFileName($id)
		{
			$this-> query('SELECT * FROM news WHERE id = '.$id);
			$file = "";
			foreach ($this->result() as $key => $value) {
				$file = $value['fle_file'];
			}
			return $file;
		}


		public function getUpdateForm($id){
			$form = $this -> createForm('news','ATUALIZAR',$id,array('fle_file'=> $this -> getFileName($id)));
			return $form;
		}

		public function updateNews($data,$id)
		{
			$this -> update('news',$data,array('id'=>$id));
			return true;
		}

		public function deleteNews($id)
		{
			$this-> delete('news',array('id'=>$id));
			return true;
		}

		public function getUpdateFile($id)
		{
			$form = $this -> getSmForm(array('fle_file'),'news','ATUALIZAR','newsfile',array('id'=>$id));
			return $form;
		}

		//load modules
		public function loadAdminNewsModule($idmodule,$iduser)
		{
			$newsmodule = "";
	
			if (!$this->check_modules($idmodule,$iduser) || $this-> getCity($iduser) != 1) {
				return $newsmodule;
			}else{
				$newsmodule = '
							<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="col-xs-12 mymodule">
									<div class="row module-card" style="background-image:url(\''.BASE_URL.'/assets/images/newsadmin.jpg\');background-position:bottom right;background-size:cover;">
												
									</div>
									<div class="row">
										
										<div class="module-buttons">
											<p class="module-title"><b>Boletim (Administração)</b></p>
											<p>'.$this-> getLastNews().'</p>
											<p>&nbsp;</p>
											<p class="text-right"><a href="#" id="new_news"  data-path="'.BASE_URL.'" class="btn btn-primary">NOVO BOLETIM</a>&nbsp;&nbsp;<a href="'.BASE_URL.'/news/admin" class="btn btn-success">Boletins</a></p>
										</div>
									</div>							
									</div>
							  </div>
							';

				return $newsmodule;
			}
		}

		public function loadNewsModule($idmodule,$iduser)
		{
			$newsmodule = "";
	
			if (!$this->check_modules($idmodule,$iduser) || $this-> getCity($iduser) != 1) {
				return $newsmodule;
			}else{
				$newsmodule = '
							<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="col-xs-12 mymodule">
									<div class="row module-card" style="background-image:url(\''.BASE_URL.'/assets/images/news.jpg\');background-position:bottom right;background-size:cover;">
												
									</div>
									<div class="row">
										
										<div class="module-buttons">
											<p class="module-title"><b>Boletim</b></p>
											<p>'.$this-> getLastNews().'</p><p>&nbsp;</p>
											<p class="text-right"><a href="'.BASE_URL.'/news" class="btn btn-success">Boletins</a></p>
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