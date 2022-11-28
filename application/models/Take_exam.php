<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Take_exam extends Member_controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('common');
		$this->load->model('exam_model');
		$this->load->model('ref_text_model');
		$this->load->model('Exam/choosen_category_model','choosen');
		$this->load->model('member/result_model','result');
		$this->load->model('exam_lock_model');
		$this->load->model('permission_model');
		//code for maintenance mode
		if($this->utype!=101)
		{
			die();
		}
		
	}

	

	public function index()
	{
		$user=$this->userid;
		$eid=7;
		if($this->uri->segment(4))
		{
			$eid=$this->uri->segment(4);
		}

		$cats=$this->ref_text_model->all_by('group_id',2);
		$cats_str=$this->exam_category_list();
		$data['eid']=$eid;
		$data['cats_str']=$cats_str;
		$data['cats']=$cats;
		// $data['exam_list']=$this->exam_list($eid);
		$data['exam_list']='';
		$data['title']='Previous Job Test';
		$this->load->blade('member.v_take_exam', $data);
	}


	function exam_category_list()
	{
		$cats_arr=['7','318','713','680','833'];
		$cats=$this->ref_text_model->ref_text_group_in($cats_arr);
		$str="";
		if($cats)
		{
			foreach ($cats as $ct) {
				$exams=false;
				if($ct->id==7)
				{
					$exams=$this->exam_model->get_exam_list_by_limit($ct->id,[826,827,828]);
				}
				else
				{
					$exams=$this->exam_model->get_exam_list_by_limit($ct->id);
				}
				$str.="<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>";
				$str.="<div class='box-cat'>";
				//title of exam category
				if($ct->id==833)
				{
					$str.="<h4>PSC &amp; Govt. Jobs</h4>";
				}
				else
				{
					$str.="<h4>{$ct->name}</h4>";
				}
				//end title of exam category
				if($exams)
				{
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
						$lnk=$locked?base_url()."public/upgrade":base_url()."member/practice_test/index/{$exm->id}";
						$str.="<li><a href='{$lnk}'><i class='fa fa-check'></i> {$exm->name}</a></li>";
					}

					$str.="<li><button type='button' class='btn btn-info btn-xs btn-cat' data-cat='{$ct->id}'>View All</button></li>";
					$str.="</ul>";
				}
				$str.="</div>";
				$str.="</div>";
			}

			// $govs=$this->exam_model->get_exam_list_in(['826','827','828','789','790','791','792','798']);
			// $str.="<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>";
			// $str.="<div class='box-cat'>";
			// $str.="<h4>PSC & Other Govt. Job</h4>";
			// if($govs)
			// {
			// 	$str.="<ul class='list-unstyled'>";
			// 	foreach ($govs as $g) {
			// 		$lnk=base_url()."member/practice_test/index/{$g->id}";
			// 		$str.="<li><a href='{$lnk}'><i class='fa fa-check'></i> {$g->name}</a></li>";
			// 	}
			// 	$str.="<li><button type='button' class='btn btn-info btn-xs btn-cat' data-cat='833'>View All</button></li>";
			// 	$str.="<li></li>";
			// 	$str.="<li></li>";
			// 	$str.="</ul>";
			// }
			$str.="</div>";
			$str.="</div>";
		}	
		return $str;
	}
	function get_exam_list()
	{
		$cat=$this->input->post('cat');
		$list=$this->exam_list($cat);
		echo $list;
	}

	function exam_list($cat)
	{
		$this->output->enable_profiler(true);
		$user_exam_count=$this->result->get_user_exam_wise_count($this->userid);
		$categories=array();
		$exam_list=array();
		$exams=$this->exam_model->get_exam_list_by($cat,[789,790,791,792,798,801,831,832,829,814,830,826,827,828]);

		if($exams)
		{
			foreach ($exams as $exm) 
			{
				$attmp_exam=$this->get_attmp_test_count($exm->id,$user_exam_count);
				array_push($exam_list,array(
					'id'=>$exm->id,
					'user_id'=>$exm->user_id,
					'test_type'=>$exm->test_type,
					'ref_id'=>$exm->ref_id,
					'ref_text'=>$exm->name,
					'test_name'=>$exm->test_name,
					'total_ques'=>$exm->total_ques,
					'attemped_test'=>$attmp_exam));	
			}
		}

		//if govt category then add manually the follwoing exam added manually
		if($cat==833)
		{
			$govs=$this->exam_model->get_exam_list_in([826,827,828,789,790,791,792,798,801,831,832,829,814,830,826,827,828]);
			if($govs)
			{
				foreach ($govs as $gv) {
					$attmp_exam=$this->get_attmp_test_count($gv->id,$user_exam_count);
					array_push($exam_list,array(
						'id'=>$gv->id,
						'user_id'=>$gv->user_id,
						'test_type'=>$gv->test_type,
						'ref_id'=>$gv->ref_id,
						'ref_text'=>$gv->name,
						'test_name'=>$gv->test_name,
						'total_ques'=>$gv->total_ques,
						'attemped_test'=>$attmp_exam));	
				}
			}
		}
		//end categories loop
		$str="";
		if(count($exam_list)>0)
		{
			$str.="<table class='table table-bordered table-striped'>";
			$str.="<thead>";
			$str.="<tr>";
			$str.="<th>Test Name</th>";
			//$str.="<th>Total Question</th>";
			//$str.="<th>Attempted Test</th>";
			//$str.="<th>Last Attempted Date</th>";
			$str.="<th>Total Correct In Last Exam</th>";
			//$str.="<th>Real Test</th>";
			$str.="<th>Action</th>";
			$str.="</tr>";
			$str.="</thead>";
			foreach ($exam_list as $lst) {
				$locked=false;
				if($this->utype=='2')
				{
					$locked=$this->exam_lock_model->is_locked($lst['ref_id']);
				}
				elseif($this->utype=='105')
				{
					$locked=$this->exam_lock_model->is_locked($lst['ref_id']);
				}

				$user_top_exam=$this->exam_model->get_user_top_exam($this->userid,$lst['id']);
				$dtf='Not Attempted Yet';
				$last_total_correct='--';
				if($user_top_exam)
				{
					$dt=date_create($user_top_exam->exam_date);
					$dtf=date_format($dt,'d F, Y');
					$last_total_correct=$user_top_exam->total_correct;
				}

				$take_exam_url=base_url().'member/take_exam/confirm_take_exam/'.$lst['id'];
				$practice_url=base_url().'member/practice_test/index/'.$lst['id'];
				$written_url=base_url().'member/written/index/'.$lst['id'];
				$test_name=$lst['test_type']==15?$lst['test_name']:$lst['ref_text'];
				if($this->utype!='101' && $this->utype!='102')
				{
					if($locked)
					{
						$lnk_upgrade=base_url()."public/upgrade";

						$str.= "<tr>";
						$str.= "<td class='test_name' data-title='Test Name'>{$test_name}</td>";


						//$str.= "<td data-title='Total Question'>{$lst['total_ques']}</td>";
						//$str.= "<td data-title='Attemped Test'>{$lst['attemped_test']}</td>";
						//$str.="<td class='dt' data-title='Last Attemped Date'>{$dtf}</td>";
						$str.="<td  class='total'data-title='Total Correct in Last Exam'>{$last_total_correct}</td>";
						//$str.= "<td class='start' data-title='Real Test'></td>";
						$str.= "<td class='start'>";
						//$str.="<a class='btn btn-info btn-xs' style='color:#ff392e' href='{$lnk_upgrade}' class='stdbtn'>";
						//$str.="<i class='fa fa-lock'></i>&nbsp;Real Test</a> &nbsp;&nbsp;&nbsp;";


						//$str.=" <a class='btn btn-primary btn-xs' style='color:#ff392e' href='{$lnk_upgrade}' class='stdbtn'>";
						//$str.="<i class='fa fa-lock'></i>&nbsp;Practice Test</a>&nbsp;&nbsp;";
						

						// if($cat!=7){
						$str.=" <a class='btn btn-default btn-xs' style='color:#ff392e' href='{$lnk_upgrade}' class='stdbtn'>";
						$str.="&nbsp;<i class='fa fa-lock'></i>&nbsp;Upgrade Membership&nbsp;&nbsp;</a></td>";
						// }
						$str.= "</tr>"; 
					}
					else
					{
						$str.= "<tr>";
						$str.= "<td class='test_name' data-title='Test Name'>{$test_name}</td>";
						//$str.= "<td data-title='Total Question'>{$lst['total_ques']}</td>";
						//$str.= "<td data-title='Attemped Test'>{$lst['attemped_test']}</td>";
						//$str.="<td class='dt' data-title='Last Attemped Date'>{$dtf}</td>";
						$str.="<td class='total' data-title='Total Correct in Last Exam'>{$last_total_correct}</td>";
						//$str.= "<td class='start' data-title='Real Test'></td>";
						$str.= "<td class='start'><a class='btn btn-info btn-xs' href='{$take_exam_url}'>";
						$str.="<i class='fa fa-check-square-o'></i>Real Test</a>&nbsp;&nbsp;&nbsp;";


						$str.="  <a class='btn btn-primary btn-xs' href='{$practice_url}'>";
						$str.="<i class='fa fa-pencil-square-o'></i>Practice Test</a>&nbsp;&nbsp;";

						// if($cat!=7){
						$str.=" <a class='btn btn-primary btn-xs' href='{$written_url}' class='stdbtn'>";
						$str.="<i class='fa fa-pencil'></i>&nbsp;Written</a></td>";
						// }
						$str.= "</tr>"; 
					}
				}
				else
				{
						$str.= "<tr>";
						$str.= "<td class='test_name' data-title='Test Name'>{$test_name}</td>";

						//$str.= "<td data-title='Total Question'>{$lst['total_ques']}</td>";
						//$str.= "<td data-title='Attemped Test'>{$lst['attemped_test']}</td>";
						//$str.="<td class='dt' data-title='Last Attemped Date'>{$dtf}</td>";
						$str.="<td class='total' data-title='Total Correct in Last Exam'>{$last_total_correct}</td>";
						//$str.= "<td class='start' data-title='Real Test'></td>";
						$str.= "<td class='start'><a href='{$take_exam_url}' class='btn btn-info btn-xs stdbtn'>";
						$str.="<i class='fa fa-check-square-o'></i>Real Test</a>&nbsp;&nbsp;&nbsp;";


						$str.=" <a class='btn btn-primary btn-xs' href='{$practice_url}' class='stdbtn'>";
						$str.="<i class='fa fa-pencil-square-o'></i>Practice Test</a>&nbsp;&nbsp;";
						

						// if($cat!=7){
						$str.=" <a class='btn btn-primary btn-xs' href='{$written_url}' class='stdbtn'>";
						$str.="<i class='fa fa-pencil'></i>&nbsp;Written</a></td>";
						// }
						$str.= "</tr>"; 
				}
			}
			$str.="</table>";

			$str.="<p style='font-weight:bold;'>** Real Test is where you have to answer all the questions in the allocated time and check your performance afterwards. <br>In Practice Test we will see all the questions at a time and answer one at a time and check whether it is right or wrong.</p>";
		}else
		{
			$str.="<p>No Exam Found!!!</p>";
		}

		return $str;
	}

	function confirm_take_exam()
	{
		$seg1=$this->uri->segment(4);
		$data['url']=base_url() . 'member/test/index/'.$seg1 ;
		$data['title']='Confirm Take Exam';
		//$data['main_content']='member/v_confirm_take_exam';
		//$this->load->view('layout/layout', $data);
		$this->load->blade('member.v_confirm_take_exam', $data);
	}

	function get_test_type()
	{
		$ttp_id=$this->input->get('ttp');

		$choosed=$this->choosen->get_exam_by_choosen_arr($this->userid);
		
		$str="<option value='-1'>Select Test Name</option>";
		if($ttp_id==16)
		{
			if(count($choosed)>0)
			{
				$test_name=$this->exam_model->get_test_name_by_choosen($ttp_id,$choosed);
				if($test_name)
				{
					foreach ($test_name as $tm) 
					{
						$name=$tm->test_type==15?$tm->test_name:ref_text_model::get_text($tm->ref_id);
						$str.="<option value='{$tm->id}'>{$name}</option>";
					}
				}
			}
		}
		else
		{
			$testName=$this->exam_model->get_test_name_by_type($ttp_id);
			foreach ($testName as $tm)
			{
			$test_name=$tm->test_type==15?$tm->test_name:ref_text_model::get_text($tm->ref_id);
			$str.="<option value='{$tm->id}'>{$test_name}</option>";
			}
		}
		echo $str;
	}

	function get_attmp_test_count($el,$arr)
	{
		$count=0;
		if(count($arr)>0)
		{
			if($arr)
			{
				foreach ($arr as $a) 
				{
					if($a->exam_id==$el)
					{
						$count=$a->totaltest;
					}
				}
			}
		}
		return $count;
	}

}

/* End of file take_exam.php */
/* Location: ./application/controllers/exam/take_exam.php */