<?php

class Chapter_media extends Admin_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('ref_text_model');
		$this->load->model('chapter_media_model');
		$this->load->model('membership_model');
	}
	public function index()
	{
		$data['media']=$this->chapter_media_model->all();
		$data['exams']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['chapters']=$this->ref_text_model->get_ref_text_by_group(4);
		$data['title']='Manage Chapter Media';
		$this->load->blade('admin.chapter_media', $data);
	}

	function create()
	{
		$data['members']=$this->membership_model->get_members();
		$data['exams']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['chapters']=$this->ref_text_model->get_ref_text_by_group(4);
		$data['title']='Manage Chapter Media';
		$this->load->blade('admin.create_chapter_media', $data);
	}

	function store()
	{
		$chapter=$this->input->post('ddl_chapter');
		$media=$this->input->post('txt_media');
		$role=$this->input->post('ddl_role');
		$display=$this->input->post('ck_display');
		if($chapter!=-1)
		{
			if(!empty($media))
			{
				$data=array('chapter_id'=>$chapter,
					'media_url'=>$media,
					'role'=>$role,
					'display'=>$display);
				$this->chapter_media_model->add($data);
				$this->session->set_flashdata('success', 'successfully added!');
				redirect(base_url().'admin/chapter_media');
			}
			else
			{
				$this->session->set_flashdata('warning', 'Media cannot be empty');
				redirect(base_url().'admin/chapter_media/create');
			}
		}
		else
		{
			$this->session->set_flashdata('warning', 'You must select chapter');
			redirect(base_url().'admin/chapter_media/create');
		}
	}

	function show()
	{
		$id=$this->uri->segment(4);
		$data['members']=$this->membership_model->get_members();
		$data['media']=$this->chapter_media_model->find($id);
		$data['exams']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['chapters']=$this->ref_text_model->get_ref_text_by_group(4);
		$data['edit_id']=$id;
		$data['title']='Edit Chapter Media';
		$this->load->blade('admin.edit_chapter_media', $data);
	}

	function update()
	{
		$id=$this->input->post('hdn_id');
		$chapter=$this->input->post('ddl_chapter');
		$media=$this->input->post('txt_media');
		$role=$this->input->post('ddl_role');
		$display=$this->input->post('ck_display');
		if($chapter!=-1)
		{
			if(!empty($media))
			{
				$data=array('chapter_id'=>$chapter,
					'media_url'=>$media,
					'role'=>$role,
					'display'=>$display);
				$this->chapter_media_model->update($id,$data);
				$this->session->set_flashdata('success', 'successfully added!');
				redirect(base_url().'admin/chapter_media');
			}
			else
			{
				$this->session->set_flashdata('warning', 'Media cannot be empty');
				redirect(base_url().'admin/chapter_media/create');
			}
		}
		else
		{
			$this->session->set_flashdata('warning', 'You must select chapter');
			redirect(base_url().'admin/chapter_media/create');
		}
	}

	function destroy()
	{
		$id=$this->uri->segment(4);
		$this->chapter_media_model->destroy($id);
		$this->session->set_flashdata('success', 'successfully deleted!');
		redirect(base_url().'admin/chapter_media');
	}
}

/* End of file chapter_media.php */
/* Location: ./application/controllers/admin/chapter_media.php */