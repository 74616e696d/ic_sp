<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Result_details extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('answer_summery_model');
		$this->load->model('answer_sheet_model');
		$this->load->model('exam_model');
		$this->load->model('ref_text_model');
	}

	public function index()
	{
		//$this->output->enable_profiler(true);
		$track_id=$this->uri->segment(4);
		$track_arr=explode('_',$track_id);
		$exam_name=exam_model::get_text(count($track_arr)>2?$track_arr[1]:0);
		$data['result']=$this->get_details();
		$data['exam_name']=$exam_name;
		$data['title']='Result Details';
		$this->load->blade('member.result_details',$data);

	}


	function get_details()
	{
		$quiz_id=$this->uri->segment(4);
		$user=$this->userid;

		$quiz=$this->answer_sheet_model
		->where(array('test_track_id|='=>$quiz_id,'user_id|='=>$user))
		->join_get(array('answer_sheet.*','qb.question','qb.options'),array('question_bank qb'=>'qb.id|answer_sheet.question_id'));

		$str='';
		//var_dump($quiz);
		if($quiz)
		{
			$i=1;
			$str.="<ul class='list-group'>";
			foreach ($quiz as $q) 
			{
			 //die(var_dump($q->options));
				$q_plain=strip_tags($q->question,'<img>');
				$str.="<li class='list-group-item'>{$i}. {$q_plain}</li>";
				$options=explode('///',trim($q->options));
				$rng_opt=range('A','E');
				
				$j=0;
				foreach ($options as $opt) {
					$opt_plain=strip_tags(trim($opt),'<img><u><sub><sup><i><b>');
					$correct=substr(trim($opt_plain),0,2)=="@@"?true:false;
					$wrong=$q->answer==$rng_opt[$j]?true:false;
					$opt_sl=$rng_opt[$j];
					if($correct)
					{
						$correct_ans=str_replace('@@','',trim($opt_plain));
						$str.="<li class='list-option correct'>{$opt_sl}.  {$correct_ans}</li>";
					}
					else if($wrong)
					{
						$str.="<li class='list-option wrong'>{$opt_sl}.  {$opt_plain}</li>";
					}
					else
					{
						$str.="<li class='list-option'>{$opt_sl}.  {$opt_plain}</li>";
					}
					$j++;
				}
				$i++;
			}
			$str.="</ul>";
		}

		return $str;

	}

}

/* End of file result_details.php */
/* Location: ./application/controllers/member/result_details.php */