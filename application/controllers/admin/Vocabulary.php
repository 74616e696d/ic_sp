<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vocabulary extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('vocabulary_model');
	}

	public function index()
	{
		$data['vocabulary']=$this->vocabulary_model->all();
		$data['title']='Manage Vocabulary';
		$this->load->blade('admin.vocabulary.index', $data);
	}


	function create()
	{
		$data['title']='Add New';
		$this->load->blade('admin.vocabulary.create', $data);
	}

	function store()
	{
		$word=$this->input->post('word');
		$meaning=$this->input->post('meaning');
		$synonyms=$this->input->post('syn');
		$antonyms=$this->input->post('antonym');
		$example=$this->input->post('example');
		$display=$this->input->post('display');
		$data=array('word'=>$word,
			'meaning'=>$meaning,
			'synonyms'=>$synonyms,
			'antonyms'=>$antonyms,
			'example'=>$example,
			'display'=>$display);
		if(!empty($word))
		{
			$this->vocabulary_model->create($data);
			$this->session->set_flashdata('success', 'Succesfully added!');
			redirect(base_url()."admin/vocabulary");
		}
		else
		{
			$this->session->set_flashdata('error', 'Word cannot be empty');
			redirect(base_url()."admin/vocabulary/create");
		}
	}

	function edit()
	{
		$id=$this->uri->segment(4);
		$data['item']=$this->vocabulary_model->find($id);
		$data['title']='Edit Vocabulary';
		$this->load->blade('admin.vocabulary.edit', $data);
	}

	function update()
	{
		$id=$this->input->post('hdn_id');
		$word=$this->input->post('word');
		$meaning=$this->input->post('meaning');
		$synonyms=$this->input->post('syn');
		$antonyms=$this->input->post('antonym');
		$example=$this->input->post('example');
		$display=$this->input->post('display');
		$data=array('word'=>$word,
			'meaning'=>$meaning,
			'synonyms'=>$synonyms,
			'antonyms'=>$antonyms,
			'example'=>$example,
			'display'=>$display);
		if(!empty($word))
		{
			$this->vocabulary_model->update($id,$data);
			$this->session->set_flashdata('success', 'Succesfully updated!');
			redirect(base_url()."admin/vocabulary");
		}
		else
		{
			$this->session->set_flashdata('error', 'Word cannot be empty');
			redirect(base_url()."admin/vocabulary/create");
		}
	}

	function destroy()
	{
		$id=$this->uri->segment(4);
		$this->vocabulary_model->delete($id);
		$this->session->set_flashdata('success', 'Successfully deleted !');
		redirect(base_url()."admin/vocabulary");
	}

}

/* End of file vocabulary.php */
/* Location: ./application/controllers/admin/vocabulary.php */