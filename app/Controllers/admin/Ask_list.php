<?php

class Ask_list extends Admin_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('member_question_model');
		$this->load->model('mem_ques_ans_model');
	}
	public function index()
	{
		$lists=$this->member_question_model->all();
		$data['lists']=$lists;


		$data['title']="Member Ask List";
		$this->load->blade('admin.ask_list', $data);
	}

	function  ask_details()
	{
		$data['title']='';
		$this->load->blade('admin.ask_details.blade.php', $data);
	}

	function reply_view()
	{
		$id=$this->uri->segment(4);
		$given=$this->member_question_model->find($id);
		$data['title']='';

		$answer=$this->mem_ques_ans_model->find_by('mqid',$id);

		$data['answer']=$answer;
		$data['ques']=$given;
		$this->load->blade('admin.ask_reply', $data);
	}

	function reply()
	{
		$ans_id=$this->input->post('hdn_ans_id');
		$user=$this->session->userdata('userid')?$this->session->userdata('userid'):0;
		$qid=$this->input->post('hdn_id');
		$ans=$this->input->post('txt_reply');
		if($ans_id==0)
		{
			$data=array('mqid'=>$qid,
				'ans'=>$ans,
				'ans_date'=>date('Y-m-d H:i:s'),
				'ans_by'=>$user);

			$this->mem_ques_ans_model->create($data);
			$this->member_question_model->update($qid,array('answered'=>1));
			$this->session->set_flashdata('success', 'successfully replied !');
			redirect(base_url()."admin/ask_list");
		}
		else
		{
			$data=array('mqid'=>$qid,
				'ans'=>$ans,
				'ans_by'=>$user);

			$this->mem_ques_ans_model->update($ans_id,$data);
			$this->member_question_model->update($qid,array('answered'=>1));
			$this->session->set_flashdata('success', 'successfully updated !');
			redirect(base_url()."admin/ask_list");
		}
	}

	function remove()
	{
		$id=$this->uri->segment(4);
		$this->member_question_model->delete($id);
		$this->mem_ques_ans_model->delete_by('mqid',$id);
		$this->session->set_flashdata('success', 'successfully deleted!!');
		redirect(base_url()."admin/ask_list");
	}

	function publish()
	{
		$id=$this->input->get('id');
		$display=$this->input->get('display');
		//var_dump($id.'   '.$display);
		$this->member_question_model->update($id,array('published'=>$display));
		echo 'Ok';
	}

}

/* End of file ask_list.php */
/* Location: ./application/controllers/admin/ask_list.php */