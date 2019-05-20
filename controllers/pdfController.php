<?php  /**
 * 
 */
class pdfController extends controller
{
	public function index()
	{	
		$h = new Hours();
		$data  =array();
		$percents = 0;
		$data['department'] = $h-> getDepartment($value['sel_users']);
		$data['company'] = $h-> getCompany($value['sel_users'])[0]['txt_name'];
		$data['logo'] =  "assets/images/".strtolower($h->getCompany($value['sel_users'])[0]['txt_name'].".png");
		$data['color'] = $h-> getCompany($value['sel_users'])[0]['txt_color'];
		$data['cnpj'] = $h-> getCompany($value['sel_users'])[0]['cnpj'];
		$data['user'] = $h-> getUser($value['sel_users']);
		$data['boss'] = $h-> getBoss($value['sel_users']);
		$data['title'] = $h-> getTitle($value['sel_users']);
		if ($value['sel_bhtypes'] == 2) {
			$data["calchours"] = $value['hrs_hours'];
		}else{
			$data['calchours'] = $h-> calcHours($value['hrs_hours'],$value['dat_hourdate']);
			$percents = $h->getPercents($value['dat_hourdate']);
		}	

		$onlyhours = explode('(', $data['calchours']);
		$onlyhours = $onlyhours[0];

		$data['hours'] = $value['hrs_hours'];
		$data['type'] = $h->getType($value['sel_bhtypes']);
		$data['hourdate'] = $h->ptbrdate($value['dat_hourdate']).' ('.$h->getDayName($value['dat_hourdate']).')';
		$data['motivation'] = $value['txt_motivation'];
		$data['locale'] = $value['txt_locale'];
		$data['description']  = $value['lgt_desc'];
		

		$dbinsert = array(
			'sel_bhtypes' => $value['sel_bhtypes'], 
			'hrs_hours'=>$value['hrs_hours'],
			'sel_users'=>$_COOKIE['intra_user'],
			'hrs_calchours' => $onlyhours,
			'txt_percents' => $percents,
			'txt_weekday'=> $h->getDayName($value['dat_hourdate']),
			'dat_hourdate'=>$value['dat_hourdate'],
			'txt_motivation'=> $value['txt_motivation'],
			'txt_locale'=> $value['txt_locale'],
			'lgt_desc'=>$value['lgt_desc'],
			'sel_bhstatus'=>1
		);


		$h -> insertHours($dbinsert);

		ob_start();
		$this->loadTemplate('pdf',$data);
		$html= ob_get_contents();
		ob_end_clean();
		

		require_once 'vendor/autoload.php';

		// referenciando o namespace do dompdf


		// instanciando o dompdf

		 $dompdf = new Dompdf\Dompdf();
		

		// //inserindo o HTML que queremos converter

		$dompdf->loadHtml($html);

		// // Definindo o papel e a orientação

		 $dompdf->setPaper('A4', 'portait');

		// // Renderizando o HTML como PDF

		 $dompdf->render();

		// // Enviando o PDF para o browser

		 $dompdf->stream('my.pdf',array('Attachment'=>0));
		
	}


	public function load($id)
	{	
		$h = new Hours();
		$data  =array();
		$percents = 0;

		foreach ($h->getHours($id) as $key => $value) {
			$data['department'] = $h-> getDepartment($value['sel_users']);
			$data['company'] = $h-> getCompany($value['sel_users'])[0]['txt_name'];
			$data['logo'] =  "assets/images/".strtolower($h->getCompany($value['sel_users'])[0]['txt_name'].".png");
			$data['color'] = $h-> getCompany($value['sel_users'])[0]['txt_color'];
			$data['cnpj'] = $h-> getCompany($value['sel_users'])[0]['cnpj'];
			$data['user'] = $h-> getUser($value['sel_users']);
			$data['boss'] = $h-> getBoss($value['sel_users']);
			$data['title'] = $h-> getTitle($value['sel_users']);
			if ($value['sel_bhtypes'] == 2) {
				$data["calchours"] = $value['hrs_hours'];
			}else{
				$data['calchours'] = $h-> calcHours($value['hrs_hours'],$value['dat_hourdate']);
				$percents = $h->getPercents($value['dat_hourdate']);
			}	

			$onlyhours = explode('(', $data['calchours']);
			$onlyhours = $onlyhours[0];

			$data['hours'] = $value['hrs_hours'];
			$data['type'] = $h->getType($value['sel_bhtypes']);
			$data['hourdate'] = $h->ptbrdate($value['dat_hourdate']).' ('.$h->getDayName($value['dat_hourdate']).')';
			$data['motivation'] = $value['txt_motivation'];
			$data['locale'] = $value['txt_locale'];
			$data['description']  = $value['lgt_desc'];
		}
		
		

	


		ob_start();
		$this->loadTemplate('pdf',$data);
		$html= ob_get_contents();
		ob_end_clean();
		

		require_once 'vendor/autoload.php';

		// referenciando o namespace do dompdf


		// instanciando o dompdf

		 $dompdf = new Dompdf\Dompdf();
		

		// //inserindo o HTML que queremos converter

		$dompdf->loadHtml($html);

		// // Definindo o papel e a orientação

		 $dompdf->setPaper('A4', 'portait');

		// // Renderizando o HTML como PDF

		 $dompdf->render();

		// // Enviando o PDF para o browser

		 $dompdf->stream('bh.pdf',array('Attachment'=>0));
		
	}
}

?>