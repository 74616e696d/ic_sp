<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exam_lock extends Admin_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('ref_text_model');
		$this->load->model('exam_model');
		$this->load->model('exam_lock_model');
		$this->load->model('member/chapter_lock_model','chapter');
	}
	public function index()
	{
		$data['exam_cat']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['title']='Chapter Lock Management';
		$this->load->blade('admin.chapter_lock',$data);
	}


	function subject_lock_view()
	{
		$data['subj_list']=$this->subject_list();
		$data['title']='Subject Lock Management';
		$this->load->blade('admin.subject_lock', $data);
	}

	function lock_exam_view()
	{
		$data['exam_cat']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['title']='Exam Lock Management (Previous Exam)';
		$this->load->blade('admin.lock_exam_view', $data);
	}


	function exam_list()
	{
		$eid=$this->input->post('eid');
		$exams=$this->ref_text_model->get_ref_text_by_parent_group($eid,5);
		$str='';
		if($exams)
		{
			$str.="<table class='table table-striped table-bordered'>";
			$str.="<thead>";
			$str.="<tr>";
			$str.="<th>Exam Name</th><th>Locked Status</th>";
			$str.="</tr>";
			$str.="</thead>";
			$str.="<tbody>";
			$locked_exams=$this->exam_lock_model->get_locked_exams();
			foreach ($exams as $exm)
			{
				$locked=$this->exam_lock_model->locked($exm->id,$locked_exams);
				$lock_text=$locked?'Locked':'Unlocked';
				$locked_stat=$locked?'0':'1';
				$lock_icon=$locked?'fa fa-lock fa-black':'fa fa-unlock fa-green';
				$lock_style=$locked?'color:#333;':'color:#B9E077;';
				//$exam_name=!empty($exm->ref_id)?ref_text_model::get_text($exm->id):$exm->name;
				$str.="<tr>";
				$str.="<td>{$exm->name}</td>";
				$str.="<td><label class='btn' data-stat='{$locked_stat}'><input type='hidden' name='hdn_locked[]' value='{$exm->id}'><i class='{$lock_icon}'></i>&nbsp;<span>{$lock_text}</span></label></td>";
				$str.="</tr>";	
			}
		$str.="</tbody>";
		$str.="</table>";
		}
		else
		{
			$str.="<p>No Exam Found!!</p>";
		}

		echo $str;
	}

	/**
	 * Save exam to locked exam table
	 * @return void
	 */
	function lock_exam()
	{
		$rid=$this->input->post('rid');
		$this->exam_lock_model->do_lock($rid);
		echo 'ok';
	}

	function subject_list()
	{
		$subjects=$this->ref_text_model->search_ref_text(" where  group_id=3");
		$str='';
		if($subjects)
		{
			$str.="<table class='table table-striped table-bordered'>";
			$str.="<thead>";
			$str.="<tr>";
			$str.="<th>Subjects</th><th>Locked Status</th>";
			$str.="</tr>";
			$str.="</thead>";
			$str.="<tbody>";
			foreach ($subjects as $subj)
			{
				$locked=$this->exam_lock_model->is_locked($subj->id);
				$lock_text=$locked?'Locked':'Unlocked';
				$locked_stat=$locked?'0':'1';
				$lock_icon=$locked?'fa fa-lock fa-black':'fa fa-unlock fa-green';
				$lock_style=$locked?'color:#333;':'color:#B9E077;';
				//$exam_name=!empty($exm->ref_id)?ref_text_model::get_text($exm->ref_id):$exm->test_name;
				$str.="<tr>";
				$str.="<td>{$subj->name}</td>";
				$str.="<td><label class='btn' data-stat='{$locked_stat}'><input type='hidden' name='hdn_locked[]' value='{$subj->id}'><i class='{$lock_icon}'></i>&nbsp;<span>{$lock_text}</span></label></td>";
				$str.="</tr>";	
			}
		$str.="</tbody>";
		$str.="</table>";
		}
		else
		{
			$str.="<p>No Exam Found!!</p>";
		}

		return $str;
	}

	function get_subjects()
	{
		$exam_id=$this->input->get('eid');
		$subjects=$this->ref_text_model->get_subject_of_exam_cat($exam_id);
		//var_dump($subjects);
		$str="<option value='-1'>Select Subject</option>";
		if($subjects)
		{
			foreach ($subjects as $sbj) {
				$str.="<option value='{$sbj->id}'>{$sbj->name}</option>";
			}
		}
		else
		{
			$str.="<option value='-1'>Select Subject</option>";
		}

		echo $str;

	}

	function get_chapter_list()
	{
		$eid=$this->input->post('eid');
		$subj=$this->input->post('subj');
		$str='';
		if($eid!=-1 and $subj!=-1)
		{
			$str=$this->get_chapters($subj);
		}
		echo $str;
	}


	function get_prev_exam($eid)
	{
		$exams=$this->exam_model->get_prev_exam_by_cat($eid);
		$str='';
		if($exams)
		{
			$str.="<table class='table table-bordered table-striped'>";
			$str.="<thead>";
			$str.="<tr>";
			$str.="<th>Prev Exam</th>";
			$str.="<th>Is Locked(Select All<input type='checkbox' id='ck_all'/>)</th>";
			$str.="</tr>";
			$str.="</thead>";
			foreach ($exams as $exm){
				$locked=$this->exam_lock_model->is_locked($exm->id);
				$lock_text=$locked?'Locked':'Unlocked';
				$locked_stat=$locked?'0':'1';
				$lock_icon=$locked?'fa fa-lock fa-black':'fa fa-unlock fa-green';
				$lock_style=$locked?'color:#333;':'color:#B9E077;';
				$str.="<tr>";
				$str.="<td>{$exm->name}</td>";
				$str.="<td><label class='btn' data-stat='{$locked_stat}'>";
				$str.="<input type='hidden' name='hdn_locked[]' value='{$exm->id}'>";
				$str.="<i class='{$lock_icon}'></i>&nbsp;<span>{$lock_text}</span></label></td>";
				$str.="</tr>";
			}
		}

		return $str;
	}

	/**
	 * Get Chapters By Subject
	 * @return [type] [description]
	 */
	function get_chapters($subj)
	{
		$chapter_group=$this->ref_text_model->get_ref_text_by_parent($subj);
		$str="";
		
			if($chapter_group)
			{
				$str.="<table class='table table-bordered table-striped'>";
				$str.="<thead>";
					$str.="<tr>";
					$str.="<th>Chapter</th>";
					$str.="<th>Locked Status</th>";
					$str.="</tr>";
				$str.="</thead>";
				$locked_chapters=$this->chapter->get_locked_chapters();
				foreach ($chapter_group as $cpt_grp) 
				{
					$chapters=$this->ref_text_model->get_ref_text_by_parent($cpt_grp->id);
					if($chapters)
					{
						foreach ($chapters as $cpt) {
							$locked=$this->chapter->is_locked($cpt->id,$locked_chapters);
							$lock_text=$locked?'Locked':'Unlocked';
							$locked_stat=$locked?'0':'1';
							$lock_icon=$locked?'fa fa-lock fa-black':'fa fa-unlock fa-green';
							$lock_style=$locked?'color:#333;':'color:#B9E077;';
							$str.="<tr>";
							$str.="<td>{$cpt->name}</td>";
							$str.="<td><label class='btn' data-stat='{$locked_stat}'><input type='hidden' name='hdn_locked[]' value='{$cpt->id}'><i class='{$lock_icon}'></i>&nbsp;<span>{$lock_text}</span></label></td>";
							$str.="</tr>";
						}
					}
					
				}
				$str.="</table>";
			}
		
			return $str;
	}

	/**
	 * Save chapter lock stat
	 * @return [type] [description]
	 */
	function save_lock_state()
	{
		$rid=$this->input->post('rid');
		$this->chapter->do_lock($rid);
		echo 'ok';
	}

}

/* End of file exam_lock.php */
/* Location: ./application/controllers/admin/exam_lock.php */