<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Choose_exam extends Member_controller {

	function __construct()
	{
		parent::__construct();

		// check user authentication
		$roles=array('101','102');
  		membership_model::is_authenticate($roles);
    	//end check user authentication
		$this->load->helper('common');
		$this->load->model('exam_model');
		$this->load->model('member/result_model','result');
	}
	public function index()
	{
		$user=0;
		if($this->session->userdata('userid'))
		{
			$user=$this->session->userdata('userid');
		}
		$user_exam_count=$this->result->get_user_exam_wise_count($user);
		$exams=$this->exam_model->get_exam_list_group_by();
	
		$user_exam=$this->result->get_users_exam($user);
		$assigned_user_exam=array();
		if($user_exam)
		{
			if($user_exam->exam_id!=null)
			{
				$user_exam_list=explode(',',$user_exam->exam_id);
				foreach($user_exam_list as $lst)
				{
					array_push($assigned_user_exam,array(
						'exam_type'=>$user_exam->exam_type,
						'exam_id'=>$lst,
						'exam_text'=>exam_model::get_text($lst)));
				}
			}
		}

		$data['exams']=$exams;
		$data['exam_list']=$assigned_user_exam;
		$data['title']='Choose Your Exam';
		$data['main_content']='member/v_choose_exam';
		$this->load->view('layout/layout',$data);
	}

	function save_user_exam_list()
	{
		if($this->session->userdata('userid'))
		{
			$user=$this->session->userdata('userid');
			$exam_id=$this->input->post('eid');
			$exam_type=$this->input->post('etype');
			$exam_list=$this->result->get_users_exam($user);
			$time=strtotime(date('Y-m-d H:i:s'));
			$exam_list_arr=array();
			if($exam_list)
			{
				if(!empty($exam_list->exam_id))
				{
					$exam_list_arr=explode(',',$exam_list->exam_id);
					if(!in_array($exam_id,$exam_list_arr))
					{
						array_push($exam_list_arr,$exam_id);
						$exam_str=implode(',', $exam_list_arr);
						$data=array('user_id'=>$user,
							'exam_type'=>$exam_type,
							'exam_id'=>$exam_str,
							'added_date'=>$time
							);
						$this->result->update_users_exam($user,$data);
						echo "successfully saved!";
					}
					else
					{
						echo "This exam already assigned!";
					}
				}
				else
				{
					$data=array('user_id'=>$user,
						'exam_type'=>$exam_type,
						'exam_id'=>$exam_id,
						'added_date'=>$time);
					$this->result->update_users_exam($user,$data);
					echo "successfully saved!";
				}
				
			}
			else
			{

				$data=array('user_id'=>$user,
					'exam_type'=>$exam_type,
					'exam_id'=>$exam_id,
					'added_date'=>$time
					);
				$this->result->save_users_exam($data);
				echo 'successfully saved|';
			}

		}

	}

	function remove_user_exam()
	{
		$eid=$this->input->post('eid');
		if($this->session->userdata('userid'))
		{
			$user=$this->session->userdata('userid');
			$user_exam=$this->result->get_users_exam($user);
			if($user_exam)
			{
				if(!empty($user_exam->exam_id))
				{
					$user_exam_arr=explode(',',$user_exam->exam_id);
					$k=array_search($eid,$user_exam_arr);
					unset($user_exam_arr[$k]);
					$user_exam_str=implode(',', $user_exam_arr);
					$data=array('exam_id'=>$user_exam_str);
					$this->result->update_users_exam($user,$data);
					echo "This Exam remove from you list!";
				}
				if(empty($user_exam->exam_id))
				{
					$this->result->delete_users_exam($user);
					echo "This Exam remove from you list!";
				}
			}
		}
	}

	function get_attmp_test_count($el,$arr)
	{
		$count=0;
		if(count($arr)>0)
		{
			foreach ($arr as $a) 
			{
				if($a->exam_id==$el)
				{
					$count=$a->totaltest;
				}
			}
		}
		return $count;
	}

}

/* End of file choose_exam.php */
/* Location: ./application/controllers/member/choose_exam.php */