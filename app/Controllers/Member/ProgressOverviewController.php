<?php 
namespace App\Controllers\Member;
use Illuminate\View\Factory as View;
use App\Controllers\MemberController;

use App\Models\member\Result_model;
use App\Models\Exam_model;

class ProgressOverviewController extends MemberController {

	function __construct()
	{
		//parent::__construct();
		//$this->load->model('member/result_model','result');
                //$this->load->model('exam_model');
            
            
                $this->session = \Config\Services::session();
                $this->session->start();


                $this->creationDate = $this->session->get('creation_date');
                $this->utype = $this->session->get('utype');
                $this->username = $this->session->get('username');
                $this->userid = $this->session->get('userid');
                if(!$this->userid || $this->userid == '' || !is_numeric($this->userid))
                {
                    return redirect()->to(base_url());
                    exit;
                }
                
                $this->result = new Result_model();
                
        
	}
	public function index()
	{
		$user=$this->userid;
		/*if($this->session->userdata('userid'))
		{
			$user=$this->session->userdata('userid');
		}*/
		
		$data['result']=$this->result->get_user_progress($user);
		$data['title']='Progress Overview';
                
                 $data['creationdate'] = $this->creationDate;
                $data['username'] = $this->username;
                return $this->render('member.v_progress_overview', $data);
		//$this->load->blade('member.v_progress_overview', $data);
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