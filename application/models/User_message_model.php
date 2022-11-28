<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_message_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table="user_message";
	}

	function exists($user,$msg_id)
	{
		$this->db->where('user_id',$user);
		$this->db->where('message_id',$msg_id);
		$qry=$this->db->get('user_message');
		if($qry->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function update_by_user($user,$msg_id,$data)
	{
		$this->db->where('user_id',$user);
		$this->db->where('message_id',$msg_id);
		$this->db->update('user_message',$data);
	}

	function get_user_message($uid)
	{
		$this->db->where('um.user_id',$uid);
		$this->db->where('m.published','1');
		$this->db->where("DATE_FORMAT(m.publish_date,'%d-%m-%Y')<=",date('d-m-Y'));
		$this->db->where('m.type','1');
		$this->db->where('um.is_read','0');
		$this->db->select('m.*');
		$this->db->from('user_message um');
		$this->db->join('message m','um.message_id=m.id');
		$qry=$this->db->get();
		if($qry->num_rows()>0)
		{
			//var_dump($qry->result());
			return $qry->result();
		}
		else
		{
			return false;
		}
	}


	function get_user_notification($uid)
	{
		$this->db->where('user_id',$uid);
		$this->db->where('m.published','1');
		$this->db->where("DATE_FORMAT(m.publish_date,'%d-%m-%Y')<=",date('d-m-Y'));
		$this->db->where('m.type','2');
		$this->db->where('um.is_read','0');
		$this->db->select('m.*');
		$this->db->from('user_message um');
		$this->db->join('message m','um.message_id=m.id');
		$qry=$this->db->get();
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}


}

/* End of file user_message_model.php */
/* Location: ./application/models/user_message_model.php */