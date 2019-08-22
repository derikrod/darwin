<?php 
/**
  * 
  */
 class Birthday extends model
 {
 	
 	public function getBirthdays($month)
 	{
 		$this ->query('SELECT txt_name,MONTH(dat_birthdate)AS month,DAY(dat_birthdate)AS day FROM `users` WHERE MONTH(dat_birthdate) ='.$month. ' ORDER BY dat_birthdate ASC');
 		$birthdays = '<style type="text/css">
::-webkit-scrollbar {
  width: 9px;
  height: 9px;
}
::-webkit-scrollbar-button {
  width: 0px;
  height: 0px;
}
::-webkit-scrollbar-thumb {
  background: #e1e1e1;
  border: 0px none #ffffff;
  border-radius: 50px;
}
::-webkit-scrollbar-thumb:hover {
  background: #ffffff;
}
::-webkit-scrollbar-thumb:active {
  background: #ffffff;
}
::-webkit-scrollbar-track {
  background: #666666;
  border: 0px none #ffffff;
  border-radius: 50px;
}
::-webkit-scrollbar-track:hover {
  background: #666666;
}
::-webkit-scrollbar-track:active {
  background: #333333;
}
::-webkit-scrollbar-corner {
  background: transparent;
}
</style><div style="width:100%;height:220px;overflow-y:scroll;margin-bottom:10px;">';
 		foreach ($this->result() as $key => $value) {
 			$birthdays .='<p style="font-size:18px;"> '.$value['day'].'/'.$value['month'].' <b class="text-left">'.$value['txt_name'].'</b></p>';
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
                                <div class="row module-card" style="background-image:url(\''.BASE_URL.'/assets/images/birthday.png\');background-position:bottom right;background-size:cover;color:white;height:330px;padding:10px;">
                                      <br><h3 class="module-title">Aniversariantes do mês</h3><br>
              										'.$this->getBirthdays(date('m')).'
                                </div>         
                              </div>
                          </div>
               ';

				return $birthdaysmodule;
			}
 	}
 } ?>