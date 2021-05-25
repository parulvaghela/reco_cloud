<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
     
		$this->load->view('welcome_message');
	}
        
    /*    public function doLogin()
	{
     
            $req = file_get_contents("php://input");
            $req_array = json_decode($req);
	}*/
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
