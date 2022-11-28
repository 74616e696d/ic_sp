<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Carbon\Carbon;
class Opt_controller extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		// check user authentication
		$roles=array('101','102');

  		membership_model::is_authenticate($roles);
    	//end check user authentication
    	//$this->output->enable_profiler(true);
    	
	}
	public function index()
	{
		
	}

}

/* End of file admin_controller.php */
/* Location: ./application/core/admin_controller.php */