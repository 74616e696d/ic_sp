<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Check_in_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='event_check_in';
	}

	function get_count($event_id)
	{
		$this->db->cache_off();
		$this->db->where('event_id',$event_id);
		$this->db->select('id');
		$qry=$this->db->get('event_check_in');
		return $qry->num_rows();
	}

	static function checked_count($event_id)
	{
		$ci =& get_instance();
		$ci->db->cache_off();
		$ci->db->where('event_id',$event_id);
		$ci->db->select('id');
		$qry=$ci->db->get('event_check_in');
		return $qry->num_rows();
	}

	/**
	 * check user already checkin or not for an event
	 * @param  [type] $uid      [description]
	 * @param  [type] $event_id [description]
	 * @return [type]           [description]
	 */
	function checked_in($uid,$event_id)
	{
		$this->db->cache_off();
		$this->db->where('user_id',$uid);
		$this->db->where('event_id',$event_id);
		$qry=$this->db->get('event_check_in');
		if($qry->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function remove_check_in($uid,$event_id)
	{
		$this->db->where('user_id',$uid);
		$this->db->where('event_id',$event_id);
		$this->db->delete('event_check_in');
	}

}

/* End of file check_in_model.php */
/* Location: ./application/models/check_in_model.php */