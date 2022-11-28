<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Written extends Member_controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('member/written_ques_model','written');
		$this->load->model('member/written_ques_ans_model','ans');
		$this->load->model('exam_model');
		$this->load->model('ref_text_model');
	}
	public function index()
	{
		$exam=$this->uri->segment(4);
		$list=$this->question_list($exam);

		$data['exam_name']=exam_model::get_text($exam);
		$data['list']=$list;
		$data['title']='Written';
		$this->load->blade('member.written', $data);
	}

	function question_list($exam_id)
	{
		$questions=$this->written->get_written_ques($exam_id);
		$str='';
		if($questions)
		{
			$i=1;
			foreach ($questions as $q) 
			{
				$ques=strip_tags($q->question,'<hr><br/><p><div><strong><b><i><u><sub><sup><img><i><b><u><sub><sup>');
				$str.="<li class='list-group-item list-ques'><b>{$i}.</b>  {$ques}</li>";

				$ans=strip_tags($q->answer,'<hr><br/><p><div><i><u><strong><b><sub><sup><img><i><b><u><sub><sup>');

				$str.="<li class='list-group-item list-ans'><b>Answer:</b>{$ans}</li>";
				$i++;
			}
		}
		else
		{
			$str.="<li class='list-group-item'>No Question Found !!</li>";
		}
		return $str;
	}

}

/* End of file writtem.php */
/* Location: ./application/controllers/member/writtem.php */