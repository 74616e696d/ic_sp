<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invite extends Member_controller {

	function __construct()
	{
		parent::__construct();
		//$this->load->library('facebook');
		
	}

	public function index()
	{
		// $data['user_profile']='';
		// $user=$this->facebook->getUser();
		// $data['user']=$user;
		//   if($user == 0)
		//   {
	 //        $loginUrl = $this->facebook->getLoginUrl();
	 //        redirect("$loginUrl","location");
  //   	 } 
  //   	 else 
  //   	 {
	 //        $user_info = $this->facebook->api('/me');
	 //        print_r($user_info);
  //   	}
	
		$data['sitemap']=array();
		$data['main_content']='member/v_invite';
		$this->load->view('layout/master_inner', $data);
	}

}

/* End of file invite.php */
/* Location: ./application/controllers/member/invite.php */