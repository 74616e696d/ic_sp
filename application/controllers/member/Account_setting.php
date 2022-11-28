<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Carbon\Carbon;
class Account_setting extends Member_controller {
		
		public function __construct()
		{
			parent::__construct();

			$this->load->model('membership_model', 'memod');
			$this->load->model('user_model');
			$this->load->model('exam_model');
			$this->load->model('ref_text_model');
			$this->load->model('Exam/choosen_category_model','choosen');
			$this->load->model('dashboard_model');
			$this->load->model('permission_model');
			$this->load->model('university_model');
		}

		public function index()
		{
			$first_time=true;
			$reg_msg='';
			
			if($first_time)
			{
				$reg_msg=info_message("Congratulations! You you are enjoying basic membership.");
			}
			$data['reg_msg']=$reg_msg;

			$uid=0;
			if($this->session->userdata('userid'))
			{
				$uid=$this->session->userdata('userid');
			}

			$data['latest_exam']=$this->latest_exam_list();
			$data['choosen']=$this->choosen->get_choosen_cat($uid);

			$data['exam_cat']=$this->ref_text_model->get_ref_text_by_group(2);
			
			$data['info_list'] = $this->memod->select_user_profile($uid);
			
			$data['title']='Profile';
			$data['current_world']=$this->current_world_list();
			$this->load->blade('member.v_account_setting', $data);
		}

		function latest_exam_list()
		{
		    $str='';
		    $exams=$this->exam_model->get_latest_exam(5);
		    if($exams)
		    {
		        foreach ($exams as $exam) 
		        {
		            $url=base_url()."member/take_exam/confirm_take_exam/{$exam->id}";
		            $exam_name=empty($exam->test_name)?$exam->name:$exam->test_name;
		            $str.="<div class='bx bx-body adv'>";
		            $str.="<h4>{$exam_name}</h4>";
		            $str.="<p>Question added</p>";
		            $str.="<a class='btn btn-default' href='{$url}'>Start Now</a>";
		            //$str.="<li style='line-height:40px;'><span style='display:block;width:60%;float:left;text-align:left;'>{$exam_name}</span>&nbsp;&nbsp;<span style='display:block;width:20%;float:right;text-align:right;'><a class='btn btn-default' href='{$url}'>Start Now</a></span></li>";
		            $str.="</div>";
		        }
		    }
		    return $str;
		}


		function save_profile()
		{
			$uid=0;
			$utype=0;
			if($this->session->userdata('userid'))
			{
				$uid=$this->session->userdata('userid');
				$utype=$this->session->userdata('utype');
			}

			$username=$this->input->post('txtusername');
			$fname=$this->input->post('txtfirstname');
			$email=$this->input->post('txtemail');
			$phone=$this->input->post('txtphone');
			$location=$this->input->post('location');
			$img_name='';
			$img_name_new=$this->input->post('hdnNewImg');
			$img_name=$this->input->post('hdnOldImg');
			

			if(!empty($email))
			{
				if(!empty($img_name_new))
				{
					if(!empty($img_name))
					{
						if(file_exists("asset/images/upload/{$img_name}"))
						{
							unlink("asset/images/upload/{$img_name}");
						}
						$img_name=thumb_img_upload('userfile');

					}else
					{

						$img_name=thumb_img_upload('userfile');
					}
				}

				$data=array(
					//'user_name'=>$username,
					'email'=>$email);
				$data_details=array('full_name'=>$fname,
					'phone'=>$phone,
					'address'=>$location,
					'photo'=>$img_name);
				if($this->username!=$username && $this->email!=$email)
				{
					if(!user_model::user_exist($username) && !user_model::email_exist($email))
					{
						$this->user_model->update_user($uid,$data);
					}
					else
					{
						$this->session->set_flashdata('warning', 'username or email already taken!');
						redirect(base_url().'member/account_setting');
					}
				}
				else
				{
					$this->user_model->update_user($uid,$data);
				}
				
				$this->user_model->update_user_details($uid,$data_details);
				$this->session->set_flashdata('success', 'Profile saved successfully!');
				redirect(base_url().'member/account_setting');
			}
			else
			{
				$this->session->set_flashdata('error', 'Email cannot be empty!');
				redirect(base_url().'member/account_setting');			
			}
		}

		function current_world_list()
		{
		    $result=$this->dashboard_model->get_current_world_info(5);
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
		           $str.="<li><span style='font-size:15px;'><i class='fa fa-hand-o-right'></i>&nbsp;{$qtext}<br/><span><span style='font-size:13px;'>Ans:&nbsp;&nbsp;{$correct}</span></li>";
		        }
		    }
		    return $str;
		}
		

		function check_user()
		{
			$user=$this->input->get('username');
			$curr_user=$this->input->get('curruser');
			$str="";
			if($curr_user!=$user && !empty($user))
			{
				if(!user_model::user_exist($user))
				{
					$str.="<span class='input-group-addon add-on-success'>";
					$str.="<i class='fa fa-check'></i> User Name Available!";
					$str.="</span>";
				}
				else
				{
					$str.="<span class='input-group-addon add-on-error'>";
					$str.="<i class='fa fa-times'></i> User Name Already Taken!";
					$str.="</span>";
				}
			}

			echo $str;
		}

		function check_email()
		{
			$email=$this->input->get('email');
			$curr_email=$this->input->get('curremail');
			$str="";
			if($curr_email!=$email && !empty($email))
			{
				if(!user_model::email_exist($email))
				{
					$str.="<span class='input-group-addon add-on-success'>";
					$str.="<i class='fa fa-check'></i>Email Available!";
					$str.="</span>";
				}
				else
				{
					$str.="<span class='input-group-addon add-on-error'>";
					$str.="<i class='fa fa-times'></i>Email Already Taken!";
					$str.="</span>";
				}
			}
			echo $str;
		}

		public function update_account_info()
		{
			$uid=0;
			if($this->session->userdata('userid'))
			{
				$uid=$this->session->userdata('userid');
			}

			$stdlevel=$this->input->post('ddl_study_lebel');
			$inst=$this->input->post('institute_name');
			$prgm=$this->input->post('program_name');
			$ssn=$this->input->post('session_year');
			if($stdlevel!=-1)
			{
				$data=array('study_level'=>$stdlevel,
					'institute_name'=>$inst,
					'dept_group'=>$prgm,
					'session'=>$ssn);
				
				$this->user_model->update_user_details($uid,$data);
				$this->session->set_flashdata('success','Account details saved successfully!');
				redirect(base_url()."member/account_setting");
			}
			else
			{
				$this->session->set_flashdata('error', 'You must select a study level!');
				redirect(base_url()."member/account_setting");
			}

		}

		function choosen_cat_view()
		{
			$uid=0;
			$utype=0;
			if($this->session->userdata('userid'))
			{
				$uid=$this->session->userdata('userid');
				$utype=$this->session->userdata('utype');
			}
			$count=$this->choosen->approval_count($uid);
			$first_time=true;
			$reg_msg='';
			
			if($first_time)
			{
				if($utype==2)
				{
					$reg_msg=info_message("You you are enjoying basic membership.");
					if($this->permission_model->basic_expired($this->userid))
					{
						$reg_msg=warning_message("Your basic membership has been expired !Please upgrade");
					}
				}
				elseif ($utype==3) {
					$reg_msg=info_message("You you are enjoying intermediate membership with <u>{$count} exam categories</u>.");
				}
				elseif ($utype==4) {
					$reg_msg=info_message("You you are enjoying premium membership with <u>{$count} exam categories</u>.");
				}
			}
			$data['reg_msg']=$reg_msg;
			$data['choosen']=$this->choosen_item($uid);
			//$data['choosen']=$this->choosen->get_choosen_cat($uid);
			//$data['exam_cat']=$this->ref_text_model->get_ref_text_by_group(2);
			$data['title']='Select Exam Category';
			$this->load->blade('member.choosen_cat', $data);
		}

		function choosen_item($uid)
		{
			$exam_cat=$this->ref_text_model->get_ref_text_by_group(2);
			$str='';
			if($exam_cat)
			{
				foreach ($exam_cat as $cat) {
					$cat_text=ref_text_model::get_text($cat->id);
					$choosen=$this->choosen->get_exam_choosen_by_cat($uid,$cat->id);
					$choosed='';
					$status='No Requested';
					$req_date='--';
					$exp_date='--';
					$enabled='';
					//$remainning_date=0;
					if($choosen)
					{
						$choosed='checked';
						
						if($this->utype==2)
						{
							if($this->permission_model->basic_expired($this->userid))
							{
								$enabled='disabled';
							}
						}
						
						if($choosen->status==1)
						{
							$status="<span style='color:#FFAA66;'>Pending</span>";
							$dt=date_create($choosen->request_date);
							$req_date=date_format($dt,'d F, Y h:i A');
							$dt1=date_create($choosen->expiry_date);
							$exp_date=date_format($dt1,'d F, Y h:i A');
						}
						else if($choosen->status==2)
						{
							$status="<span style='color:#009000'>Approved</span>";
							$dt=date_create($choosen->request_date);
							$req_date=date_format($dt,'d F, Y h:i A');
							$dt1=date_create($choosen->expiry_date);
							$exp_date=date_format($dt1,'d F, Y h:i A');
						}
						else
						{
							$status='Not Requested';
							$req_date='--';
							$exp_date='--';
						}

					}

					$str.="<tr>";
					$str.="<td><input type='checkbox' {$enabled} {$choosed} class='ck_cat' id='ck_cat_{$cat->id}' value='{$cat->id}'/>&nbsp;&nbsp;{$cat_text}</td>";
					$str.="<td>{$status}</td>";
					$str.="<td>{$req_date}</td>";
					$str.="<td>{$exp_date}</td>";
					$str.="</tr>";
				}
			}


			return $str;
		}

		function user_category_save()
		{
			$user_type=0;
			$user=0;
			if($this->session->userdata('userid'))
			{
				$user=$this->session->userdata('userid');
				$user_type=$this->session->userdata('utype');
			}

			$choosen_count=$this->choosen->choosen_count($user_type);
			$exam_cat=$this->input->post('cat');
			$state=$this->input->post('state');
			
			$cat_text=ref_text_model::get_text($exam_cat);
			$dt=Carbon::now();
			$now=Carbon::createFromFormat('Y-m-d H:i:s',$dt)->toDateTimeString();
			$expiry_dt=Carbon::now()->addweeks(2);
			$expiry=Carbon::createFromFormat('Y-m-d H:i:s',$expiry_dt)->toDateTimeString();

			$status=2;
			$app_count=$this->choosen->approval_count($user);
			if($app_count==0)
			{
				$status=2;
			}
			else
			{
				$status=1;
			}
			/*
			*status->0=Not Requested
			*status->1=Requested & Waitting For Approval
			*status->2=Approved
			 */
			if($state!=0)
			{
				if($user_type!=2)
				{
					if(!$this->choosen->exists($user,$exam_cat))
					{
						$data=array('user_id'=>$user,
							'exam_cat'=>$exam_cat,
							'status'=>$status,
							'request_date'=>$now,
							'expiry_date'=>$expiry);
						$this->choosen->insert($data);
						echo success_message("You have select {$cat_text}!");
					}
					else
					{
						
						$data=array('user_id'=>$user,
						'exam_cat'=>$exam_cat,
						'status'=>$status,
						'request_date'=>$now,
						'expiry_date'=>$expiry);
						$this->choosen->update($user,$exam_cat,$data);
						echo success_message("You have select {$cat_text}!");
					}
				}
				else
				{
					if($app_count>0)
					{
						$upgrade_link=base_url().'member/membership_upgrade';
						$feature_link=base_url()."public/memberhip_comparison";
						echo warning_message("Please upgrade your membership to choose more exam category and many more <a target='_blank' href='{$feature_link}'>features</a>. Click here to upgrade <a target='_blank' href='{$upgrade_link}'>click here</a>");
					}
					else
					{
						if(!$this->choosen->exists($user,$exam_cat))
						{
							$data=array('user_id'=>$user,
								'exam_cat'=>$exam_cat,
								'status'=>$status,
								'request_date'=>$now,
								'expiry_date'=>$expiry);
							$this->choosen->insert($data);
							echo success_message("You have select {$cat_text}!");
						}
						else
						{
							
							$data=array('user_id'=>$user,
							'exam_cat'=>$exam_cat,
							'status'=>$status,
							'request_date'=>$now,
							'expiry_date'=>$expiry);
							$this->choosen->update($user,$exam_cat,$data);
							echo success_message("You have select {$cat_text}!");
						}
					}
				}
				

			}
			else
			{
				//$this->choosen->delete($user,$exam_cat);
				//echo msg_info("You have deselected {$cat_text}!");
			}
		}

		/**
		 * function to change user password
		 * @return [type] [description]
		 */
		function change()
		{
			$old_pass=$this->input->post('txt_old_pass');
			$pass=$this->input->post('txt_password');
			$pass_again=$this->input->post('txt_password_again');

			$user=0;
			if($this->session->userdata('userid'))
			{
				$user=$this->session->userdata('userid');
			}

			$get_user=$this->user_model->find($user);
			if($get_user->password==sha1($old_pass))
			{
				if($pass==$pass_again)
				{
					$data=array('password'=>sha1($pass));
					$this->user_model->update_user($get_user->id,$data);
					$this->session->set_flashdata('success', 'Password successfully changed!');
					redirect(base_url().'member/account_setting');
				}
				else
				{
					$this->session->set_flashdata('error', 'new password and retype new password does not match');
					redirect(base_url().'member/account_setting');
				}
			}
			else
			{
				$this->session->set_flashdata('error', 'incorrect old password!');
			}

		}


		function get_uni_name()
		{
			$term=$this->input->get('term');
			$this->university_model->get_university(strtolower($term));
		}	
	
	}
	
	/* End of file account_setting.php */
	/* Location: ./application/controllers/member/account_setting.php */
?>