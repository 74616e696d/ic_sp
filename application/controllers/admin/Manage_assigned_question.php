<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_assigned_question extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('ref_text_model');
		$this->load->model('question_bank_model');
		$this->load->model('exam_model');
	}
	public function index()
	{
		$ques_list='';
		if($this->input->get('eid'))
		{
			$eid=$this->input->get('eid');
			$ques_list=$this->ques_list($eid);
		}
		$data['ques_list']=$ques_list;
		$data['exams']=$this->exam_model->get_test_name();
		$data['title']='Manage Assigned Question';
		$this->load->blade('admin.v_manage_assigned_question', $data);

	}


	function ques_list($eid)
	{
		$qlist=$this->exam_model->get_exam_question($eid);
		$str='';
		if($qlist)
		{
			$question_id=!empty($qlist->ques_id)?rtrim($qlist->ques_id,','):false;
			$ques=$question_id?explode(',',$question_id):[];
			$str.="<ul class='list-group'>";
			if(count($ques)>0)
			{
				foreach ($ques as $q) 
				{
					$qtext=question_bank_model::ques_text($q);
					$qplain=strip_tags($qtext,'<img>');
					$str.="<li class='list-group-item'>";
					
					$str.="{$qplain}";
					$str.="<a onClick='deleteQues({$q},{$eid})' style='float:right;cursor:pointer;'/><i class='fa fa-trash-o'></i></a>&nbsp;&nbsp;&nbsp;";
					$str.="</li>";
				}
			}
			$str.="</ul>";
		}
		return $str;
	}

	function remove()
	{
		$qid=$this->uri->segment(4);
		$eid=$this->uri->segment(5);
		$qlist=$this->exam_model->get_exam_question($eid);
		$ques='';
		if($qlist)
		{
			$ques=!empty($qlist->ques_id)?explode(',',$qlist->ques_id):false;
			if($ques)
			{
				$i=0;
				$deleted=false;
				foreach ($ques as $q) {
					if($q==$qid)
					{
						if(!$deleted)
						{
							unset($ques[$i]);
							$deleted=true;
						}
					}

					$i++;
				}
			}
			
		}

		$ques_str='';
		if(count($ques)>0)
		{
			$ques_str=implode(',',$ques);
		}
		$this->exam_model->update_assigned_question($eid,array('ques_id'=>$ques_str));

		redirect(base_url().'admin/manage_assigned_question/index?eid='.$eid);

	}

}

/* End of file manage_assigned_question.php */
/* Location: ./application/controllers/admin/manage_assigned_question.php */