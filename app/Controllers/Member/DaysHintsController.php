<?php 

namespace App\Controllers\Member;
use App\Controllers\MemberController;
use Illuminate\View\Factory as View;

use App\Models\Days_hints_model;
use App\Models\Study_hints_model;

class DaysHintsController extends MemberController {

	var $start=0;
	function __construct()
	{
            $this->study_hints_model = new Study_hints_model();
            
            
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
            
		//parent::__construct();
		//$this->load->model('days_hints_model');
		//$this->load->model('study_hints_model');
		//$this->output->enable_profiler(true);
	}

	public function index()
	{

		$hints=false;
		$total=$this->study_hints_model->table('days_hints')->countAllResults();
		$max=$this->study_hints_model->selectMax('id')->get()->getRow();
                $max = $max->id;
		/*if($this->uri->segment(4))
		{
			$this->start=$this->uri->segment(4);
			$hints=$this->study_hints_model->todays_hints($this->start-1,1);
		}
		else
		{*/
			$this->start=$total;
			//$hints=$this->get_hints();
			$hints=$this->study_hints_model->find($max);

		//}
		// $this->start=$total-1;
		//$data['last']=$this->start!=0?$this->start-1:0;
		$data['start']=$this->start;
		$data['max_indx']=$total;
		$data['hints']=$hints;
		$data['title']="Today's Hints";
                
                $s = $data['s']=$this->start-1;
                $data['next_hints'] = $this->study_hints_model->has_hints($s);
                 
                $data['creationdate'] = $this->creationDate;
                $data['username'] = $this->username;
                
                 return $this->render('member.days_hints', $data);
		//$this->load->blade('member.days_hints', $data);
	}

	function get_hints()
	{
	    $today=date('Y-m-d');
	    $has=$this->days_hints_model->exist('user_id',$this->userid);
	    $days_list=false;
	    $max=$this->study_hints_model->max();
	    $start=0;
	    $end=10;
	    if($has)
	    {
	       $days_list=$this->days_hints_model->find_by('user_id',$this->userid);
	        if($days_list)
	        {
	            $dt=date_create($days_list->day);
	            $dtf=date_format($dt,'Y-m-d');
	            
	            if($today!=$dtf)
	            {
	                if($max-$days_list->start>5)
	                {

	                    $start=$days_list->start+9;
	                    $end=$days_list->end;
	                }
	                $data_today=array('user_id'=>$this->userid,
	                        'start'=>$start,
	                        'day'=>$today);
	                $this->days_hints_model->update_by('user_id',$this->userid,$data_today);
	            }
	        }
	    }
	    else
	    {
	        $data=array('user_id'=>$this->userid,
	            'start'=>0,
	            'end'=>1,
	            'day'=>$today);
	        $this->days_hints_model->create($data);
	        $days_list=$this->days_hints_model->find_by('user_id',$this->userid);
	    }
	    $this->start=$start;
	    $hints=$this->study_hints_model->todays_hints($days_list->start,$end);
	    return $hints;

	}

}

/* End of file days_hints.php */
/* Location: ./application/controllers/member/days_hints.php */