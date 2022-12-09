<?php

class Reported extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('question_bank_model');
	}
	public function index()
	{
		$id=$this->uri->segment(4);
		$ques=$this->question_bank_model->question_by_id($id);

		$str="";
		if($ques)
		{
			$ques_plain=strip_tags($ques->question,'<img>');	
			$str.="<li class='list-group-item list-ques'>{$ques_plain}</li>";

			$option=explode("///",$ques->options);
			if(count($option)>0)
			{
				$srl=range('A','E');
				$i=0;
				foreach ($option as $opt) {
					$opt_plain=strip_tags($opt,'<img>');
					$correct=substr(trim($opt_plain),0,2)=="@@"?true:false;
					if($correct)
					{
						$ans=str_replace('@@','',$opt_plain);
						$str.="<li class='list-group-item list-ans correct-ans'>{$srl[$i]}.&nbsp;{$ans}</li>";
					}
					else
					{
						$str.="<li class='list-group-item list-ans'>{$srl[$i]}.&nbsp;{$opt_plain}</li>";
					}
					$i++;
				}
			}

		}

		$data['question']=$str;
		$data['title']='Reported Question By Member';
		$this->load->blade('admin.reported', $data);
	}

}

/* End of file reported.php */
/* Location: ./application/controllers/admin/reported.php */