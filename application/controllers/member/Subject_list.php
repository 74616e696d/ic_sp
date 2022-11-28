<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subject_list extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('exam_model');
		$this->load->model('exam_lock_model');
		$this->load->model('ref_text_model');
		$this->load->model('Exam/choosen_category_model','choosen');
	}

	public function index()
	{
		$cats=$this->ref_text_model->all_by('group_id',2);
		$data['subjects']=$this->subj_list(7);
		$data['cats']=$cats;
		$data['title']='Subject Quiz';
		$this->load->blade('member.subject_list', $data);
	}


	function subj_list($category)
	{
		$subjects=$this->ref_text_model->get_subject_of_exam_cat($category);

		// if($this->utype!='101' && $this->utype!='102')
		// {
		// 	$choosen=array();
		// 	$choosen_list=$this->choosen->get_choosen($this->userid);
		// 	if($choosen_list)
		// 	{
		// 		foreach ($choosen_list as $c) {
		// 			array_push($choosen,$c->exam_cat);
		// 		}
		// 	}

		// 	$subjects=$this->exam_model->get_subjects($choosen);

		// }
		// else
		// {
		// 	$subjects=$this->exam_model->get_subjects();
		// }

		//var_dump($subjects);

		$str='';
		if($subjects)
		{
			$str.="<table class='table table-striped table-bordered'>";
			$str.="<thead>";
			$str.="<tr>";
			$str.="<th>Subject</th><th>Action</th>";
			$str.="</tr>";
			$str.="</thead>";
			$str.="<tbody>";
			foreach ($subjects as $sbj) 
			{
				$url="<a target='_blank' class='btn btn-sm btn-primary' href='".base_url()."member/subject_quiz/index/{$sbj->id}'>Start</a>";
				$locked=false;
				if($this->utype!='101'  && $this->utype!='102')
				{
				$locked=$this->exam_lock_model->is_locked($sbj->id);
				}
				if($locked)
				{
					$url="<a target='_blank' class='btn btn-sm btn-primary' href='".base_url()."public/upgrade'><i class='fa fa-lock'></i>&nbsp;Start</a>";
				}
				$str.="<tr>";
				$str.="<td>{$sbj->name}</td>";
				$str.="<td>{$url}</td>";
				$str.="</tr>";
			}
			$str.="</tbody>";
			$str.="</table>";
		}

		return $str;
	}


	function get_subjects()
	{
		$cat=$this->input->post('cat');
		$list=$this->subj_list($cat);
		echo $list;
	}



}

/* End of file subject_list.php */
/* Location: ./application/controllers/member/subject_list.php */