<?php
namespace App\Models;
use CodeIgniter\Model;

class Events_model extends Model {

	public function __construct()
	{
		parent::__construct();
		$this->table="upcoming_events";
	}


	function get_published_event($limit=50)
	{
		//$this->db->cache_off();
		$sql="SELECT *FROM upcoming_events WHERE DATE_FORMAT(NOW(),'%Y-%m-%d %H')<DATE_FORMAT(event_time,'%Y-%m-%d %H') AND display=1 order by id desc limit {$limit}";
		return $this->db->query($sql)->getResultObject();
		/*if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else{
			return false;
		}*/
	}

	function get_ongoing_event()
	{
		//$this->db->cache_off();
		$sql="SELECT *FROM upcoming_events WHERE (DATE_FORMAT(NOW(),'%Y-%m-%d %H')>=DATE_FORMAT(event_time,'%Y-%m-%d %H')) AND (DATE_FORMAT(NOW(),'%Y-%m-%d %H')<=DATE_FORMAT(expitre_time,'%Y-%m-%d %H'))  AND display=1 order by id desc";
		return $this->db->query($sql)->getResultArray();
		/*if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else{
			return false;
		}*/
	}

	function get_todays_event()
	{
		$this->db->cache_off();
		$sql="SELECT *FROM upcoming_events WHERE (DATE_FORMAT(NOW(),'%Y-%m-%d')=DATE_FORMAT(event_time,'%Y-%m-%d'))  AND display=1 order by id desc";
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

/* End of file events_model.php */
/* Location: ./application/models/events_model.php */