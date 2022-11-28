<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit_marks_mapping extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('message');
		$this->load->model('Exam/marks_mapping_model','mmm');
		$this->load->model('ref_text_model');
	}

	public function index()
	{
		$id=$this->uri->segment(4);
		$data['subject']=$this->ref_text_model->get_ref_text_by_group(3);
		$data['exam_cat']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['test_types']=$this->ref_text_model->get_ref_text_by_group(7);
		$data['test']=$this->mmm->find($id);
		$this->load->view('admin/v_edit_marks_mapping', $data);
	}


	function edit()
	{
		$exam_id=$this->input->post('ddl_exam_list');
		$subject=$this->input->post('ddl_subject');
		$chapter_group=$this->input->post('ddl_chapter_group');
		$chapter=$this->input->post('ddl_chapter');
		//echo "subject={$subject}\nchapter_group={$chapter_group}\nchapter={$chapter}\n";
		$marks=$this->input->post('txt_marks');
		$parent=0;
		$topics=0;
		if($chapter==-1 && $chapter_group==-1){
			$parent=0;
			$topics=$subject;
		}
		else if($chapter==-1 && $chapter_group!=-1)
		{
			$parent=$subject;
			$topics=$chapter_group;
		}
		else if($chapter_group!=-1 && $chapter!=-1)
		{
			$parent=$chapter_group;
			$topics=$chapter;
		}
		
		$data=array('exam_id'=>$exam_id,
			'parent'=>$parent,
			'topics'=>$topics,
			'marks'=>$marks);
		if($subject!=-1)
		{
			$ttl_mrk=$this->exam_model->get_total_marks($exam_id);
			//echo $ttl_mrk."  ".$subject;
			if($marks<=$ttl_mrk)
			{

				if($this->mmm->check_topics($exam_id,$topics))
				{
					$this->session->set_flashdata('error', 'this topics already mapped!');
					redirect(base_url().'admin/add_exam');
				}
				else
				{
					$this->mmm->add($data);
					$this->session->set_flashdata('success', 'marks mapped successfully!');
					redirect(base_url().'admin/add_exam');
				}
			}
			else
			{
				$this->session->set_flashdata('error', 'subject marks cannot exceeds exam total marks!');
				redirect(base_url().'admin/add_exam');
			}
		}
		else
		{
			$this->session->set_flashdata('error', 'you must select a topics!');
			redirect(base_url().'admin/add_exam');
		}
	}

}

/* End of file edit_marks_mapping.php */
/* Location: ./application/controllers/admin/edit_marks_mapping.php */