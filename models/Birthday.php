<?php 
/**
  * 
  */
 class Birthday extends model
 {
 	
 	public function getBirthdays($month)
 	{
 		$this ->query('SELECT txt_name,MONTH(dat_birthdadte)AS month,DAY(dat_birthdadte)AS day FROM `users` WHERE MONTH(dat_birthdadte) ='.$month);
 		$birthdays = '<div style="width:100%;height:150px;overflow-y:scroll;margin-bottom:10px">';
 		foreach ($this->result() as $key => $value) {
 			$birthdays .='<p style="font-size:18px;"><b class="text-left">'.$value['txt_name'].'</b> &nbsp;&nbsp;&nbsp;&nbsp;'.$value['day'].'/'.$value['month'].'</p>';
 		}
 		$birthdays.="</div>";
 		return $birthdays;
 	}

 	public function loadBirthdayModule($idmodule,$iduser)
 	{
 		$hoursmodule = "";
	
			if (!$this->check_modules($idmodule,$iduser)) {
				return $birthdaysmodule;
			}else{
				$birthdaysmodule = '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                  <div class="col-xs-12 mymodule">
                  <div class="row module-card" style="background-image:url(\''.BASE_URL.'/assets/images/birthday.png\');background-position:bottom right;background-size:cover;color:white;height:320px;padding:10px;">
                        <br><h3>Aniversariantes do mês</h3><br>
										'.$this->getBirthdays(date('m')).'
                  </div>
                               
                  </div>
                  </div>
               ';

				return $birthdaysmodule;
			}
 	}
 } ?>