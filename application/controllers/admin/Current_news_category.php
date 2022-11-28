<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Current_news_category extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('current_news_category_model','category');
	}
	public function index()
	{
		$data['category']=$this->category->all();
		$data['title']='Manage Current News Category';
		$this->load->blade('admin.current_news_category.index', $data);
	}

	function create()
	{
		$data['title']='New Ccurrent News Category';
		$this->load->blade('admin.current_news_category.create', $data);
	}

	function store()
	{	
		$name=$this->input->post('category_name');
		$display=$this->input->post('display');
		$data=['name'=>$name,'display'=>$display];
		if(!empty($name))
		{
			$this->category->create($data);
			$this->session->set_flashdata('success', 'Successfully created !!');
			redirect(base_url().'admin/current_news_category');
		}
		else
		{
			$this->session->set_flashdata('error', 'Category name must be given !!');
			redirect(base_url().'admin/current_news_category');
		}
	}

	function edit()
	{
		$id=$this->uri->segment(4);
		$data['cat']=$this->category->find($id);
		$data['title']='Edit Current News Category';
		$this->load->blade('admin.current_news_category.edit', $data);
	}

	function update()
	{
		$id=$this->input->post('hdn_id');
		$name=$this->input->post('category_name');
		$display=$this->input->post('display');
		$data=['name'=>$name,'display'=>$display];
		if(!empty($name))
		{
			$this->category->update($id,$data);
			$this->session->set_flashdata('success', 'Successfully updated !!');
			redirect(base_url().'admin/current_news_category');
		}
		else
		{
			$this->session->set_flashdata('error', 'Category name must be given !!');
			redirect(base_url().'admin/current_news_category');
		}
	}

	function delete()
	{
		$id=$this->uri->segment(4);
		$this->category->delete($id);
		$this->session->set_flashdata('success', 'Succcessfully deleted !!');
		redirect(base_url().'admin/current_news_category');
	}
}

/* End of file current_news_category.php */
/* Location: ./application/controllers/current_news_category.php */