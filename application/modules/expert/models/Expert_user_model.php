<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * user model for expert module
 */
class Expert_user_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='expert_user';
	}


	/**
	 * register new user as an expert
	 * 
	 * @param  string $user_name       
	 * @param  string $email           
	 * @param  string $password        
	 * 
	 * @return integer                  
	 */
	function register($user_name,$email,$password)
	{
		$this->db->trans_start();
		$data=[
			'user_name'=>$user_name,
			'email'=>$email,
			'password'=>sha1($password),
			'is_locked'=>0,
			'login_attempt'=>0,
			'is_active'=>1,
			'created_at'=>date('Y-m-d H:i:s')
		];

		$this->db->insert('expert_user',$data);
		$uid=$this->db->insert_id();

		$data_details=['user_id'=>$uid];
		$this->db->insert('expert_details',$data_details);

		$this->db->trans_complete();
		return $uid;
	}

	/**
	 * login an expert user
	 * 
	 * @param  string $email   
	 * @param  string $password
	 * 
	 * @return boolean         
	 */
	function login($email,$password)
	{
		$this->db->where('email',$email);
		$this->db->where('password',sha1($password));
		$this->db->where('is_active',1);
		$this->db->where('is_locked',0);
		$qry=$this->db->get('expert_user');

		if($qry->num_rows()>0)
		{
			$row=$qry->row();
			$data = array(
				'userid' => $row->id,
				'username' => $row->user_name,
				'email' => $row->email,
				'utype'=>'expert',
				'creation_date'=>$row->created_at
			);
			
			$this->session->set_userdata($data);

			$this->set_last_login($row->id);
			return true;
		}
		return false;
	}

	/**
	 * logout from Iconpreparation
	 * 
	 * @return boolean
	 */
	function logout()
	{
		if($this->session->userdata('username'))
		{
			$uid=$this->session->userdata('userid');
			$this->set_online_status($uid,0);
			$this->session->sess_destroy();
			return true;
		}
		return false;
	}

	/**
	 * update last login time after login
	 * 
	 * @param integer $uid
	 *
	 * @return  void
	 */
	function set_last_login($uid)
	{
		$this->db->where('id',$uid);
		$this->db->update('expert_user',['last_login'=>date('Y-m-d H:i:s')]);
	}

	/**
	 * update online status after logout
	 * 
	 * @param integer $uid
	 *
	 * @return  void
	 */
	function set_online_status($uid,$status=0)
	{
		$this->db->where('id',$uid);
		$this->db->update('expert_user',['is_online'=>$status]);
	}

}

/* End of file expert_user.php */
/* Location: ./application/modules/expert/models/expert_user.php */