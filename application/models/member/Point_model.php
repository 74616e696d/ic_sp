<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Point_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function add($data)
	{
		$this->db->insert('mem_point',$data);
		return;
	}
	function add_history($data)
	{
		$this->db->insert('mem_point_history',$data);
		return;
	}

	function point_status($uid)
	{
		$this->db->where('user_id',$uid);
		$q=$this->db->get('mem_point');
		if($q->num_rows()>0)
		{
			return $q->row();
		}
		else
		{
			return false;
		}
	}

	function get_point_history($uid)
	{
		$this->db->where('user_id',$uid);
		$q=$this->db->get('mem_point_history');
		if($q->num_rows()>0)
		{
			return $q->result();
		}
		else
		{
			return false;
		}
	}
	function update($uid,$data)
	{
		$this->db->where('user_id',$uid);
		$this->db->update('mem_point',$data);
	}
}

/* End of file point_model.php */
/* Location: ./application/models/member/point_model.php */