<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subject_wise_result extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('report/common_model','common');
		$this->load->model('report/subject_wise_result_model','result');
		$this->load->model('question_bank_model','qbm');
		$this->load->model('ref_text_model');
	}
	public function index()
	{
		$id=$this->uri->segment(4);
		$time=$this->uri->segment(6);
		$user=0;
		if($this->session->userdata('userid'))
		{
			$user=$this->session->userdata('userid');
		}
		
		$subjects_id=$this->common->get_exam_subjects($id);
		$user_ans_sheet=$this->common->get_answer_sheet_by_date($id,$user,$time);

		//for categories of chart
		$sbj_arr=array();
		//$sbj_mrk_arr=array();
		$subject_list='[';
		if($subjects_id)
		{
			foreach ($subjects_id as $sbj) 
			{
				$sbj_txt=ref_text_model::get_text($sbj->topics);
				$subject_list.="'{$sbj_txt}',";
				array_push($sbj_arr,array('topics'=>$sbj->topics,'mark'=>$sbj->marks));
			}
		}
		$subject_list.=']'; //end for categories of chart

		
		$correct_answer_arr=array();
		$wrong_answer_arr=array();
		if($user_ans_sheet){
			foreach ($user_ans_sheet as $sheet) 
			{
				$question=$this->qbm->question_by_id($sheet->question_id);
				$answer=explode(',',$question->options);
				if(count($answer)>0)
				{
					foreach($answer as $a)
					{
						$strip_ans=trim(strip_tags($a,'<img>'));
						$correct=substr($strip_ans,0,2)=="@@"?true:false;
						if($correct)
						{
							array_push($correct_answer_arr,array('subject'=>$question->subject,
								'qid'=>$question->id));
						}
						else
						{
							array_push($wrong_answer_arr,array('subject'=>$question->subject,
								'qid'=>$question->id));
						}
					}
				}
			}
		}

		$correct_answer="[";
		$wrong_answer="[";
		if(count($sbj_arr)>0)
		{
			foreach ($sbj_arr as $sbj)
			{
				$ttl_correct=count($this->filter_subject($correct_answer_arr,$sbj['topics']));
				$correct_answer.=($ttl_correct*100)/$sbj['mark'].",";

				$ttl_wrong=count($this->filter_subject($wrong_answer_arr,$sbj['topics']));
				$wrong_answer.=($ttl_wrong*100)/$sbj['mark'].",";

			}
		}
		$wrong_answer.="]";
		$correct_answer.="]";

		$data['correct']=$correct_answer;
		$data['wrong']=$wrong_answer;
		$data['title']='Subject Wise Result';
		$data['subject_list']=$subject_list;
		//$data['main_content']='report/v_subject_wise_result';
		//$this->load->view('layout/layout', $data);
		$this->load->blade('report.v_subject_wise_result', $data);
	}
	function filter_subject($arr,$sbj)
	{
		$filtered=array_filter($arr,function($var)use($sbj)
		{
			return (is_array($var) && $var['subject'] == $sbj);
		});
		return $filtered;
	}

}

/* End of file subject_wise_result.php */
/* Location: ./application/controllers/report/subject_wise_result.php */