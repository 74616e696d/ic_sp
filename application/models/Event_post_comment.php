<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_post_comment extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='post_comment';
	}

	function all_comment()
	{
		$this->db->cache_off();
		$sql="select ep.post_title,pc.*from post_comment pc join event_post ep on pc.post_id=ep.id order by id desc";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function published_comment($post_id)
	{
		$this->db->cache_off();
		$sql="select *from post_comment where post_id={$post_id} and display=1 order by id desc";
		$qry=$this->db->query($sql);
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

/* End of file event_post_comment.php */
/* Location: ./application/models/event_post_comment.php */