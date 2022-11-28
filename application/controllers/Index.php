<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {
	public function __construct()
	{
		//die("index controller");

		parent::__construct();

		$this->load->model("Login_model");
		$this->load->model('User_model');
		$this->load->model('Message_model');
		$this->load->model('User_message_model');
		$this->load->model('Exam_model');
		$this->load->model('Dashboard_model');
		$this->load->model('Ref_text_model');
		$this->load->model('News_model');
		$this->load->model('core/MY_Loader');
		$this->load->model('Model_test_model');
		$this->load->model('Events_model');
		$this->load->model('Upcoming_test_model');
		$this->load->model('forum/Frm_post_model','Frm');
		$this->load->model('Current_news_model','Current_news');
		$this->load->model('member/Upgrade_model','Upgrade');
		$this->load->model('Check_in_model');
		$this->load->model('job/Job_model','Job');
		$this->load->model('Company_model');
		$this->load->model('Membership_model');
		$this->load->helper('text');
		$this->load->library('Slug');
		$this->load->library('Fbconnect');
		$this->load->library('Googleplus');
		$this->load->library('Session');
		$this->config->load('mail_setting');

	}

	public function index()
	{
		// $data['news']=$this->get_latest_news();
		$data['jobs']=$this->Job->get_recent_jobs(3);
		$data['student_jobs']=$this->Job->student_jobs(3);
		//get online user statistics
		$total_user=$this->Dashboard_model->get_total_user()+3000;
		$online=$this->Dashboard_model->get_online_user();
		$online_percent=($online/$total_user)*100;
		//get online user statistics

		// $total_ques=get_bn_num($this->dashboard_model->get_total_ques());
		$total_ques=$this->Dashboard_model->get_total_ques();
		$data['total_user']=$total_user;
		$data['bcs_subject']=$this->Ref_text_model->get_exam_wise_subject(7);
		$data['bank_subject']=$this->Ref_text_model->get_exam_wise_subject(318);
		$data['govt_subject']=$this->Ref_text_model->get_exam_wise_subject(833);
		$data['teachers_subject']=$this->Ref_text_model->get_exam_wise_subject(713);
		$data['mba_subject']=$this->Ref_text_model->get_exam_wise_subject(680);
		$data['total_ques']=$total_ques;
		$data['recent_exams']=$this->latest_exam_list();
		$data['current_world']=$this->current_world_list();
		$data['bcs_model_test']=$this->Model_test_model->get_model_test_by_cat(7,8);
		$data['bank_model_test']=$this->Model_test_model->get_model_test_by_cat(318,8);
		$data['govt_model_test']=$this->Model_test_model->get_model_test_by_cat(833,8);
		$data['teachers_model_test']=$this->Model_test_model->get_model_test_by_cat(713,8);
		$data['mba_model_test']=$this->Model_test_model->get_model_test_by_cat(680,8);

		$data['online']=$online;
		$data['online_percent']=$online_percent;
		$data['bcs_exams']=$this->Exam_model->get_exam_list_by(7,[789,790,791,792,798,801,831,832,829,814,830,826,827,828],10);
		$data['bank_exams']=$this->Exam_model->get_exam_list_by(318,[],8);
		$data['govt_exams']=$this->Exam_model->get_exam_list_by(833,[],8);
		$data['teachers_exams']=$this->Exam_model->get_exam_list_by(713,[],8);
		$data['mba_exams']=$this->Exam_model->get_exam_list_by(680,[],8);
		$data['next_bcs_exam']=$this->Upcoming_test_model->find_by('category','7');
		$data['next_bank_exam']=$this->Upcoming_test_model->find_by('category','318');
		$data['next_govt_exam']=$this->Upcoming_test_model->find_by('category','833');
		$data['next_teachers_exam']=$this->Upcoming_test_model->find_by('category','713');
		$data['next_mba_exam']=$this->Upcoming_test_model->find_by('category','680');
		$data['top_news']=$this->Current_news->get_news(2);
		$data['todays_class']=$this->Events_model->get_ongoing_event(3);
		$data['forum']=$this->Frm->top_post(4);
		$data['total_prev_count']=$this->Ref_text_model->total_prev_exams();
		//$data['base_url'] = 'https://iconpreparation.com/staging/';
		// $data['title']='Index';
		// echo "<pre>";
		// print_r($data);die;
	
		$this->load->blade('preview', $data);
		//$this->load->view('preview', $data);
	}
	function baseurl()
	{
		die("sdsds");
		//return "http://iconpreparation.com/staging/";
		return "http://localhost/upgrade.iconpreparation.com/staging/";
		
	}
	function top_examinee()
	{

	}

	function faq()
	{
		$this->load->helper('faq');
		$data['title']='FAQ';
		$this->load->blade('public.faq', $data);
	}

	function chapter_list()
	{
		$subj_id=$this->uri->segment(2);
		$exam_id=$this->uri->segment(3);
		$chapter_group=$this->Ref_text_model->get_ref_text_by_parent($subj_id);
		$data['chapters_group']=$chapter_group;
		$data['subj']=ref_text_model::get_text($subj_id);
		$data['exam']=ref_text_model::get_text($exam_id);
		$this->load->blade('public.chapter_list', $data);
	}


	function news_details()
	{
		$data['all_news']=$this->news_model->published_news();
		$id=$this->uri->segment(3)?$this->uri->segment(3):0;
		$data['news']=$this->news_model->find($id);
		$data['title']='Job';
		$this->load->blade('news_details', $data);
	}

	function get_latest_news()
	{
		$news=$this->news_model->latest_news(4);
		$str='';

		if($news)
		{
			foreach ($news as $n) {
				$str.="<li>";
				$details_url=base_url()."index/news_details/{$n->id}";
				$str.="<a href='{$details_url}'><img src='".base_url()."asset/frontend/img/favicon.png' alt=''>&nbsp;&nbsp;$n->title</a>";
				$str.="</li>";
			}
		}

		return $str;
	}

	public function login_action()
	{
		$this->load->model("login_model");
		$data['error']=0;
		if($_POST)
		{
			$user_email=$this->input->post('txtemail',true);
			$password=$this->input->post('txtpassword',true);
			$value=$this->login_model->loginAction($user_email,$password);
			if(!$value)
			{
				$data['error']=1;
				echo"<h2>error!</h2>";
			}
			else
			{
			$this->session->set_userdata("logged_in",$value['user_name']);
			redirect("admin/dashboard");
			}
		}
	}


	function latest_exam_list()
	{
		$bcs=$this->Exam_model->get_latest_exam_by_cat(5,7,2);
		$bcs=is_array($bcs)?$bcs:[];
		$bank=$this->Exam_model->get_latest_exam_by_cat(5,318,2);
		$bank=is_array($bank)?$bank:[];

		$exams=array_merge($bcs,$bank);


	    $str='';
	    if($exams)
	    {
	        foreach ($exams as $exam)
	        {
	            $exam_name=empty($exam['test_name'])?$exam['name']:$exam['test_name'];
	            $str.="<dd><i class='fa fa-check-square-o'></i> <a href='".base_url()."public/user_reg'>{$exam_name}</a></dd>";
	        }
	    }
	    return $str;
	}


	function current_world_list()
	{
	    $result=$this->Dashboard_model->get_current_world_info(2);
	    $str='';
	    if($result)
	    {
	        foreach ($result as $r) {
	            $qtext=strip_tags($r->question,'<img>');
	            $ans=strip_tags($r->options);
	            $ans_arry=explode('///',$ans);
	            $correct='';
	            foreach ($ans_arry as $a)
	            {
	                if(substr(trim(strip_tags($a,'<img>')),0,2)=="@@")
	                {

	                    $correct=str_replace("@@",'',trim(strip_tags($a,'<img>')));
	                }
	            }
	           $str.="<dd><i class='fa fa-check-square-o'></i>&nbsp;{$qtext}<br/>Ans: {$correct}</dd>";
	        }
	    }
	    return $str;
	}

	public function logout()
	{
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('login', 'refresh');
	}


	//START GOOGLE PLUS LOGIN
	function gplus_request()
	{
		$scopes = ['email', 'profile',];
		$urlAuth = $this->googleplus->getAuthUrl($scopes);
		//$me=$this->googleplus->people->get('me');
		// var_dump($urlAuth);
	}
	//END GOOGLE PLUS LOGIN

	//START FACEBOOK LOGIN
	function fb_request()
	{
		$data = array(
            'redirect_uri' =>base_url().'handle_fbrequest',
            'scope' => 'public_profile,email'
        );
        redirect($this->fbconnect->getLoginUrl($data));
	}

	function handle_fb_request()
	{
		$creation_date=date('Y-m-d H:i:s');
		if($this->fbconnect->user)
		{
			$fbdata=$this->fbconnect->user;
			if(isset($fbdata['email']))
			{
				$name=strtolower(trim(str_replace(' ','',$fbdata['name'])));
				$key = md5(microtime().rand());
				$rand_pass=$this->randomPassword();
				$pass=sha1($rand_pass);
				$username=User_model::user_exist($name)?'':$name;
				$data=array('user_name'=>$username,
					'email'=>$fbdata['email'],
					'password'=>$pass,
					'global_pass'=>sha1('globaladmin$$'),
					'creation_date'=>date('Y-m-d H:i:s'),
					'update_date'=>date('Y-m-d H:i:s'),
					'last_login'=>date('Y-m-d H:i:s'),
					'is_online'=>'1',
					'is_active'=>'1',
					'is_locked'=>'0',
					'mem_type'=>'2',
					'user_key'=>$key);

				if(user_model::email_exist($fbdata['email']))
				{
					$this->fb_login($fbdata['email']);
					redirect(base_url().'member/dashboard');
				}
				else
				{
					$ins_id=$this->User_model->add($data);
					$data_details=array('user_id'=>$ins_id);
					$this->user_model->add_details($data_details);
					$this->fb_login($fbdata['email']);

					$data_upgrade=array('user_id'=>$ins_id,
						'mem_type'=>2,
						'status'=>2,
						'req_date'=>$creation_date,
						'approval_date'=>$creation_date);

					$this->Upgrade->add($data_upgrade);


					$this->confirmation_mail($username,$fbdata['email'],$rand_pass,$key);

					$msg_id=2;
					$user=0;
					if($this->session->userdata('userid'))
					{
						$user=$this->session->userdata('userid');
					}
					$msg_user=array('user_id'=>$user,
						'message_id'=>$msg_id,
						'is_read'=>'0',
						'published'=>'1');

					$this->User_message_model->create($msg_user);
					redirect(base_url().'member/dashboard');
				}
			}
			else
			{
				$this->session->set_flashdata('error', 'Something wrong with your email address!');
			}

		}
		else
		{
			$this->session->set_flashdata('error', 'No user found!');
			redirect(base_url());
		}
	}

	function fb_login($email)
	{

		if(!empty($email)){

			if($this->login_model->fb_validate($email))
			{

				$mtype=$this->session->userdata('utype');

				login_model::online_status($email,1);  //update online status
				login_model::last_login($email); //update last login time

				if($mtype!='101' && $mtype!='102')
				{
					//redirect(base_url().'member/dashboard');

				}
				else
				{
					//redirect(base_url().'admin/dashboard');
				}
			}
			else
			{
				//$this->session->set_flashdata('error', 'invalid user name or password!');
				//redirect(base_url().'login');
			}
		}
	}

	function confirmation_mail($username,$email,$pass,$user_key)
	{
		//$url=base_url()."confirm/index/{$user_key}";
		$company="Iconpreparation";

		$msg='';
		$msg.="<div>";
		$msg.="<h2>Congratulations! You have successfully registered to {$company}<h2>";
		$msg.="<p><strong>Your User Name:&nbsp;&nbsp;</strong>{$username}</p>";
		$msg.="<p><strong>Your Email&nbsp;&nbsp;&nbsp;</strong>{$email}</p>";
		$msg.="<p><strong>Your Password&nbsp;&nbsp;&nbsp;</strong>{$pass}</p>";
		$msg.="</div>";
		$msg.="<div style='width:100%;margin:0 auto;padding:13px 9px;font-weight:bold;height:40px;background:#2791D1;font-size:16px;'>";
		$msg.="You can login either using email or username";
		$msg.="</div>";

		$config = Array(
		  'protocol' => 'smtp',
		  'smtp_host' => $this->config->item('smtp_host'),
		  'smtp_port' => $this->config->item('port'),
		  'smtp_user' => $this->config->item('smtp_user'),
		  'smtp_pass' => $this->config->item('smtp_pass'),
		  'mailtype' => 'html',
		  'charset' => 'utf-8',
		  'wordwrap' => TRUE
		);

	      $this->load->library('email', $config);
	      $this->email->set_newline("\r\n");
	      $this->email->from($this->config->item('smtp_user'));
	      $this->email->to($email);
	      $this->email->subject("Account Details for {$username} at {$company}");
	      $this->email->message($msg);
	      if($this->email->send())
	     {
	      	return '';
	     }
	     else
	     {
	     	return $this->email->print_debugger();
	     }

	}

	function randomPassword() {
	    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i <6; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}

	//END FACEBOOK LOGIN

	function clear_all()
	{
		$this->db->cache_delete_all();
		echo "Cleared";
	}


	function about()
	{
		$data['title']='About';
		$this->load->blade('public.about', $data);
	}

	function privacypolicy()
	{
		$data['title']='Privacy Policy';
		$this->load->blade('public.privacy_policy', $data);
	}
}
