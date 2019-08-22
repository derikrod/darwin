<?php 
	class homeController extends controller{
		function index()
		{	
			$u = new User();
			$e = new Event();
			$t = new Trello();
			$h = new Hours();
			$c = new Calc();
			$b = new Birthday();
			$cont = new Contact();
			$cll = new Call();
			$cll2 = new Call2();
			$n = new News();
			$n2 = new News2();
			$m = new Manuals();
			$g = new Gallery();
			$su = new Suggestion();

			if (isset($_COOKIE["intra_user"])&& !empty($_COOKIE["intra_user"])) {
				$dados =  array();
				foreach ($u-> getUserInformation($_COOKIE["intra_user"]) as $key => $value) {
					$username = $value["txt_name"];
				}
				$dados["name"] = $username;
				$dados["usermodule"] = $u-> loadUserModule(1,$_COOKIE["intra_user"] );
				$dados["eventmodule"] = $e-> loadEventModule(2,$_COOKIE["intra_user"] );
				$dados["trellomodule"] = $t-> loadTrelloModule(3,$_COOKIE["intra_user"] );
				$dados["bhmodule"] = $h-> loadUserHoursModule(4,$_COOKIE["intra_user"]);
				$dados["bhadmmodule"] = $h-> loadAdminHoursModule(5,$_COOKIE["intra_user"]);
				$dados["superhoursmodule"] = $h-> LoadSuperHoursModule($_COOKIE["intra_user"]);
				$dados["calcmodule"] = $c-> loadCalcModule(6,$_COOKIE["intra_user"]);
				$dados["birthdaymodule"] = $b-> loadBirthdayModule(7,$_COOKIE["intra_user"]);
				$dados["contactmodule"] = $cont-> loadContactModule(8,$_COOKIE["intra_user"]);
				$dados["callsmodule"] = $cll-> loadCallsModule(9,$_COOKIE["intra_user"]);
				$dados["admincallsmodule"] = $cll-> loadAdminCallsModule(10,$_COOKIE["intra_user"]);
				$dados["calls2module"] = $cll2-> loadCallsModule(17,$_COOKIE["intra_user"]);
				$dados["admincalls2module"] = $cll2-> loadAdminCallsModule(18,$_COOKIE["intra_user"]);
				$dados["newsmodule"] = $n-> loadNewsModule(11,$_COOKIE["intra_user"]);
				$dados["news2module"] = $n2-> loadNewsModule(15,$_COOKIE["intra_user"]);
				$dados["adminnewsmodule"] = $n-> loadAdminNewsModule(12,$_COOKIE["intra_user"]);
				$dados["adminnews2module"] = $n2-> loadAdminNewsModule(16,$_COOKIE["intra_user"]);
				$dados["manualsmodule"] = $m-> loadManualsModule(13,$_COOKIE["intra_user"]);
				$dados["gallerymodule"] = $g-> loadGalleryModule(14,$_COOKIE["intra_user"]);
				$dados["suggestionmodule"] = $su-> loadSuggestionModule(15,$_COOKIE["intra_user"]);
				
				$this->loadTemplate('main',$dados);
			}else{
				$dados = array(
				'form'=> $u-> getLoginForm( array('txt_login','psw_pass'),'users','Entrar','login')
				);
				$this->loadTemplate('home',$dados);
			}
			
		}
	}
 ?>