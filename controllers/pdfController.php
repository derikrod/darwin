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
		$data['department'] = $h-> getDepartment($_POST['sel_users']);
		$data['company'] = $h-> getCompany($_POST['sel_users'])[0]['txt_name'];
		$data['logo'] =  "assets/images/".strtolower($h->getCompany($_POST['sel_users'])[0]['txt_name'].".png");
		$data['color'] = $h-> getCompany($_POST['sel_users'])[0]['txt_color'];
		$data['cnpj'] = $h-> getCompany($_POST['sel_users'])[0]['cnpj'];
		$data['user'] = $h-> getUser($_POST['sel_users']);
		$data['boss'] = $h-> getBoss($_POST['sel_users']);
		$data['title'] = $h-> getTitle($_POST['sel_users']);
		if ($_POST['sel_bhtypes'] == 2) {
			$data["calchours"] = $_POST['hrs_hours'];
		}else{
			$data['calchours'] = $h-> calcHours($_POST['hrs_hours'],$_POST['dat_hourdate']);
			$percents = $h->getPercents($_POST['dat_hourdate']);
		}	

		$onlyhours = explode('(', $data['calchours']);
		$onlyhours = $onlyhours[0];

		$data['hours'] = $_POST['hrs_hours'];
		$data['type'] = $h->getType($_POST['sel_bhtypes']);
		$data['hourdate'] = $h->ptbrdate($_POST['dat_hourdate']).' ('.$h->getDayName($_POST['dat_hourdate']).')';
		$data['motivation'] = $_POST['txt_motivation'];
		$data['locale'] = $_POST['txt_locale'];
		$data['description']  = $_POST['lgt_desc'];
		

		$dbinsert = array(
			'sel_bhtypes' => $_POST['sel_bhtypes'], 
			'hrs_hours'=>$_POST['hrs_hours'],
			'sel_users'=>$_COOKIE['intra_user'],
			'hrs_calchours' => $onlyhours,
			'txt_percents' => $percents,
			'txt_weekday'=> $h->getDayName($_POST['dat_hourdate']),
			'dat_hourdate'=>$_POST['dat_hourdate'],
			'txt_motivation'=> $_POST['txt_motivation'],
			'txt_locale'=> $_POST['txt_locale'],
			'lgt_desc'=>$_POST['lgt_desc'],
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
}

?>