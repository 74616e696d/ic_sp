<?php
/**
 * manage university name
 */
class University extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('university_model');
	}

	public function index()
	{
		$data['university']=$this->university_model->all();
		$data['title']='University List';
		$this->load->blade('admin.university.index', $data);
	}


	function create()
	{
		$data['title']='Add University';
		$this->load->blade('admin.university.create', $data);
	}

	function store()
	{
		$name=$this->input->post('txtName');
		$display=$this->input->post('txtDisplay');
		if(!empty($name))
		{
			$data=['name'=>$name,'display'=>$display];
			$this->university_model->create($data);
			$this->session->set_flashdata('success', 'University added successfully!!');
			redirect(base_url().'admin/university');
		}
		else
		{
			$this->session->set_flashdata('error', 'University Name must be given !!');
			redirect(base_url().'admin/university/create');
		}
	}

	function edit()
	{
		$id=$this->uri->segment(4);
		$data['uni']=$this->university_model->find($id);
		$data['title']='Edit University';
		$this->load->blade('admin.university.edit', $data);
	}

	function update()
	{
		$id=$this->input->post('hdn_id');
		$name=$this->input->post('txtName');
		$display=$this->input->post('txtDisplay');
		if(!empty($name))
		{
			$data=['name'=>$name,'display'=>$display];
			$this->university_model->update($id,$data);
			$this->session->set_flashdata('success', 'University added successfully!!');
			redirect(base_url().'admin/university');
		}
		else
		{
			$this->session->set_flashdata('error', 'University Name must be given !!');
			redirect(base_url().'admin/university/edit/'.$id);
		}
	}

	function delete()
	{
		$id=$this->uri->segment(4);
		$this->university_model->delete($id);
		redirect(base_url().'admin/university');
	}

}

/* End of file university.php */
/* Location: ./application/controllers/admin/university.php */
