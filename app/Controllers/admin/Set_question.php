<?php

class Set_question extends Admin_Controller {
	public function __construct() 
	{
			 
		parent::__construct(); 

		$this->load->helper('message');
		$this->load->model('question_model');
	}	

	public function index()
	{
		$data['exams']=$this->question_model->ref_text_get_exam_all();
		$data['title']='Questions';
		$data['main_content']='admin/v_set_question';
		$this->load->view('layout_admin/admin_layout',$data);
				
	}
	function insert()
	{
		$question=$this->input->post('txt_ques');
		$exam=$this->input->post('ddl_exam');
		$period=$this->input->post('txt_priod');
		$subject=$this->input->post('ddl_subject');
		$chapter=$this->input->post('ddl_chapter');
		$marks=$this->input->post('txt_mark');
		$insertted_from_ip='';
		$question_by=$this->input->post('txt_ques_by');
		$display=$this->input->post('ck_display');
		$data=array('question'=>$question,
		'exam'=>$exam,
		'period'=>$period,
		'subject'=>$subject,
		'chapter'=>$chapter,
		'marks'=>$marks,
		'inserted_from_ip'=>$insertted_from_ip,
		'display'=>$display);
		if(!empty($question))
		{
			if($exam>0)
			{
				if($subject>0)
				{
					if($chapter>0)
					{
						if($_POST['btn_save']=='1')
						{
								$this->question_model->insert_prev_question($data);
								redirect(base_url().'admin/manage_prev_question');
						}
						if($_POST['btn_save_new']=='2')
						{
								$this->question_model->insert_prev_question($data);
								$this->session->set_flashdata('success','successfully inserted!');
								redirect(base_url().'admin/set_question');
						}
						
					}else{
						$this->session->set_flashdata('error','Chapter must be selected!');
						redirect(base_url().'admin/set_question');
					}
					
				}else
				{
					$this->session->set_flashdata('error','Subject must be selected!');
					redirect(base_url().'admin/set_question');
				}
				
			}else{
				$this->session->set_flashdata('error','Exam must be selected!');
				redirect(base_url().'admin/set_question');
			}
		}
		else
		{
			$this->session->set_flashdata('error','Question cannot be empty!');
			redirect(base_url().'admin/set_question');
		}
	
		
	}
	function get_subject()
	{
		$parent=$this->input->post('eid');
		$subjects=$this->question_model->ref_text_get_subject_by_parent($parent);
		$str='';
		$str.='<option value="-1">-Select Subject-</option>';
		foreach($subjects as $sub)
		{
			$str.='<option value="'.$sub->id.'">'.$sub->name.'</option>';
		}
		echo $str;
	}

	function get_chapter()
	{
		$prnt=$this->input->post('prnt');
		$chapters=$this->question_model->ref_text_get_chapter_by_parent($prnt);
		$str='';
		$str.='<option value="-1">-Select Chapter-</option>';
		foreach($chapters as $cptr)
		{
			$str.='<option value="'.$cptr->id.'">'.$cptr->name.'</option>';
		}
		echo $str;
	}
}
	
	