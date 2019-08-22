<?php /**
 * 
 */
class Gallery extends model
{
	
	public function loadGalleryModule($idmodule,$iduser)
		{
			$gallerymodule = "";
	
			if (!$this->check_modules($idmodule,$iduser)) {
				return $gallerymodule;
			}else{
				$gallerymodule = '
							<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="col-xs-12 mymodule">
									<div class="row module-card" style="background-image:url(\''.BASE_URL.'/assets/images/gallery.jpg\');background-position:bottom right;background-size:cover;">
												
									</div>
									<div class="row">
										
										<div class="module-buttons">
											<p class="module-title"><b> Galeria de fotos</b></p>
											<p>Fotos dos eventos da empresa.</p><p>&nbsp;</p>
											<p class="text-right"><a href="'.BASE_URL.'/galeriadefotos" class=" btn btn-success" target="blank">GALERIA DE FOTOS</a></p>
										</div>
									</div>							
									</div>
							  </div>
							';

				return $gallerymodule;
			}
		}
} ?>