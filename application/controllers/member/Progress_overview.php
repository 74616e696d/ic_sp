<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Progress_overview extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('member/result_model','result');
        $this->load->model('exam_model');
        
	}
	public function index()
	{
		$user=0;
		if($this->session->userdata('userid'))
		{
			$user=$this->session->userdata('userid');
		}
		
		$data['result']=$this->result->get_user_progress($user);
		$data['title']='Progress Overview';
		$this->load->blade('member.v_progress_overview', $data);
	}

	function make_xaxis()
	{
		$test_name=$this->result->get_distinct_test_name();
		$xAxis="[";
		if($test_name)
		{
			foreach ($test_name as $tst) {
				$xAxis.="'".$tst->test_name."',\n";
			}
		}
		$xAxis.="]";
		return $xAxis;
	}
}

/* End of file progress_overview.php */
/* Location: ./application/controllers/member/progress_overview.php */