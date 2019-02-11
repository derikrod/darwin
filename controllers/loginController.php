

<?php /**
 * 
 */
class loginController extends controller
{
	public function index($user,$pass)
	{
		$u = new User();
		if ($u->log()){
			echo json_encode(array('success' => 1,))
		}
	}	
	
} 
?>