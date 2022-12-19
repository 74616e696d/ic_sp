<?php

class Question_assignment extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
        
		$this->load->model('question_bank_model');
		$this->load->model('exam_model');
		$this->load->model('Exam/marks_mapping_model','mmm');
		$this->load->model('ref_text_model');
		$this->load->library('my_validation');
		$this->load->helper('message');
	}

	public function index()
	{
		$data['exams']=$this->exam_model->get_test_name();
		$data['subjects']=$this->ref_text_model->get_ref_text_by_group(3);
		$data['title']='Assign Question';
		$data['main_content']='admin/v_question_assignment';
		$this->load->view('layout_admin/admin_layout', $data);
	}

	function get_chapter_group()
	{
		$sid=$this->input->get('sid');
		$chapter_group=$this->ref_text_model->get_ref_text_by_parent($sid);
		$str="<ul class='list-group cp_gr clr'>";
		if($chapter_group)
		{
			foreach($chapter_group as $s)
			{
				$str.="<li class='list-group-item'>";
				$str.="<button class='btn btn-primary btn-mini' data-val='{$s->id}'>{$s->name}</button>";
				$str.="<input type='text' class='input-mini' value='0'/>";
				$str.="<div class='chapter_group'></div>";
				$str.="</li>";
			}
		}
		$str.="</ul>";
		echo $str;
	}

	function get_topics()
	{
		$eid=$this->input->get('exam_id');
		$parent_items=$this->mmm->get_mapping_top_parent($eid);
		$str='';
		$str.="<ul class='unstyled'>";

		$added_ques=0;
		if($this->exam_model->get_exam_question($eid))
		{
			$ques_arr=explode(',',$this->exam_model->get_exam_question($eid)->ques_id);
			$added_ques=count($ques_arr);
		}

		$cls="badge";

		//level one start
		if($parent_items)
		{
			foreach ($parent_items as $prnt) {
				
				$topics_text=ref_text_model::get_text($prnt->topics);
				$str.="<li>";
				$str.="<span class='btn btn-block sbj' data-val='{$prnt->topics}'>{$topics_text}&nbsp;&nbsp;
			 			&nbsp;&nbsp;&nbsp;&nbsp;Total:<span class='badge badge-success'>{$prnt->marks}</span>&nbsp;&nbsp;
			 			&nbsp;&nbsp;&nbsp;&nbsp;Added:<span class='badge'>{$added_ques}</span></span>";

			 		//level two start
			 		$cgrp=$this->mmm->get_mapping_by_parent($eid,$prnt->topics);
			 		if($cgrp)
			 		{
			 			$str.="<ul style='margin-left:15px' class='unstyled'>";
				 		foreach ($cgrp as $cg) {
				 			$cgrp_text=ref_text_model::get_text($cg->topics);
				 			$str.="<li>";
				 			$str.="<span  class='btn btn-block cpt-group' data-val='{$cg->topics}'>{$cgrp_text}&nbsp;&nbsp;
			 			&nbsp;&nbsp;&nbsp;&nbsp;Total:<span class='badge badge-success'>{$cg->marks}</span>&nbsp;&nbsp;
			 			&nbsp;&nbsp;&nbsp;&nbsp;Added:<span class='badge'>{$cg->marks}</span></span>";
				 			$str.="</li>";

				 			//level three start
				 			$cptr=$this->mmm->get_mapping_by_parent($eid,$cg->topics);
				 			if($cptr)
				 			{
				 				$str.="<ul style='margin-left:15px' class='unstyled'>";
				 				foreach ($cptr as $c) {
				 					$cptr_text=ref_text_model::get_text($c->topics);
				 					$str.="<li>";
				 					$str.="<span class='btn btn-block cpt' data-val='{$c->topics}'>{$cptr_text}&nbsp;&nbsp;
			 					&nbsp;&nbsp;&nbsp;&nbsp;Total:<span class='badge badge-success'>{$c->marks}</span>&nbsp;&nbsp;
			 					&nbsp;&nbsp;&nbsp;&nbsp;Added:<span class='badge'>{$c->marks}</span></span>";
				 					$str.="</li>";
				 				}
				 				$str.="</ul>";
				 			} //level three end
				 		}
				 		$str.="</ul>";
			 		} //Lvel two end
				$str.="</li>";
			}
		} //level one end
		
		$str.="</ul>";
	
		echo $str;
	}

	function assign()
	{

		$exam_id=$this->input->post('ddl_test_name');
		$ques_arr=$this->input->post('ck_ques');

		$questions=implode(',',$ques_arr);
		$data=array('exam_id'=>$exam_id,'ques_id'=>$questions);
		$topics=$this->input->post('hdn_selected_topics');
		$exam=$this->exam_model->find($exam_id);

		$exam_question=$this->exam_model->get_exam_question($exam_id);
		//var_dump($exam_question);
		$exam_ques_arr=explode(',', $exam_question->ques_id);
		//var_dump($exam_ques_arr);
		$count_exam_ques=count($exam_ques_arr);

		$total_ques=count($ques_arr)+$count_exam_ques;
		$est_marks=$this->mmm->get_marks_by_topics($exam_id,$topics);
		if($total_ques<=$exam->total_ques)
		{
			if(count($ques_arr)<=$est_marks->marks)
			{
				if(!exam_model::is_assigned($exam_id))
				{

					$this->exam_model->assign_ques($data);
					$this->session->set_flashdata('success', 'question assigned successfully!');
					redirect(base_url().'admin/question_assignment');
				}
				else
				{
					// $selected_ques_arr=array();
					// foreach ($ques_arr as $q) {
					// 	if(!exam_model::assigned($exam_id,$q))
					// 	{
					// 		array_push($selected_ques_arr,$q);
					// 	}
					// }
					$assigned_question=explode(',',$this->exam_model->get_assigned_question($exam_id)->ques_id);
					 $merged=array_merge($assigned_question,$ques_arr);
					 $unique_arr=array_unique($merged);
					 $upt_data=implode(',',$unique_arr);
					 $update_data=array('exam_id'=>$exam_id,'ques_id'=>$upt_data);
					 var_dump($update_data);
					$this->exam_model->update_assigned_question($exam_id,$update_data);
					$this->session->set_flashdata('success', 'question assignment successfully updated!');
					redirect(base_url().'admin/question_assignment');
				}
			}
			else
			{
				$this->session->set_flashdata('error', 'topics marks cannot exceeds total mapped marks');
				redirect(base_url().'admin/question_assignment');	
			}
			
		}
		else
		{
			$this->session->set_flashdata('error', 'question cannot exceeds total estimated question');
			redirct(base_url().'admin/question_assignment');
		}
		
	}

	function get_chapters()
	{
		$cid=$this->input->get('cid');
		$chapter=$this->ref_text_model->get_ref_text_by_parent($cid);
		$str="<ul class='cp clr_cp'>";
		if($chapter)
		{
			foreach($chapter as $s)
			{
				$str.="<li>";
				$str.="<button class='btn btn-info btn-mini' data-val='{$s->id}'>{$s->name}</button>";
				$str.="<input type='text' class='input-mini' value='0'/>";
				$str.="</li>";
			}
		}
		$str.="</ul>";
		echo $str;
	}


	function question_list_by_subject()
	{
		$sbj_id=$this->input->get('sbj_id');
		$term='where subject='.$sbj_id;
		$ques=$this->question_bank_model->get_questions($term);

		$eid=$this->input->get('exam_id');
		$assigned_question=$this->exam_model->get_assigned_question($eid);
		$assign_ques_arr=explode(',',$assigned_question->ques_id);
		$str='';
		if($ques)
		{
			$total=count($ques);
			$str.="<ul class='list-group'>";
			$str.="<li style='background:#0088CC;color:#fff;' id='ck_all' class='list-group-item'><label class='checkbox'><input class='pull-left' type='checkbox' id='check_all'/>&nbsp;Select All</label><span class='badge'>{$total}</span><span id='ck_sel' class='badge'>0</span></li>";
			foreach ($ques as $q) {
				$stripped_ques=strip_tags($q->question,'img');
				$checked='';
				if(count($assign_ques_arr))
				{
					$checked=in_array($q->id,$assign_ques_arr)?'checked':'';
				}
				
				$str.="<li class='list-group-item'>";
				$str.="<label class='checkbox'><input class='pull-left ck' name='ck_ques[]' {$checked}  type='checkbox' value='{$q->id}'>{$stripped_ques}</label>";
				$str.="</li>";
			}
			$str.="</ul>";
			$str.="<button style='margin-left:27px;' type='submit' class='btn btn-info'><i class='icon icon-ok-circle icon-white'></i>Save</button>";
		}
		else
		{
			$str='';
		}

		echo $str;
	}


	function question_list_by_chapter_group()
	{
		$cg_id=$this->input->get('cg_id');
		$term='where chapter_group='.$cg_id;
		$ques=$this->question_bank_model->get_questions($term);

		$eid=$this->input->get('exam_id');
		$assigned_question=$this->exam_model->get_assigned_question($eid);
		$assign_ques_arr=explode(',',$assigned_question->ques_id);
		//var_dump($ques);
		$str='';
		if($ques)
		{
			$total=count($ques);
			$str.="<ul class='list-group'>";
			$str.="<li style='background:#0088CC;color:#fff;' id='ck_all' class='list-group-item'><label class='checkbox'><input class='pull-left' type='checkbox' id='check_all'/>&nbsp;Select All</label><span class='badge'>{$total}</span><span id='ck_sel' class='badge'>0</span></li>";
			foreach ($ques as $q) {
				$stripped_ques=strip_tags($q->question,'img');
				$checked='';
				if(count($assign_ques_arr))
				{
					$checked=in_array($q->id,$assign_ques_arr)?'checked':'';
				}

				$str.="<li class='list-group-item'>";
				$str.="<label class='checkbox'><input class='pull-left ck' name='ck_ques[]' {$checked}  type='checkbox' value='{$q->id}'>{$stripped_ques}</label>";
				$str.="</li>";
			}
			$str.="</ul>";
			$str.="<button style='margin-left:27px;' type='submit' class='btn btn-info'><i class='icon icon-ok-circle icon-white'></i>Save</button>";
		}
		else
		{
			$str='';
		}

		echo $str;
	}



	function question_list_by_chapter()
	{
		$cptr_id=$this->input->get('cptr');
		$term='where chapter='.$cptr_id;
		$ques=$this->question_bank_model->get_questions($term);

		$eid=$this->input->get('exam_id');
		$assigned_question=$this->exam_model->get_assigned_question($eid);
		$assign_ques_arr=explode(',',$assigned_question->ques_id);
		//var_dump($ques);
		$str='';
		if($ques)
		{
			$total=count($ques);
			$str.="<ul class='list-group'>";
			$str.="<li style='background:#0088CC;color:#fff;' id='ck_all' class='list-group-item'><label class='checkbox'><input class='pull-left' type='checkbox' id='check_all'/>&nbsp;Select All</label><span class='badge'>{$total}</span><span id='ck_sel' class='badge'>0</span></li>";
			foreach ($ques as $q) {
				$stripped_ques=strip_tags($q->question,'img');

				$checked='';
				if(count($assign_ques_arr))
				{
					$checked=in_array($q->id,$assign_ques_arr)?'checked':'';
				}

				$str.="<li class='list-group-item'>";
				$str.="<label class='checkbox'><input class='pull-left ck' name='ck_ques[]' {$checked} type='checkbox' value='{$q->id}'>{$stripped_ques}</label>";
				$str.="</li>";
			}
			$str.="</ul>";
			$str.="<button style='margin-left:27px;' type='submit' class='btn btn-info'><i class='icon icon-ok-circle icon-white'></i>Save</button>";
		}
		else
		{
			$str='';
		}

		echo $str;
	}

	function get_questions()
	{
		$ques=$this->question_bank_model->question_by_key('');
		$qlist=array();
		foreach ($ques as $q) {
			$ql=strip_tags($q->question,'img');
			array_push($qlist,array('ques'=>$ql));
		}
		echo json_encode($qlist);
	}

	function refresh()
	{
		$eid=$this->input->post('eid');
		if($eid!=-1)
		{
			$this->exam_model->refresh_assigned_question($eid);
			$this->exam_model->find_duplicate_qid($eid);
		}
	}

}

/* End of file question_assignment.php */
/* Location: ./application/controllers/admin/question_assignment.php */