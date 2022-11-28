<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Carbon\Carbon;

class Membership_model extends CI_Model {

	/**
	 * premium member id
	 */
	public $premium_member_id=10;

	/**
	 * trial member id
	 */
	public $trial_member_id=2;
	/**
	 * membership rate for each day
	 * @var integer
	 */
	private $rate=4;

	/**
	 * Type of membership in days
	 * @var arrays
	 */
	public $mem_type=[
			'Two Month'=>60,
			'Three Month'=>90,
			'Six Month'=>180,
			'Twelve Month'=>360
			];



	function __construct()
	{
		parent::__construct();
	}

	/**
	 * get membership and its duration
	 * @return array
	 */
	function membership()
	{
		return $this->mem_type;
	}

	/**
	 * get expire date of membership
	 *
	 * @param  integer $day
	 * @param  datetime $start
	 *
	 * @return datetime
	 */
	function expire_date($day=0,$start=null)
	{
		if($start==null){
			return Carbon::now()->addDays(trim($day));
		}
		$start_date=Carbon::parse($start);
		return $start_date->addDays(trim($day));
	}

	/**
	 * Get rate of each day full membership
	 * @return integer
	 */
	function rate()
	{
		return $this->rate;
	}

	/**
	 * Get Payment amount according to membership setting
	 *
	 * @return integer
	 */
	function get_amount($day=0)
	{
		return $this->rate*$day;
	}

	/**
	 * Get remainning days of a member
	 *
	 * @return integer
	 */
	function remaining_days($user_id)
	{
		$sql="select * from upgrade_request where user_id={$user_id} and mem_type>2";
		$this->db->cache_off();
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			$old_members=[3,4,5,6,7,8];
			$result=$qry->row();
			$now=Carbon::now();
			$exp_date=Carbon::parse($result->exp_date);
			if(in_array($result->mem_type,$old_members))
			{
				$duration=$this->mem_setting($result->mem_type);
				$exp_date=$this->expire_date($duration,$result->approval_date);
			}
			if($exp_date->isPast()){
				return 0;
			}
			return $now->diffInDays($exp_date);

		}
		return 0;
	}


	/**
	 * check if membership is expired
	 * @param  integer  $uid
	 * @return boolean
	 */
    function is_expired($uid)
	{
		if($this->remaining_days($uid)>0)
		{
			return false;
		}
		return true;
	}

	/**
	 * check if a user is paid or not
	 * 
	 * @param  integer  $uid
	 * 
	 * @return boolean     
	 */
	function is_paid($uid)
	{
		return !$this->is_expired($uid);
	}

	/**
	 * extend existing membership by referral
	 *
	 * @param  integer $user_id
	 *
	 * @return void
	 */
	function extend_membership($user_id)
	{
		$sql="select * from upgrade_request where user_id={$user_id}";
		$this->db->cache_off();
		$qry=$this->db->query($sql);
		$current_members=[3,4,5,6,7,8];
		if($qry->num_rows()>0)
		{
			//update existing  upgrade information
			$info=$qry->row();
			$current_exp_date=$info->exp_date;
			$req_date=Carbon::now();
			if($this->is_expired($user_id))//if expired
			{
				$exp_dt=$this->expire_date(7)->toDateTimeString();
				$start=date('Y-m-d H:i:s');
				$this->upgrade($user_id,$exp_dt,$start);
			}
			else //if not exipred
			{
				if(in_array($info->mem_type, $current_members))//if old members
				{
					$duration=$this->mem_setting($info->mem_type);
					$exp_dt=$this->expire_date($duration, $req_date);
					$this->upgrade($user_id, $exp_dt);
				}
				else //if premium members and mem_type=10
				{
					$req_date=Carbon::parse($current_exp_date);
					$exp_dt=$this->expire_date(7,$req_date)->toDateTimeString();
					$this->upgrade($user_id, $exp_dt,$current_exp_date);
				}
			}
		}
	}


	/**
	 * Get membership setting for old members
	 *
	 * @param integer $mtype
	 * @return integer;
	 */
	function mem_setting($mtype)
	{
		$sql="select * from member_setting where mem_type={$mtype} and setting_key=1";
		$qry=$this->db->query($sql);
		return $qry->row()->setting_value;
	}

	/**
	 * update user and upgrade user table
	 * @param  integer $user_id
	 * @param  datetime $start
	 * @param  datetime $end
	 * @return void
	 */
	function upgrade($user_id,$end,$start=null)
	{
		$data=[];
		if($start==null)
		{
			$data=[
			'mem_type'=>10,
			'status'=>2,
			'exp_date'=>$end
			];
		}
		else
		{
			$start=date('Y-m-d H:i:s');
			$data=[
			'mem_type'=>10,
			'status'=>2,
			'req_date'=>$start,
			'approval_date'=>$start,
			'exp_date'=>$end
			];
		}
		$this->db->where('user_id',$user_id);
		$this->db->update('upgrade_request',$data);

		$data_user=['mem_type'=>10];
		$this->update_utype($user_id, $data_user);
	}

	function insert($data)
	{
		$this->db->insert('membership',$data);
		return;
	}
	function add_user($data)
	{
		$this->db->insert('users',$data);
		return;
	}

	function get_members_in($id)
	{
		$sql="select *from membership where id in({$id}) order by FIELD(id,{$id})";
		$query=$this->db->query($sql);
		if($query->num_rows()>0)
		{
			$result=$query->result();
			return $result;
		}
		else
		{
			return false;
		}

	}

	function get_members()
	{
		$query=$this->db->get('membership');
		if($query->num_rows()>0)
		{
			$result=$query->result();
			return $result;
		}
		else
		{
			return false;
		}
	}


	function get_app_date($user)
	{
		$this->db->where('user_id',$user);
		$this->db->select('approval_date');
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$qry=$this->db->get('upgrade_request');
		if($qry->num_rows()>0)
		{
			return $qry->row()->approval_date;
		}
		else
		{
			return false;
		}
	}

	static function get_text($id)
	{
		$ci =& get_instance();
		$ci->db->where('id',$id);
		$qry=$ci->db->get('membership');
		if($qry->num_rows()>0)
		{
			return $qry->row()->name;
		}
		else
		{
			return '';
		}
	}

	/**
	 * get membership amount
	 * @param  integer $mtype
	 * @return [type]    
	 */
	static function get_payable_amount($mtype)
	{
		$ci =& get_instance();
		$ci->db->where('mem_type',$mtype);
		$ci->db->where('setting_key',2);
		$qry=$ci->db->get('member_setting');
		if($qry->num_rows()>0)
		{
			return $qry->row()->setting_value;
		}
		else
		{
			return 0;
		}
	}


	function user_by_email($email)
	{
		$this->db->where('email',$email);
		$this->db->select('user_name,email,user_key');
		$qry=$this->db->get('users');
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}

	function get_member_by_id($id)
	{
		$this->db->where('id',$id);
		$query=$this->db->get('membership');
		if($query->num_rows()>0)
		{
			$result=$query->row();
			return $result;
		}
		else
		{
			return false;
		}
	}

	function update_utype($user,$data)
	{
		$this->db->where('id',$user);
		$this->db->update('users',$data);
	}

	function update($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('membership',$data);
	}

	/**
	 * check if user name exists
	 * RETURN @bool
	 */
	public static function check_user($username)
	{
		$ci =& get_instance();
		$sql="select user_name from users where user_name='".$username."'";
		$query=$ci->db->query($sql);
		if($query->num_rows()>0){
			return true;

		}else
		{
			return false;
		}
	}

	public static function mem_type_text($id)
	{
		$ci =& get_instance();
		$sql="select name from membership where id=".$id;
		$query=$ci->db->query($sql);
		if($query->num_rows()>0){
			return $query->row()->name;
		}else{
			return false;
		}
	}
	/**
	 * check if email exists
	 * RETURN @bool
	 */
	public static function check_email($email)
	{
		$ci =& get_instance();
		$sql="select email from users where email='".$email."'";
		$query=$ci->db->query($sql);
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}

	function activate_user($key,$data)
	{
		$this->db->where('user_key',$key);
		$this->db->update('users');
	}

	/*Akther edited code starts*/
	public function point_system($id)
	{
		$this->db->where('user_id', $id);
		$query = $this->db->get('mem_point');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	public function getUserInfo($id)
	{
		 $this->db->select('users.*');
		 $this->db->from('users');
		 $this->db->where('users.id', $id);
		 $this->db->join('user_details', 'user_details.user_id = users.id');



		$query = $this->db->get();

		return $query->result();
	}

	public function select_user_profile($id)
	{
		$sql = "SELECT us.*, ud.* FROM users us INNER JOIN user_details ud ON us.id = ud.user_id WHERE us.id = '$id'";
		$this->db->cache_off();
		$q = $this->db->query($sql);

		if($q->num_rows()>0)
		{
			return $q->row();
		}
		else
		{
			return false;
		}
	}

	/**
	 * to authenticate a user
	 * @return boolean [description]
	 */
	public static function is_authenticate($roles=array(),$redirect="")
	{
		$ci=& get_instance();
		$test=$ci->session->userdata('userid');
		if($ci->session->userdata('userid'))
		{
			$utype=$ci->session->userdata('utype');

		    if(in_array($utype,$roles))
		    {
		        //something will go here
		  	}
		    else
		    {
		    	if(!empty($redirect))
		    	{
		    		$ci->session->set_flashdata('error', 'Unauthorised access!');
		        	redirect(base_url().'login');
		    	}
		    	else
		    	{
	    			$ci->session->set_flashdata('error', 'Unauthorised access!');
	    		    redirect($redirect);
		    	}

		    }
		}
		else
		{
			 redirect(base_url().'login');
		}
	}


}
