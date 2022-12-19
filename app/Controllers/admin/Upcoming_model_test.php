<?php

class Upcoming_model_test extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('common');
		$this->load->model('ref_text_model');
		$this->load->model('upcoming_test_model');
	}
	public function index()
	{
		$data['exams']=$this->upcoming_test_model->all();
		$data['title']='Upcoming Model Test';
		$this->load->blade('admin.upcoming_model_test.index', $data);
	}

	function create()
	{
		$data['category']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['title']='New Upcoming Model Test';
		$this->load->blade('admin.upcoming_model_test.create', $data);
	}

	function store()
	{
		$category=$this->input->post('ddlCategory');
		$title=$this->input->post('txtTitle');
		if(!empty($category))
		{
			$fall_back_img=do_upload('userfile','asset/upload/');
			$exam_date=get_date_picker('exam_date');
			$display=$this->input->post('display');
			$data=[
			'category'=>$category,
			'name'=>$title,
			'fall_back_img'=>$fall_back_img,
			'exam_date'=>$exam_date,
			'display'=>$display
			];
			$this->upcoming_test_model->create($data);
			$this->session->set_flashdata('success', 'Saved successfully !!');
			redirect(base_url().'admin/upcoming_model_test');
		}
		else
		{
			$this->session->set_flashdata('error', 'Unable to insert !!');
			redirect(base_url().'admin/upcoming_model_test/create');
		}
		
	}

	function edit()
	{
		$id=$this->uri->segment(4);
		$data['exam']=$this->upcoming_test_model->find($id);
		$data['category']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['title']='Edit Upcoming Model Test';
		$this->load->blade('admin.upcoming_model_test.edit', $data);
	}

	function update()
	{
		$id=$this->input->post('hdn_id');
		$category=$this->input->post('ddlCategory');
		$title=$this->input->post('txtTitle');
		if(!empty($category))
		{
			$fall_back_img=do_upload('userfile','asset/upload/');
			$exam_date=get_date_picker('exam_date');
			$display=$this->input->post('display');
			$fall_back_img=$this->input->post('current_img');
			$new_img=$this->input->post('new_img');
			if(!empty($new_img))
			{
				if(file_exists('asset/news/'.$fall_back_img))
				{
					unlink('asset/news/'.$fall_back_img);
				}
				$fall_back_img=do_upload('userfile','asset/upload/');
			}
			$data=[
			'category'=>$category,
			'name'=>$title,
			'fall_back_img'=>$fall_back_img,
			'exam_date'=>$exam_date,
			'display'=>$display
			];
			$this->upcoming_test_model->update($id,$data);
			$this->session->set_flashdata('success', 'Update successfully !!');
			redirect(base_url().'admin/upcoming_model_test');
		}
		else
		{
			$this->session->set_flashdata('error', 'Unable to update !!');
			redirect(base_url().'admin/upcoming_model_test/edit/'.$id);
		}
	}

	function delete()
	{
		$id=$this->uri->segment(4);
		$this->upcoming_test_model->delete($id);
		$this->session->set_flashdata('success', 'Successfully deleted !!');
		redirect(base_url().'admin/upcoming_model_test');
	}

}

/* End of file upcoming_model_test.php */
/* Location: ./application/controllers/admin/upcoming_model_test.php */