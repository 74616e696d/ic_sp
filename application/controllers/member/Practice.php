<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Practice extends Member_controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('ref_text_model');
		$this->load->model('exam_model');
		$this->load->model('member/result_model','result');
		$this->load->model('Exam/reading_meta_model','reading');
		$this->load->model('Exam/choosen_category_model','choosen');
		$this->load->model('exam_lock_model');
		$this->load->model('permission_model');
		// $this->output->enable_profiler(true);
	}
	public function index()
	{
		if($this->utype=='101'){
			//$this->output->enable_profiler(true);
		}
		$exam_id=0;
		$sub_id=0;
		$default='<p>NO CHAPTER FOUND !!</p>';
		if($this->uri->segment(4) && $this->uri->segment(5))
		{
			$exam_id=$this->uri->segment(4);
			$sub_id=$this->uri->segment(5);
			$default=$this->display($sub_id);
		}
		$data['default']=$default;
		$data['exam_id']=$exam_id;
		$data['subj_id']=$sub_id;
		$data['title']='Study &amp;Practice';
		$this->load->blade('member.v_practice', $data);
	}

	function get_subjects()
	{
		$exam_id=$this->input->post('eid');
		$subjects=$this->ref_text_model->get_subject_of_exam_cat($exam_id);
		//var_dump($subjects);
		$str="<option value='-1'>Select Subject</option>";
		if($subjects)
		{
			foreach ($subjects as $sbj) {
				$str.="<option value='{$sbj->id}'>{$sbj->name}</option>";
			}
		}
		else
		{
			$str.="<option value='-1'>Select Subject</option>";
		}

		echo $str;

	}

	

	function search_str()
	{
		$subj=$this->input->post('subj');
		$chapt=$this->input->post('chapt');

		$stringToFinalReturn='';
        $stringReturned=' where';
        if($subj!=-1)
		{
			$stringReturned.=" subject={$subj} and ";	
		}
		if($chapt!=-1)
		{
			$stringReturned.=" chapter={$chapt} and";
		}
        if($stringReturned!=' where')
        {
            $stringToFinalReturn=substr($stringReturned,0,strlen($stringReturned)-4);
        }

        return $stringToFinalReturn;

	}

	function display($pid)
	{
		$user=0;
		if($this->session->userdata('userid'))
		{
			$user=$this->session->userdata('userid');
		}
		$chapter_group=$this->ref_text_model->get_ref_text_by_parent($pid);

		$written_subject_list=[643,644,645,646,647,648,649,650,651];
		$str="";
		
			if($chapter_group)
			{
				$str.="<table class='table table-bordered table-striped'>";

				if(in_array($pid, $written_subject_list))
				{
					//show heading for written exam chapter lists
					$str.="<thead>";
						$str.="<tr>";
						$str.="<th>Chapter</th>";
						$str.="<th>Action</th>";
						$str.="</tr>";
					$str.="</thead>";
				}
				else
				{
					//show heading for non-written exam chapter list
					$str.="<thead>";
						$str.="<tr>";
						$str.="<th>Chapter</th>";
						$str.="<th>Previous Test Count</th>";
						$str.="<th>Action</th>";
						$str.="</tr>";
					$str.="</thead>";
				}

				foreach ($chapter_group as $cpt_grp) 
				{
					$chapters=$this->ref_text_model->get_ref_text_by_parent($cpt_grp->id);
					
					if($chapters)
					{
						foreach ($chapters as $cpt) {
							$q_count=$this->exam_model->total_chapter_question($cpt->id);

							if(in_array($pid,$written_subject_list))//checking if subject is for written exam
							{
								//if written exam table will be shown in the following format
								$prgs=$this->exam_model->chapter_ques_in_prev_test($cpt->id);
								$chapter_progress=$prgs;
								$locked=false;
								if($this->utype=='2')
								{
									$locked=$this->exam_lock_model->is_locked($cpt->id);
								}
								
								$url="";
							
								if($this->utype!='101' && $this->utype!='102')
								{
									if(!$locked)
									{
										$lnk=base_url().'member/reading/index/'.$cpt->id;
										$lnk_quiz=base_url()."member/chapter_quiz/index/{$cpt->id}";
										$lnk_read=base_url()."member/read_details/index/{$cpt->id}/rd";
										$url="<a href='{$lnk}' target='_blank'><i class='fa fa-pencil-square-o'></i>&nbsp;&nbsp;Start Practice</a>";
										$url_quiz="<a href='{$lnk_quiz}' target='_blank'><i class='fa fa-pencil-square-o'></i>&nbsp;&nbsp;Start Quiz</a>";
										$url_read="<a href='{$lnk_read}' target='_blank'><i class='fa fa-book'></i>&nbsp;&nbsp;Read Details</a>";
									}
									else
									{
										$lnk_upgrade=base_url()."public/upgrade";
										$url="<a href='{$lnk_upgrade}' style='color:#ff392e' data-tooltip='toggle' title='Update your membership to unlock'><i class='fa fa-pencil-square-o'></i>&nbsp;&nbsp;Unlock Practice</a>";
										$url_quiz="<a href='{$lnk_upgrade}' style='color:#ff392e' data-tooltip='toggle' title='Update your membership to unlock'><i class='fa fa-pencil-square-o'></i>&nbsp;&nbsp;Unlock Quiz</a>";
										$url_read="<a href='{$lnk_upgrade}' style='color:#ff392e' data-tooltip='toggle' title='Update your membership to unlock'><i class='fa fa-book'></i>&nbsp;&nbsp;Unlock Read</a>";
									}
								}
								else
								{
									$lnk=base_url().'member/reading/index/'.$cpt->id;
									$lnk_quiz=base_url()."member/chapter_quiz/index/{$cpt->id}";
									$lnk_read=base_url()."member/read_details/index/{$cpt->id}/rd";
									$url="<a href='{$lnk}' target='_blank'><i class='fa fa-pencil-square-o'></i>&nbsp;&nbsp;Start Practice</a>";
									$url_quiz="<a href='{$lnk_quiz}' target='_blank'><i class='fa fa-pencil-square-o'></i>&nbsp;&nbsp;Start Quiz</a>";
									$url_read="<a href='{$lnk_read}' target='_blank'><i class='fa fa-book'></i>&nbsp;&nbsp;Read Details</a>";

								}

								$prev_state='';
								if($this->reading->chapter_exists($user,$cpt->id))
								{
									$prev_state="<i style='color:#AEE077;' class='fa fa-check-circle fa-lg'></i>&nbsp;&nbsp;Already read";
								}
								else
								{
									$prev_state="<i class='fa fa-times-circle fa-lg'></i>&nbsp;&nbsp;Not yet read";
								}

								$str.="<tr class='tr_chapter'>";
								$str.="<td data-title='Chapter'>{$cpt->name}</td>";
								// $str.="<td data-title='Previous Test Count'><span class='btn btn-primary'>{$chapter_progress}</span></td>";
								$str.="<td class='action' data-title='&nbsp;'>{$url_read}</td>";
								$str.="</tr>";

							}
							else
							{
								//if not written exam table will be shown in the following format
								if($q_count>0)
								{
										$prgs=$this->exam_model->chapter_ques_in_prev_test($cpt->id);
										$chapter_progress=$prgs;
										$locked=false;
										if($this->utype=='2')
										{
											$locked=$this->exam_lock_model->is_locked($cpt->id);
										}
										
										$url="";
										$test_count=0;
										if($this->result->chapter_wise_previous_test_count($cpt->id,$user))
										{
											$test_count=$this->result->chapter_wise_previous_test_count($cpt->id,$user);
										}
										if($this->utype!='101' && $this->utype!='102')
										{
											
											/*For free users */
											    $lnk=base_url().'member/reading/index/'.$cpt->id;
												$lnk_quiz=base_url()."member/chapter_quiz/index/{$cpt->id}";
												$lnk_read=base_url()."member/read_details/index/{$cpt->id}";
												$url="<a href='{$lnk}' target='_blank'><i class='fa fa-pencil-square-o'></i>&nbsp;&nbsp;Start Practice</a>";
												$url_quiz="<a href='{$lnk_quiz}' target='_blank'><i class='fa fa-pencil-square-o'></i>&nbsp;&nbsp;Start Quiz</a>";
												$url_read="<a href='{$lnk_read}' target='_blank'><i class='fa fa-book'></i>&nbsp;&nbsp;Read Details</a>";


											/* For Paid Users
											if(!$locked)
											{
												$lnk=base_url().'member/reading/index/'.$cpt->id;
												$lnk_quiz=base_url()."member/chapter_quiz/index/{$cpt->id}";
												$lnk_read=base_url()."member/read_details/index/{$cpt->id}";
												$url="<a href='{$lnk}' target='_blank'><i class='fa fa-pencil-square-o'></i>&nbsp;&nbsp;Start Practice</a>";
												$url_quiz="<a href='{$lnk_quiz}' target='_blank'><i class='fa fa-pencil-square-o'></i>&nbsp;&nbsp;Start Quiz</a>";
												$url_read="<a href='{$lnk_read}' target='_blank'><i class='fa fa-book'></i>&nbsp;&nbsp;Read Details</a>";

											}
											else
											{
												$lnk_upgrade=base_url()."public/upgrade";
												$url="<a href='{$lnk_upgrade}' style='color:#ff392e' data-tooltip='toggle' title='Update your membership to unlock'><i class='fa fa-pencil-square-o'></i>&nbsp;&nbsp;Unlock Practice</a>";
												$url_quiz="<a href='{$lnk_upgrade}' style='color:#ff392e' data-tooltip='toggle' title='Update your membership to unlock'><i class='fa fa-pencil-square-o'></i>&nbsp;&nbsp;Unlock Quiz</a>";
												$url_read="<a href='{$lnk_upgrade}' style='color:#ff392e' data-tooltip='toggle' title='Update your membership to unlock'><i class='fa fa-book'></i>&nbsp;&nbsp;Unlock Read</a>";
											}
											*/
										}
										else
										{
											$lnk=base_url().'member/reading/index/'.$cpt->id;
											$lnk_quiz=base_url()."member/chapter_quiz/index/{$cpt->id}";
											$lnk_read=base_url()."member/read_details/index/{$cpt->id}";
											$url="<a href='{$lnk}' target='_blank'><i class='fa fa-pencil-square-o'></i>&nbsp;&nbsp;Start Practice</a>";
											$url_quiz="<a href='{$lnk_quiz}' target='_blank'><i class='fa fa-pencil-square-o'></i>&nbsp;&nbsp;Start Quiz</a>";
											$url_read="<a href='{$lnk_read}' target='_blank'><i class='fa fa-book'></i>&nbsp;&nbsp;Read Details</a>";

										}

										$prev_state='';
										if($this->reading->chapter_exists($user,$cpt->id))
										{
											$prev_state="<i style='color:#AEE077;' class='fa fa-check-circle fa-lg'></i>&nbsp;&nbsp;Already read";
										}
										else
										{
											$prev_state="<i class='fa fa-times-circle fa-lg'></i>&nbsp;&nbsp;Not yet read";
										}

										$str.="<tr class='tr_chapter'>";
										$str.="<td data-title='Chapter'>{$cpt->name}</td>";
										$str.="<td data-title='Previous Test Count'><span class='btn btn-primary'>{$chapter_progress}</span></td>";
										//$str.="<td><input type='hidden' value='{$chapter_progress}' class='hdn_progress' />";
										//$str.="<div class='progressdiv'></div>";
										// $str.="</td>";
										$str.="<td class='action' data-title='&nbsp;'>{$url} &nbsp;&nbsp;&nbsp; {$url_quiz}&nbsp;&nbsp;{$url_read}</td>";
										$str.="</tr>";
								}
							}
						}
					}
					
				}
				$str.="</table>";
			}
	
		return $str;
	}

	/**
	 * Get Chapters By Subject
	 * @return [type] [description]
	 */
	function get_chapters()
	{
		$pid=$this->input->get('pid');
		$str="";
		if($pid!=-1)
		{
			$str=$this->display($pid);
		}
		else
		{
			$str="";
		}
	
		echo $str;
	}


}

/* End of file practice.php */
/* Location: ./application/controllers/member/practice.php */