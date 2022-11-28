<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upgrade_confirmation extends CI_Controller {
	var $userid=0;
	var $utype=0;
	var $email='';
	var $username='';
	var $msg='';

	function __construct()
	{
		parent::__construct();
		$this->load->model('permission_model');
		if($this->session->userdata('userid'))
    	{
    		$this->userid=$this->session->userdata('userid');
    		$this->utype=$this->session->userdata('utype');
    		$this->email=$this->session->userdata('email');
    		$this->username=$this->session->userdata('username');

    	}
		$this->load->model('member/upgrade_model','upgrade');
		$this->load->model('membership_model');
		$this->load->helper('notify');
		$this->load->helper('message');
		$this->load->model('message_model');
    	$this->load->model('user_message_model');
	}
	public function index()
	{
		$upgrade=$this->upgrade->find_by_user($this->userid);
		$mtype=$upgrade?$upgrade->mem_type:0;
		$data['mtext']=membership_model::get_text($mtype);
		$data['amount']=$this->permission_model->get_amount($mtype);
		$mid=$this->uri->segment(4);
		$data['title']='Upgrade Confirmation';
		$data['mid']=$mid;
		$this->load->blade('public.upgrade_confirmation', $data);
	}

	function send()
	{
		$mid=$this->input->post('hdn_id');
		$code=$this->input->post('txt_upgrade_code');
		$user_latest_request=$this->upgrade->get_top_user_pending($this->userid,$mid);
		//var_dump($user_latest_request);
		$data=array('payment_code'=>$code);
		$this->upgrade->update_bkash_code($user_latest_request->pid,$user_latest_request->req_id,$data);
		 $this->session->set_flashdata('success', 'Your bkash code submitted successfully!Your account will be activated withing a very short time');
		 redirect(base_url()."public/upgrade_confirmation/index/{$mid}");
	}

}

/* End of file post_upgrade.php */
/* Location: ./application/controllers/public/post_upgrade.php */