<?php

class Meta_tag extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('meta_tag_model');
	}
	public function index()
	{
		$data['meta']=$this->meta_tag_model->find(1);
		$data['title']='Manage Meta Tags';
		$this->load->blade('admin.meta_tag.index', $data);
	}

	function save()
	{
		$meta_desc=$this->input->post('meta_desc');
		$meta_key=$this->input->post('meta_key');

		$data=['meta_desc'=>$meta_desc,'meta_key'=>$meta_key];

		$this->meta_tag_model->update(1,$data);

		$this->session->set_flashdata('success', 'data saved successfully!');
		redirect(base_url().'admin/meta_tag');
	}

}

/* End of file meta_tag.php */
/* Location: ./application/controllers/admin/meta_tag.php */