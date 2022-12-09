<?php

class Modeltest extends Admin_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('model_test_model');
		$this->load->model('model_test_question_model');
		$this->load->model('ref_text_model');
		$this->load->model('question_bank_model');
		$this->load->model('roadmap_model');
		$this->load->model('roadmap_details_model');
		$roles=array('101','102');
		membership_model::is_authenticate($roles);
	}
	public function index()
	{
		$data['category']=$this->ref_text_model->where(array('group_id|='=>2))->get();
		$modeltest=false;
		if($this->input->post('search'))
		{
			$category=$this->input->post('category');
			$modeltest=$this->model_test_model->all_by('category',$category);
		}
		else
		{
			$modeltest=$this->model_test_model->all();
		}

		$data['modeltest']=$modeltest;
		$data['title']='Manage Model Test';
		$this->load->blade('admin.modeltest.index', $data);
	}


	function qlist()
	{
		$id=$this->uri->segment(4);
		$questions=$this->model_test_model->get_test_ques($id);
		$str="";
		if($questions)
		{
			foreach ($questions as $ques) 
			{
				$assigned=$this->model_test_question_model->is_assigned($id,$ques->id);
				// $cked=$assigned?'checked':false;
				$list_class=$assigned?'list-group-item selected-option':'list-group-item';
				$striped_ques=strip_tags(trim($ques->question),'<img>');
				$str.="<li class='{$list_class}'>";
				$str.="<input class='pull-left' type='checkbox' name='ck_ques[]' value='{$ques->mqid}'>";
				$str.="&nbsp;{$striped_ques}</li>";
			}

		}
		$data['has']=count($questions)>0?true:false;
		$data['questions']=$str;

		$data['title']='Assigned Question List';
		$this->load->blade('admin.modeltest.qlist', $data);
	}

	function remove_ques()
	{
		$question=$this->input->post('ck_ques');
		// var_dump($question);
		if($question)
		{
			foreach ($question as $q) {
				$this->model_test_question_model->delete($q);
			}
		}
		$this->session->set_flashdata('success', 'selected question unaasigned from this test');
		redirect(base_url()."admin/modeltest");
	}

	function create()
	{
		$data['category']=$this->ref_text_model->where(array('group_id|='=>2))->get();
		$data['title']='';
		$this->load->blade('admin.modeltest.create', $data);
	}

	function assign_ques()
	{
		$data['test_id']=$this->uri->segment(4);
		$data['category']=$this->ref_text_model->where(array('group_id|='=>2))->get();
		//$data['model_test']=$this->model_test_model->all
		$data['title']='Assign Question To Model Test';
		$this->load->blade('admin.modeltest.assign_question', $data);
	}

	function show()
	{
		$id=$this->uri->segment(4);
		$data['test']=$this->model_test_model->find($id);
		$data['title']='Edit Model Test';
		$this->load->blade('admin.modeltest.show', $data);
	}

	function update()
	{
		$id=$this->input->post('hdn_id');
		$name=$this->input->post('exam');
		$details=$this->input->post('details');
		$marks_carry=$this->input->post('marks_carry');
		$total_ques=$this->input->post('total_ques');
		$paid=$this->input->post('ck_paid');
		$time=$this->input->post('time');
		$display=$this->input->post('ck_display');
		if(!empty($name))
		{
			$data=array('name'=>$name,
				'details'=>$details,
				'marks_carry'=>$marks_carry,
				'total_ques'=>$total_ques,
				'is_paid'=>$paid,
				'time'=>$time,
				'display'=>$display);
			$this->model_test_model->update($id,$data);
			$this->session->set_flashdata('success', 'Model test updated successfully!!');
			redirect(base_url()."admin/modeltest");
		}
		else
		{
			$this->session->set_flashdata('error', 'Model test name must be given!!');
			redirect(base_url()."admin/modeltest/show/{{$id}}");
		}
	}

	function store_ques()
	{
		$ques=$this->input->post('ck_ques');
		$test_id=$this->input->post('hdn_test_id');
		$model_test=$this->model_test_model->find($test_id);
		if($ques)
		{
			if($this->model_test_question_model->get_total($test_id)<$model_test->total_ques)
			{
				foreach ($ques as $q) 
				{
					$data=array('test_id'=>$test_id,
						'qid'=>$q);
					if(!$this->model_test_question_model->is_assigned($test_id,$q))
					{
						$this->model_test_question_model->create($data);
					}
				}
				$this->session->set_flashdata('success', 'Questions assigned successfully!');
				redirect(base_url()."admin/modeltest");
			}
			else
			{
				$this->session->set_flashdata('error', 'Total question exceeded!');
				redirect(base_url()."admin/modeltest");
			}
		}
	}

	function store()
	{
		$category=$this->input->post('category');
		$exam=$this->input->post('exam');
		$details=$this->input->post('details');
		$marks_carry=$this->input->post('marks_carry');
		$total_ques=$this->input->post('total_ques');
		$paid=$this->input->post('ck_paid');
		$time=$this->input->post('time');
		$display=$this->input->post('ck_display');

		if($category!=-1)
		{
			$data=array(
				'category'=>$category,
				'name'=>$exam,
				'details'=>$details,
				'marks_carry'=>$marks_carry,
				'total_ques'=>$total_ques,
				'time'=>$time,
				'is_paid'=>$paid,
				'display'=>$display
				);
			$this->model_test_model->create($data);
			$this->session->set_flashdata('success', 'Model test created successfully');
			redirect(base_url().'admin/modeltest/create');
		}
		else
		{
			$this->session->set_flashdata('error', 'Category must be selected');
			redirect(base_url().'admin/modeltest/create');
		}
	}

	function marks_mapping()
	{
		$data['category']=$this->ref_text_model->where(array('group_id|='=>2))->get();
		$data['title']='Exam Marks Mapping';
		$this->load->blade('admin.modeltest.marks_mapping', $data);
	}

	/**
	 * search previous exams by exam category
	 * @return void
	 */
	function filter_prev_exam()
	{
		$id=$this->input->get('category');
		$exams=$this->ref_text_model->get_ref_text_by_parent_group($id,5);
		$str="<option value='-1'>Select Prev Exam</option>";
		if($exams)
		{
			foreach ($exams as $exam) {
				$str.="<option value='{$exam->id}'>{$exam->name}</option>";
			}
		}
		echo $str;
	}

	function filter_subject()
	{
		$id=$this->input->get('category');
		$subjects=$this->ref_text_model->get_subject_of_exam_cat($id);
		$str="<option value='-1'>Select Subject</option>";
		if($subjects)
		{
			foreach ($subjects as $subj) {
				$str.="<option value='{$subj->id}'>{$subj->name}</option>";
			}
		}
		echo $str;
	}

	function filter_chapter()
	{
		$sid=$this->input->get('subject');
		$chapter_group=$this->ref_text_model->get_ref_text_by_parent_group($sid,6);
		$str="<option value='-1'>Select Chapter</option>";
		if($chapter_group)
		{
			foreach ($chapter_group as $cgrp) 
			{
				$chapter=$this->ref_text_model->get_ref_text_by_parent_group($cgrp->id,4);
				if($chapter)
				{
					foreach ($chapter as $chp) {
						$str.="<option value='{$chp->id}'>{$chp->name}</option>";
					}
				}
			}
		}
		echo $str;
	}

	function ques_list()
	{
		$category=$this->input->get('category');
		$exam=$this->input->get('exam');
		$subject=$this->input->get('subject');
		$chapter=$this->input->get('chapter');
		$test_id=$this->input->get('tid');

		$searchStr=' where';
		$key='';
		if($exam!=-1)
		{
		    $searchStr.=" FIND_IN_SET(id,(select ques_id from exam_question where exam_id={$exam})) and ";
		}

		if($subject!=-1)
		{
		    $searchStr.=" subject={$subject} and ";
		}

		if($chapter!=-1)
		{
		    $searchStr.=" chapter={$chapter} and ";
		}
		
		if($searchStr!=' where')
		{
		    $key.=substr($searchStr,0,strlen($searchStr)-4);
		}

		// $key=" where chapter={$chapter}";
		$questions=$this->question_bank_model->get_questions($key);
		$str="";
		if($questions)
		{
			foreach ($questions as $ques) 
			{
				$assigned=$this->model_test_question_model->is_assigned($test_id,$ques->id);
				$cked=$assigned?'checked':false;
				$list_class=$assigned?'list-group-item selected-option':'list-group-item';
				$striped_ques=strip_tags(trim($ques->question),'<img>');
				$str.="<li class='{$list_class}'>";
				$str.="<input class='pull-left' {$cked} type='checkbox' name='ck_ques[]' value='{$ques->id}'>";
				$str.="&nbsp;{$striped_ques}</li>";
			}

		}
		echo $str;
	}


	/**
	 * display roadmap view on modal
	 * @return void
	 */
	function roadmap_view()
	{
		$data['test_id']=$this->uri->segment(4);
		$data['test_cat']=$this->uri->segment(5);
		$data['title']='Manage Roadmap';
		$this->load->blade('admin.modeltest.roadmap', $data);
	}


	function save_roadmap()
	{
		$test_id=$this->input->post('hdn_test_id');
		$test_cat=$this->input->post('hdn_test_cat');
		$name=$this->input->post('name');
		$subject=$this->input->post('subject');
		$chapter=$this->input->post('chapter');
		$display=$this->input->post('display');
		$date=$this->input->post('date');

		if(!empty($subject) && count($chapter)>0 && !empty($date))
		{
			$data=[
			'category'=>$test_cat,
			'exam_name'=>$name,
			'test_id'=>$test_id,
			'study'=>$test_id,
			'exam_date'=>date('Y-m-d',strtotime($date))
			];
			$id=$this->roadmap_model->create($data);

			if(count($chapter)>0)
			{
				foreach($chapter as $cpt)
				{
					$data_details=[
					'roadmap_id'=>$id,
					'subj_id'=>$subject,
					'topics'=>$cpt
					];

					$this->roadmap_details_model->create($data_details);
				}
			}

			echo '1';
		}
		else
		{
			echo 0;
		}
	}

}

/* End of file modeltest.php */
/* Location: ./application/controllers/admin/modeltest/modeltest.php */