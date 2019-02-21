

<?php /**
 * 
 */
class loginController extends controller
{
	public function index($user,$pass)
	{
		$u = new User();
		if ($u->log('users',array('txt_login'=>$user, 'psw_pass'=>$pass))){
			echo json_encode(array('success' => 1,'iduser'=>$u->getIdByName($user)));
		}else{
			echo json_encode(array('success' => 0));
		}
	}	
	
} 
?>