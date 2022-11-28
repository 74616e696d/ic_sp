<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_post_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table="event_post";
	}
	
	function latest_post()
	{
		$this->db->cache_off();
		$sql="select *from event_post where display=1 order by id desc limit 1";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}


	function all_post($term='')
	{
		$this->db->cache_off();
		$sql="select ep.*,ue.name from event_post ep join upcoming_events ue on ep.event_id=ue.id {$term}";
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

	function count_all($term='')
	{
		$sql="select ep.*,ue.name from event_post ep join upcoming_events ue on ep.event_id=ue.id {$term}";
		$qry=$this->db->query($sql);
		return $qry->num_rows();
	}

	function post_by_event($event_id,$start=0,$limit=1)
	{
		$this->db->cache_off();
		$this->db->where('event_id',$event_id);
		$this->db->where('display',1);
		$this->db->limit($limit,$start);
		$qry=$this->db->get('event_post');
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else{
			return false;
		}
	}	

	function count($event_id)
	{
		$this->db->cache_off();
		$this->db->where('event_id',$event_id);
		$this->db->where('display',1);
		$qry=$this->db->get('event_post');
		return $qry->num_rows();
	}

}

/* End of file event_post.php */
/* Location: ./application/models/event_post.php */