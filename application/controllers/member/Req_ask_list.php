<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Req_ask_list extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('member_question_model');
		$this->load->model('mem_ques_ans_model');
		$this->load->model('user_model');	
	}
	public function index()
	{
		$ques_list=$this->member_question_model->all_by('published','1');
		$data['qlist']=$this->qlist($ques_list);
		$data['title']='Readers Questions';
		$this->load->blade('member.req_ask_list', $data);	
	}

	function qlist($ques)
	{
		$str="";
		if($ques)
		{
			foreach ($ques as $q) {
				$view_url=base_url()."member/req_ask_list/view_ans/{$q->id}";
				$user=$this->user_model->find($q->user_id);
				$q_plain=strip_tags(trim($q->ques),"<img></u><sub><sup><i><b>");
				$str.="<ul class='list-unstyled qlst'>";
				$str.="<li>";
				$str.="<h4>Question: {$q->title}</h4>";
				$dt=date_create($q->post_date);
				$dtf=date_format($dt,'d F, Y H:i');
				$str.="<p class='qfooter'><span><i title='Post time' class='fa fa-clock-o'></i>{$dtf}</span>";
				$uname=$user?$user->user_name:'';
				$str.="<span><i class='fa fa-user'></i>{$uname}</span>";
				$str.="</p>";
				$str.="<p>{$q_plain}<br/>";
				if(!empty($q->img))
				{
					if(file_exists("asset/images/upload/{$q->img}"))
					{
					$str.="<img src='".base_url()."asset/images/upload/{$q->img}' alt='&nbsp;'/>";
					}
				}
				$str.="<br/><a href='{$view_url}' class='btn btn-default btn-xs'><i class='fa fa-eye'></i>&nbsp;View Answer</a></p>";
				
				$str.="</li>";

				$str.="</ul><hr>";
			}
		}
		return $str;
	}

	function view_ans()
	{
		$qid=$this->uri->segment(4);
		$ques=$this->member_question_model->find($qid);
		$ans=$this->mem_ques_ans_model->find_by('mqid',$qid);

		$data['q_ans']=$this->qans($ques,$ans);
		$data['qid']=$qid;
		$data['title']='Asked Question Answer';
		$this->load->blade('member.view_ans', $data);
	}

	function qans($q,$q_ans)
	{
		$str="";
		if($q)
		{
				$view_url=base_url()."member/req_ask_list/view_ans/{$q->id}";
				$user=$this->user_model->find($q->user_id);

				$q_plain=strip_tags(trim($q->ques),"<img></u><sub><sup><i><b>");
				$str.="<ul class='list-unstyled qlst'>";
				$str.="<li>";
				$str.="<h4>Question: {$q->title}</h4>";
				$dt=date_create($q->post_date);
				$dtf=date_format($dt,'d F, Y H:i');
				$str.="<p class='qfooter'><span><i title='Post time' class='fa fa-clock-o'></i>{$dtf}</span>";
				$uname=$user?$user->user_name:'';
				$str.="<span><i class='fa fa-user'></i>{$uname}</span>";
				$str.="</p>";
				$str.="<p>{$q_plain}<br/>";
				if(!empty($q->img))
				{
				$str.="<img src='".base_url()."asset/images/upload/{$q->img}' alt='&nbsp;'/>";
				}
				$str.="</p>";
				
				$str.="</li>";
				$str.="</ul><hr>";

				if($q_ans)
				{
					$ans_user=$this->user_model->find($q_ans->ans_by);
					$ans_plain=strip_tags($q_ans->ans,"<img><i><u><sub><sup><b>");
					$str.="<ul class='list-unstyled q_ans'>";
					$str.="<li>";
					$dt_ans=date_create($q_ans->ans_date);
					$dtf_ans=date_format($dt_ans,'d F, Y H:i');
					$str.="<h4>Answer</h4>";
					$str.="<p class='qfooter'><span><i title='Post time' class='fa fa-clock-o'></i>{$dtf_ans}</span>";
					$str.="<span><i class='fa fa-user'></i>{$ans_user->user_name}</span></p>";
					$str.="<p>{$ans_plain}</p>";
					$str.="</li>";
					$str.="</ul>";
				}
		}
		return $str;
	}

}

/* End of file req_ask_list.php */
/* Location: ./application/controllers/member/req_ask_list.php */
