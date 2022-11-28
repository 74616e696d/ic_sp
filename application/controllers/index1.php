<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends Public_Controller {
	public function __construct() 
	{		 
		parent::__construct(); 
		$this->load->model("login_model");
		$this->load->library('fbconnect'); 
		$this->load->library('googleplus'); 
		$this->load->model('user_model'); 
		$this->load->helper('common');
		$this->config->load('mail_setting'); 
		$this->load->model('message_model');
		$this->load->model('user_message_model');
		$this->load->model('exam_model');
		$this->load->model('dashboard_model');
		$this->load->model('ref_text_model');
		$this->load->model('news_model');
		$this->load->library('session'); 
		$this->load->model('model_test_model');   
		$this->load->model('member/upgrade_model','upgrade'); 
	}
		
	public function index()
	{

		$data['news']=$this->get_latest_news();
		//get online user statistics
		$total_user=$this->dashboard_model->get_total_user()+3000;
		$online=$this->dashboard_model->get_online_user();
		$online_percent=($online/$total_user)*100;
		//get online user statistics
		


		$total_ques=get_bn_num($this->dashboard_model->get_total_ques());
		$data['total_user']=$total_user;
		$data['bcs_subject']=$this->ref_text_model->get_exam_wise_subject(7);
		$data['bank_subject']=$this->ref_text_model->get_exam_wise_subject(318);
		$data['total_ques']=$total_ques;
		$data['recent_exams']=$this->latest_exam_list();
		$data['current_world']=$this->current_world_list();
		$data['model_test']=$this->model_test_model->get_model_test(6);
		$data['online']=$online;
		$data['online_percent']=$online_percent;

		$data['title']='Index';
		$this->load->blade('v_index', $data);
	}

	function top_examinee()
	{
		
	}


	function news_details()
	{
		$data['all_news']=$this->news_model->published_news();
		$id=$this->uri->segment(3)?$this->uri->segment(3):0;
		$data['news']=$this->news_model->find($id);
		$data['title']='';
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
		$bcs=$this->exam_model->get_latest_exam_by_cat(5,7,2);
		$bcs=is_array($bcs)?$bcs:[];
		$bank=$this->exam_model->get_latest_exam_by_cat(5,318,2);
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
	    $result=$this->dashboard_model->get_current_world_info(2);
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
		var_dump($urlAuth);
	}
	//END GOOGLE PLUS LOGIN

	//START FACEBOOK LOGIN
	function fb_request()
	{
		$data = array(
            'redirect_uri' =>base_url().'index/handle_fb_request',
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
				$username=user_model::user_exist($name)?'':$name;
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
					$ins_id=$this->user_model->add($data);
					$data_details=array('user_id'=>$ins_id);
					$this->user_model->add_details($data_details);
					$this->fb_login($fbdata['email']);
					
					$data_upgrade=array('user_id'=>$ins_id,
						'mem_type'=>2,
						'status'=>2,
						'req_date'=>$creation_date,
						'approval_date'=>$creation_date);

					$this->upgrade->add($data_upgrade);


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

					$this->user_message_model->create($msg_user);
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

	
}
	