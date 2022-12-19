<?php

class Membership extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('message');
		//$this->load->model('membership_model');
	}

	public function index()
	{
		$data['list']=$this->membership_model->get_members();
		$data['title']='Membership';
		$data['main_content']='admin/v_membership';
		$this->load->view('layout_admin/admin_layout',$data);
	}


	public function add()
	{
		$name=$this->input->post('txt_membership');
		if(!empty($name))
		{
			$data=array('name'=>$name);
			$this->membership_model->insert($data);
			$this->session->set_flashdata('success', 'successfully inserted!');
			redirect(base_url().'admin/membership');
		}
		else
		{
			$this->session->set_flashdata('warning', 'name cannot be empty!!');
			redirect(base_url().'admin/membership');
		}
	}
	public function edit_view()
	{	
		$id=$this->uri->segment(4);
		$data['member']=$this->membership_model->get_member_by_id($id);
		$this->load->view('admin/v_edit_membership',$data);
	}
	public function edit()
	{
		$id=$this->input->post('hdn_id');
		$name=$this->input->post('txt_membership_edit');
		$data=array('name'=>$name);
		if(!empty($name))
		{
			$this->membership_model->update($id,$data);

			$this->session->set_flashdata('success', 'successfully updated!');
			redirect(base_url().'admin/membership');
		}
		else
		{
			$this->session->set_flashdata('warning', 'name cannot be empty!!!');
			redirect(base_url().'admin/membership');
		}
	}
	public function add_membership()
	{
		$data['title']='Add Membership Type';
		$data['main_content']='admin/v_add_membership';
		$this->load->view('layout_admin/admin_layout',$data);
	}

}

