<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use Carbon\Carbon;
class Model_quiz_report extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('model_quiz_model');
		$this->load->model('model_quiz_summery_model');
		$this->load->model('model_test_model');
		//$this->output->enable_profiler(true);
	}
	public function index()
	{
		$data['total_attempt']=$this->model_quiz_summery_model->total();

		$today=date('Y-m-d');

		$todays_attempt=$this->model_quiz_summery_model
					->where(array("DATE_FORMAT(quiz_date,'%Y-%m-%d')|="=>$today))->get(array('id'));
		$current_month=date('m');
		$monthly=$this->model_quiz_summery_model->all_by("MONTH(quiz_date)",$current_month);

		$data['todays_list']=$this->get_todays_result();
		$data['monthly_attempt']=$monthly?count($monthly):0;
		$data['todays_attempt']=$todays_attempt?count($todays_attempt):0;
		$data['title']='Model Quiz Report';
		$this->load->blade('admin.modeltest.model_quiz_report', $data);
	}


	/**
	 * display model test result in datatable
	 * @return json
	 */
	function result_dt()
	{
		 $length=$_POST['length'];
		 $term='';
		 $search=$_POST['search']['value'];
		 $filterStr='';
		 if($search){
		    $search_terms=json_decode($search);
		    $searchStr=' where';
		    if(!empty($search_terms->email))
		    {
		        $searchStr.=" u.email='{$search_terms->email}' and ";
		    }

		    if(!empty($search_terms->quiz))
		    {
		        $searchStr.=" mt.name like '%{$search_terms->quiz}%' and ";
		    }

		    if(!empty($search_terms->dt1) && !empty($search_terms->dt2))
		    {
		        $searchStr.=" mqs.quiz_date>='{$search_terms->dt1}' and mqs.quiz_date<='{$search_terms->dt2}' and ";
		    }
		    
		    if($searchStr!=' where')
		    {
		        $term.=substr($searchStr,0,strlen($searchStr)-4);
		    }
		    $filterStr=$term;
		 }
		 
		 $no = $_POST['start'];
		 $term.=" order by mqs.id desc limit {$no},{$length}";
		$list = $this->model_quiz_summery_model->get_quiz_summery($term);
		$data = array();
		if($list)
		{
		    foreach($list as $item) 
		    {
		        $no++;
		        $row = array();
		        $row[]=$no;
		        $row[] = $item->email;
		        $row[] = $item->test_name;
		        $row[] = date('d M, Y',strtotime($item->quiz_date));
		        $row[]=$item->total_ques;
		        $row[] = $item->total_correct;
		        $row[]=$item->total_wrong;
		        $tm=gmdate('H:i:s',$item->time_taken); 
		        $row[] = $tm;

		        $data[] = $row;
		    }
		}
		$total=$this->model_quiz_summery_model->get_count('');
		$total_filtered=$this->model_quiz_summery_model->get_count($filterStr);
		$output = array(
		                "draw" => $_POST['draw'],
		                "recordsTotal" =>$total ,
		                "recordsFiltered" => $total_filtered,
		                "data" => $data,
		        );
		//output to json format
		echo json_encode($output);
	}

	function get_result()
	{
		$uid=$this->input->post('uid');
		$str='';
		$users_exam=$this->model_quiz_summery_model->all_by('user_id',$uid);
		if($users_exam)
		{
			$str.="<table class='table table-bordered'>";
			$str.="<thead>";
			$str.="<tr>";
			$str.="<th>Model Test:</th>";
			$str.="<th>Total Ques</th>";
			$str.="<th>Date</th>";
			$str.="<th>Correct</th>";
			$str.="<th>Wrong</th>";
			$str.="<th>Time</th>";
			$str.="</tr>";
			$str.="</thead>";
			$str.="<tbody>";
			foreach ($users_exam as $exm) 
			{
				$test_name=$this->model_test_model->find($exm->test_id);
				$dt=date_create($exm->quiz_date);
				//$dtf=date_format($dt,'Y-m-d H:i:s');
				$dtf=date_format($dt,'Y-m-d');
				$tm=gmdate('H:i:s',$exm->time_taken); 
				$str.="<tr>";
				$str.="<td>{$test_name->name}</td>";
				$str.="<td>{$test_name->total_ques}</td>";
				$str.="<td>{$dtf}</td>";
				$str.="<td>{$exm->total_correct}</td>";
				$str.="<td>{$exm->total_wrong}</td>";
				$str.="<td>{$tm}</td>";
				$str.="</tr>";
			}
			$str.="</tbody>";
			$str.="</table>";
		}
		else
		{
			$str.="<div>Not attempted!</div>";
		}
		echo $str;
	}


	function get_todays_result()
	{
		$str='';
		$users_exam=$this->model_quiz_summery_model->get_todays_result();
		if($users_exam)
		{
			$str.="<table class='table table-bordered'>";
			$str.="<thead>";
			$str.="<tr>";
			$str.="<th>User Email</th>";
			$str.="<th>Model Test:</th>";
			$str.="<th>Total Ques</th>";
			$str.="<th>Date</th>";
			$str.="<th>Correct</th>";
			$str.="<th>Wrong</th>";
			$str.="<th>Time</th>";
			$str.="</tr>";
			$str.="</thead>";
			$str.="<tbody>";
			foreach ($users_exam as $exm) 
			{
				$test_name=$this->model_test_model->find($exm->test_id);
				$dt=date_create($exm->quiz_date);
				//$dtf=date_format($dt,'Y-m-d H:i:s');
				$dtf=date_format($dt,'Y-m-d');
				$tm=gmdate('H:i:s',$exm->time_taken); 
				$user=$this->user_model->get_user_email($exm->user_id);
				$str.="<tr>";
				$str.="<td>{$user}</td>";
				$str.="<td>{$test_name->name}</td>";
				$str.="<td>{$test_name->total_ques}</td>";
				$str.="<td>{$dtf}</td>";
				$str.="<td>{$exm->total_correct}</td>";
				$str.="<td>{$exm->total_wrong}</td>";
				$str.="<td>{$tm}</td>";
				$str.="</tr>";
			}
			$str.="</tbody>";
			$str.="</table>";
		}
		else
		{
			$str.="<div></div>";
		}
		return  $str;
	}

}

/* End of file model_quiz_report.php */
/* Location: ./application/controllers/admin/model_quiz_report.php */