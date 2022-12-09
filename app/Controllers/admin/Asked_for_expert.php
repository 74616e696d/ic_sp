<?php

class Asked_for_expert extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('ask_expert_model');
		$this->load->model('user_model');
	}

	public function index()
	{
		$data['askings']=$this->ask_expert_model->all();
		$data['title']='Asked Help To An Expert';
		$this->load->blade('admin.asked_for_expert.index', $data);
	}

	function reply()
	{
		$id=$this->uri->segment(4);
		$data['ask']=$this->ask_expert_model->find($id);
		$data['title']='Reply';
		$this->load->blade('admin.asked_for_expert.reply', $data);
	}

	function save_reply()
	{
		$id=$this->input->post('hdn_ask_id');
		$details=$this->input->post('details');
		$display=$this->input->post('ck_display');
		$reply_date=date('Y-m-d H:i:s');
		$reply_by=$this->userid;
		$data=array('reply'=>$details,
			'reply_by'=>$reply_by,
			'reply_date'=>$reply_date,
			'status'=>1,
			'display'=>$display);

		$this->ask_expert_model->update($id,$data);
		redirect(base_url()."admin/asked_for_expert");
	}

	function delete()
	{
		$id=$this->uri->segment(4);
		$this->ask_expert_model->delete($id);
		$this->session->set_flashdata('success', 'Successfully deleted!!');
		redirect(base_url()."admin/asked_for_expert");
	}

}

/* End of file asked_for_expert.php */
/* Location: ./application/controllers/admin/asked_for_expert.php */