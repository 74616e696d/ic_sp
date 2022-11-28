<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Days_vocabulary_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='days_vocabulary';
	}

	function get_todays_word($user_id)
	{
		$today=date('Y-m-d');
		$this->db->cache_off();
		$sql="select v.* from users_vocabulary uv join vocabulary v on uv.vocabulary_id=v.id  where DATE_FORMAT(uv.display_date,'%Y-%m-%d')='{$today}' and uv.user_id={$user_id}";
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

	function add($data)
	{
		$this->db->insert('users_vocabulary',$data);
		return $this->db->insert_id();
	}

	function clean_data($user_id)
	{
		$today=date('Y-m-d');
		$this->db->where('user_id',$user_id);
		$this->db->delete('users_vocabulary');
	}

	function check_date($user_id)
	{
		$today=date('Y-m-d');
		$sql="select * from users_vocabulary where DATE_FORMAT(display_date,'%Y-%m-%d')='{$today}' and user_id={$user_id} limit 1";
		$qry=$this->db->query($sql);
		return $qry->num_rows()>0?true:false;
	}

	function user_max($user_id)
	{	
		$sql="select max(vocabulary_id)  as vocabulary_id from users_vocabulary where user_id={$user_id}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->row()->vocabulary_id;
		}
		else
		{
			return 0;
		}
	}

}

/* End of file days_vocabulary_model.php */
/* Location: ./application/models/days_vocabulary_model.php */