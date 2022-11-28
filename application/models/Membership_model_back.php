<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Membership_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
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

	/**
	 * to authenticate a user
	 * @return boolean [description]
	 */
	public static function is_authenticate($roles=array())
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
		        redirect(base_url().'login');
		    }	
		}
		else
		{
			 redirect(base_url().'login');
		}
	}


}
