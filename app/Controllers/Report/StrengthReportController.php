<?php 
namespace App\Controllers\Report;
use Illuminate\View\Factory as View;
use App\Controllers\MemberController;

 use App\Models\Quiz_model;
 use App\Models\Ref_text_model;

class StrengthReportController extends MemberController {

	var $sel_subject=-1;
	function __construct()
	{
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
           
            $this->quiz_model = new Quiz_model();
            $this->ref_text_model = new Ref_text_model();
		//parent::__construct();
		//$this->load->model('answer_sheet_model');
		/*$this->load->model('quiz_model');
		//$this->load->model('answer_summery_model');
		$this->load->model('ref_text_model');*/
		//$this->output->enable_profiler(true);
	}

	public function index()
	{
		$chapter_list=[];
		$correct_series=[];
		$wrong_series=[];
                
                $request = service('request');
		if($request->getPost('btn_search'))
		{
			$this->sel_subject=$request->getPost('ddl_subject');
			$result=$this->quiz_model->get_chapter_wise_quiz_result($this->userid,$this->sel_subject);
			//$result=$this->answer_sheet_model->get_subject_wise_answer_sheet($this->userid,$this->sel_subject);
			$chapter_list=$this->chapter_series($result);
			$correct_series=$this->correct_series($result);
			$wrong_series=$this->wrong_series($result);
		}

		//var_dump($correct_series);
		//var_dump($wrong_series);
		$data['sel_subject']=$this->sel_subject;
		$data['subject']=$this->ref_text_model->get_ref_text_by_group(3);
		$data['correct_series']=json_encode($correct_series);
		$data['wrong_series']=json_encode($wrong_series);
		$data['chapter_list']=json_encode($chapter_list);
		$data['title']='Your Strength Comparison';
		//$this->load->blade('report.strength_report', $data);
                
                 $data['creationdate'] = $this->creationDate;
                $data['username'] = $this->username;
                return $this->render('report.strength_report', $data);
	}


	function correct_series($result)
	{
		$x='[';
		$chapter_arr=$this->unique_chapter_array($result);
		if(count($chapter_arr)>0)
		{
			$unique_chapter=array();
			foreach ($chapter_arr as $r) {
				if($result)
				{ 
					$count=0;
					$ttl=0;
					foreach ($result as $rslt) {
						if($rslt->chapter==$r)
						{
							if($rslt->ans==$rslt->correct_ans)
							{
								$count++;
							}
							$ttl++;
						}
					}
					$percent=round(($count/$ttl)*100);
					$x.="{$percent},";
				}
			}
		}
		$x.=']';
		return $x;
	}

	function wrong_series($result)
	{
		$x='[';
		$chapter_arr=$this->unique_chapter_array($result);
		if(count($chapter_arr)>0)
		{
			$unique_chapter=array();
			foreach ($chapter_arr as $r) {
				if($result)
				{ 
					$count=0;
					$ttl=0;
					foreach ($result as $rslt) {
						if($rslt->chapter==$r)
						{
							if($rslt->ans!=$rslt->correct_ans)
							{
								$count++;
							}
							$ttl++;
						}
					}
					$percent=round(($count/$ttl)*100);
					$x.="{$percent},";
				}
			}
		}
		$x.=']';
		return $x;
	}

	function chapter_series($result)
	{
		$x='[';
		$chapter_arr=$this->unique_chapter_array($result);
		if(count($chapter_arr)>0)
		{
			foreach ($chapter_arr as $r) {
				$x.="'".ref_text_model::get_text($r)."',";
			}
		}
		$x.=']';
		return $x;
	}

	function unique_chapter_array($result)
	{
		$unique_chapter=array();
		if($result)
		{
			foreach ($result as $r) {
				if(!in_array($r->chapter,$unique_chapter))
				{
					array_push($unique_chapter,$r->chapter);
				}
			}
		}
		return $unique_chapter;
	}


}

/* End of file strength_report.php */
/* Location: ./application/controllers/report/strength_report.php */