<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_test extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('ref_text_model');
		$this->load->model('model_test_model');
		$this->load->model('model_quiz_summery_model');
		$this->load->model('exam_lock_model');
	}

	public function index()
	{
		// $modeltest=$this->get_model_test_list();
		$cats=$this->ref_text_model->all_by('group_id',2);
		$data['cats']=$cats;
		$data['cats_str']=$this->model_test_cat_list();
		$data['live_model_test'] = $this->live_model_test();
		$data['modeltest']="";
		$data['title']='Model Test';
		$this->load->blade('member.model_test', $data);
	}

	function model_test_cat_list()
	{
		$cats_arr=['7','318','713','680','833','642','1052','1240','1241','1242','1587'];
		$cats=$this->ref_text_model->ref_text_group_in($cats_arr);
		$str="";
		if($cats)
		{
			foreach ($cats as $ct) {
				$exams=$this->model_test_model->get_model_test_by_cat_limit($ct->id);
				if($exams)
				{
				$str.="<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>";
				$str.="<div class='box-cat'>";
				$str.="<h4>{$ct->name}</h4>";
					$str.="<ul class='list-unstyled'>";
					foreach ($exams as $exm) {
						$locked=false;
						if($this->utype=='2')
						{
							$locked=$this->exam_lock_model->is_locked($exm->id);
						}
						elseif($this->utype=='105')
						{
							$locked=$this->exam_lock_model->is_locked($exm->id);
						}
						$lnk=$locked?base_url()."public/upgrade":base_url()."member/model_quiz/index/{$exm->id}";
						$str.="<li><a href='{$lnk}'><i class='fa fa-check'></i> {$exm->name}</a></li>";
					}
					$str.="<li><button type='button' class='btn btn-info btn-xs btn-cat' data-cat='{$ct->id}'>View All</button></li>";
					$str.="</ul>";
				$str.="</div>";
				$str.="</div>";
				}
			}
		}
		return $str;
	}

	function test_list()
	{
		$cat=$this->input->get('cat');
		$list=$this->get_model_test_list($cat);
		echo $list;
	}

	function live_model_result($id)
	{
		$data['results'] =$this->model_quiz_summery_model->get_test_sheet($id);
		$data['test_info'] = $this->model_quiz_summery_model->get_test_info($id);
		$this->load->blade('member.model_test.v_result', $data);

	}
	function live_model_test()
	{
		$modeltest=false;
		$user=$this->userid;
		$user_type=$this->utype;
		
		$modeltest=$this->model_test_model->get_live_model_test();
		


		$str='';
		if($modeltest)
		{
			$str.="<table class='table table-bordered'>";
			$str.="<thead>";
			$str.="<tr>";
			$str.="<th>Live Model Test</th>";
			$str.="<th>Total</th>";
			$str.="<th>My Score</th>";
			$str.="<th>Highest Score</th>";
			$str.="<th>Merit List</th>";
			$str.="<th>Action</th>";
			$str.="</tr>";
			$str.="</thead>";
			$str.="<tbody>";
			$now = date('Y-m-d H:i:s');
			foreach ($modeltest as $m) {

				$mtp=$this->model_quiz_summery_model->user_top_correct($user,$m->id);
				$my_top=$mtp==0?'--':$mtp;

				$tp=$this->model_quiz_summery_model->top_score($m->id);
				$attended= $this->model_quiz_summery_model->has_taken($m->id,$user);
				$top=$tp==0?'--':$tp;

				$test_date = date('d M Y h:iA', strtotime($m->exam_time));

				$merit_list = base_url()."member/model_test/live_model_result/".$m->id;

				
				//check if paid model test
				if($m->is_paid && $user_type==2)
				{
					$lnk=base_url()."public/upgrade";
					$str.="<tr>";
					$str.="<td>{$m->name}</td>";
					if($m->exam_time > $now) 
						{
							$str.="<td>{$test_date}</td>";
							$str.="<td></td>";
						}
					else {
					$str.="<td>{$my_top}</td>";

					$str.=" <td> <a class='btn btn-danger btn-xs' href='{$merit_list}'><i class='fa fa-lock'></i> Merit List</a></td> ";
					}
					
					$str.="<td><a class='btn btn-danger btn-xs' href='{$lnk}'><i class='fa fa-lock'></i> Upgrade to unlock</a></td>";
					$str.="</tr>";
				}
				else //if not paid model test
				{
					$lnk=base_url()."member/model_quiz/index/{$m->id}";
					$str.="<tr>";
					$str.="<td>{$m->name}</td>";
					$str.="<td>{$m->total_ques}</td>";

					if($m->exam_time > $now) 
						{
							$str.="<td>{$test_date}</td>";
							$str.="<td></td>";
							$str.="<td></td>";
							$str.="<td></td>";
						}
					else {
					$str.="<td>{$my_top}</td>";

					$str.="<td>{$top}</td>";
					$str.=" <td> <a class='btn btn-danger btn-xs' href='{$merit_list}'><i class='fa fa-lock'></i> Merit List</a></td> ";
					if($attended==0)
					$str.="<td><a class='btn btn-info btn-xs' href='{$lnk}'>Start</a></td>";
					else 
					$str.="<td></td>";	
					
					}
				
					
					$str.="</tr>";
				}
				
			}
			$str.="</tbody>";
			$str.="</table>";
		}
		else
		{
			$str.="<p>No Model Test Found !!</p>";
		}
		return $str;
	}



	function get_model_test_list($cat='')
	{
		$modeltest=false;
		$user=$this->userid;
		$user_type=$this->utype;
		if(!empty($cat))
		{
			$modeltest=$this->model_test_model->get_model_test_by_cat($cat);
		}
		else
		{
			$modeltest=$this->model_test_model->model_test();
		}


		$str='';
		if($modeltest)
		{
			$str.="<table class='table table-bordered'>";
			$str.="<thead>";
			$str.="<tr>";
			$str.="<th>Model Test</th>";
			$str.="<th>My Score</th>";
			$str.="<th>Highest Score</th>";
			$str.="<th>Action</th>";
			$str.="</tr>";
			$str.="</thead>";
			$str.="<tbody>";
			foreach ($modeltest as $m) {

				$mtp=$this->model_quiz_summery_model->user_top_correct($user,$m->id);
				$my_top=$mtp==0?'--':$mtp;

				$tp=$this->model_quiz_summery_model->top_score($m->id);
				$top=$tp==0?'--':$tp;


				
				//check if paid model test
				if($m->is_paid && $user_type==2)
				{
					$lnk=base_url()."public/upgrade";
					$str.="<tr>";
					$str.="<td>{$m->name}</td>";
					$str.="<td>{$my_top}</td>";
					$str.="<td>{$top}</td>";
					$str.="<td><a class='btn btn-danger btn-xs' href='{$lnk}'><i class='fa fa-lock'></i> Upgrade to unlock</a></td>";
					$str.="</tr>";
				}
				else //if not paid model test
				{
					$lnk=base_url()."member/model_quiz/index/{$m->id}";
					$str.="<tr>";
					$str.="<td>{$m->name}</td>";
					$str.="<td>{$my_top}</td>";
					$str.="<td>{$top}</td>";
					$str.="<td><a class='btn btn-info btn-xs' href='{$lnk}'>Start</a></td>";
					$str.="</tr>";
				}
				
			}
			$str.="</tbody>";
			$str.="</table>";
		}
		else
		{
			$str.="<p>No Model Test Found !!</p>";
		}
		return $str;
	}

}

/* End of file model_test.php */
/* Location: ./application/controllers/member/model_test.php */