<?php 
namespace App\Controllers\Member;
use App\Controllers\BaseController;
use Illuminate\View\Factory as View;
use App\Controllers\MemberController;


use App\Models\member\Review_model;
use App\Models\Question_bank_model;

class ReviewListController extends MemberController {

	function __construct()
	{
		//parent::__construct();

		//$this->load->model('member/review_model','review');
		//$this->load->model('question_bank_model');
            
            $this->review = new Review_model();
            $this->question_bank_model = new Question_bank_model();
            
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
	}

	public function index()
	{
		$user=$this->userid;
		$questions=$this->review->search_review_list($user);
		
		$str="<ul class='list-group'>";
		$total_ques=0;
		if($questions)
		{
			$total_ques=count($questions);
			$sl=1;
			foreach ($questions as $ques) 
			{
				$qstn=$this->question_bank_model->question_by_id($ques->qid);
				$ques_original='';
				if(!empty($qstn->question))
				{
					$ques_original=$qstn->question;
				}
				
				$strip_ques=strip_tags(trim($ques_original),"<img>");
			
				$str.="<li class='list-group-item'>&nbsp;&nbsp;<i onClick='delete_ques({$ques->qid})' title='delete' style='cursor:pointer;' class='fa fa-trash-o'></i>&nbsp;<span class='icn-mark' title='mark for future review'></span>&nbsp;&nbsp;{$sl}.&nbsp;&nbsp;{$strip_ques}<input type='hidden' id='hdn_qid' value='{$ques->qid}'/></li>";

				$rng=range('A','H');
				$i=0;
				$opt_original=empty($qstn->options)?'':$qstn->options;
				$ans_arr=explode('///',$opt_original);

				if(count($ans_arr)>0)
				{
					$correct_ans='';
					foreach ($ans_arr as $ans) 
					{
						$strip_ans=strip_tags(trim($ans),"<img>");
						$correct=substr(trim($strip_ans),0,2)=="@@"?true:false;
						$ans_plain=str_replace('@@','',trim($strip_ans));

						if($correct)
						{
							$correct_ans=$rng[$i];
						}

						$radio="<input type='radio' class='rd_{$sl}_{$i}' name='rd_{$sl}' />";
						
						$str.="<li class='list-option'>$radio&nbsp;(<span>{$rng[$i]}</span>)&nbsp;&nbsp;{$ans_plain}</li>";	
						$i++;
					}
					$str.="<li class='list-hidden'><input type='hidden' id='hdn_correct_ans_{$sl}' value='{$correct_ans}'/></li>";
				}

				if(!empty($qstn->hints))
				{	
					$strip_hint=strip_tags(trim($qstn->hints),'<img>');
					$url=base_url().'member/discussion/index/'.$ques->qid;
					$str.="<li class='list-hint' id='list_hint_{$sl}'><strong>Hints:&nbsp;</strong>{$strip_hint}&nbsp;<a target='_blank' href='{$url}'><i class='fa fa-search-plus fa-lg'></i></a></li>";

				}
				$sl++;
			}
		}
		$str.="</ul>";
		$data['total_ques']=$total_ques;
		$data["qlist"]=$str;
		$data['title']='Review List';
		// $data['main_content']='member/v_review_list';
		// $this->load->view('layout/layout', $data);
		//$this->load->blade('member.v_review_list', $data);
                $data['creationdate'] = $this->creationDate;
                $data['username'] = $this->username;
                return $this->render('member.v_review_list', $data);
	}


	function remove()
	{
		$qid=$this->input->post('qid');
		$this->review->delete_review($this->userid,$qid);
		echo "success";
	}


	function clearAll()
	{
		$uid=$this->userid;
		$this->review->delete_user_review($uid);
		$this->session->flashdata('success','You have successfully cleared all the review list !!');
		redirect(base_url()."member/review_list");
	}

	function test()
	{
		$term=array('user_id|='=>5,
			'qid|!='=>654,
			'qid|>'=>700,
			'qid|in'=>array('3869','4104')
			);
		$term1=array();
		$tst=$this->review->where($term1)->limit(3)->get(array('id','qid'));
		var_dump($tst);
	}


}

/* End of file review_list.php */
/* Location: ./application/controllers/member/review_list.php */