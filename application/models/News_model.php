<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use Carbon\Carbon;
class News_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='news';
	}

	function job_list($term)
	{
		$sql="select *from news {$term}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else{
			
		}
	}

	function published_news()
	{
		$this->db->where('is_published','1');
		$this->db->where('DATE(publish_date)','DATE(NOW())');
		$this->db->or_where('DATE(publish_date) <','DATE(NOW())');
		$this->db->order_by('id','DESC');
		$qry=$this->db->get($this->table);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function latest_news($limit)
	{
		$this->db->where('is_published','1');
		$this->db->where('DATE(publish_date)','DATE(NOW())');
		$this->db->or_where('DATE(publish_date) <','DATE(NOW())');
		$this->db->order_by('id','desc');
		$this->db->limit($limit);
		$qry=$this->db->get($this->table);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function deadline_news($limit)
	{
		$this->db->where('is_published','1');
		$tommorrow = new DateTime('tomorrow');
		$tommorrow= $tommorrow->format('Y-m-d H:i:s');
		$this->db->where('DATE(deadline)',$tommorrow);
		// $this->db->or_where('DATE(publish_date) <','DATE(NOW())');
		$this->db->order_by('id','desc');
		$this->db->limit($limit);
		$qry=$this->db->get($this->table);
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

/* End of file news_model.php */
/* Location: ./application/models/news_model.php */