<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subject_wise_answer extends Member_controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('exam_model');
		$this->load->model('report/common_model','obj1');
		$this->load->model('report/subject_wise_answer_model','obj2');
		$this->load->model('member/result_model','result');
		$this->load->model('ref_text_model');
	}
	public function index()
	{
		$exam_id=$this->uri->segment(4);
		$user_id=$this->uri->segment(5);
		$dt=$this->uri->segment(6);
		$subjects=$this->obj1->get_exam_subjects(5);
		$x="[";
		if($subjects)
		{
			foreach ($subjects as $sbj) 
			{
				$x.="'".ref_text_model::get_text($sbj->topics)."',";
			}
		}
		$x.="]";
		
		$subject_wise_count=$this->obj1->get_subject_wise_answer($exam_id,$user_id,$dt);

		$data['xAxis']=$x;
		$data['test_name']=exam_model::get_text($exam_id);
		$data['title']='Subject Wise Wrong Answer';
		//$data['main_content']='report/v_subject_wise_answer';
		//$this->load->view('layout/layout',$data);
		$this->load->blade('report.v_subject_wise_answer', $data);
	}

}

/* End of file subject_wise_answer.php */
/* Location: ./application/controllers/report/subject_wise_answer.php */