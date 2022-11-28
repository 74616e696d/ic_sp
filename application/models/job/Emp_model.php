<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='employers_details';
	}

		//insert into user table
		function insertUser($data)
	    {
			return $this->db->insert('employers_details', $data);
		}
		
		//send verification email to user's email id
		function sendEmail($to_email)
		{
			$from_email = 'postmaster@mail.iconpreparation.com';
			$subject = 'Verify Your Email Address';
			$message = 'Dear User,<br/><br/>
			Please click on the below activation link to verify your email address.<br/>
			<br/> http://www.gmail.com/user/verify/' . md5($to_email) . '<br/>
			<br /><br />Thanks<br />revinr Team';
			
			//configure email settings
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = 'smtp.mailgun.org'; //smtp host name
			$config['smtp_port'] = '465'; //smtp port number
			$config['smtp_user'] = $from_email;
			$config['smtp_pass'] = '3f17d564ae63bf6ac197a5de35b2381d-4534758e-b90b8473'; //$from_email password
			$config['mailtype'] = 'html';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$config['newline'] = "\r\n"; //use double quotes
			$this->email->initialize($config);
			
			//send mail
			$this->email->from($from_email, 'Iconpreparation Jobs');
			$this->email->to($to_email);
			$this->email->subject($subject);
			$this->email->message($message);
			return $this->email->send();
		}
		
		//activate user account
		function verifyEmailID($key)
		{
			$data = array('is_verified' => 1);
			$this->db->where('md5(email)', $key);
			return $this->db->update('employers_details', $data);
		}


		public function user_login_data_check($email,$password)
		{
			$reg_email = $this->input->post('reg_email');
			$password = md5($this->input->post('password'));
			$attr = array(
				'email' =>$reg_email,
				'password' =>$password,
				'is_active'=>1
				);

			$qry = $this->db->get_where('employers_details',$attr);

			if($qry->num_rows()>0){
				$data=$qry->row();
				$attr = array(
					'company_id' => $data->id,
					'company_name' => $data->company_name,
					'company_email' => $data->email,
				);
				$this->session->set_userdata($attr);
				return TRUE;
			}
			else{
				return FALSE;
			}
		}

		public function is_user_logged_in(){
			return $this->session->userdata('current_user_id') !=FALSE;
		}

}

/* End of file emp_model.php */
/* Location: ./application/models/job/emp_model.php */