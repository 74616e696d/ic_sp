<?php
namespace App\Models\member;
use CodeIgniter\Model;

class User_choice_model extends Model {
	function __construct()
	{
		parent::__construct();
		$this->table='users_choice';
	}

	function get_todays_choice($uid)
	{	
		$date=date('Y-m-d');
		$sql="select *from users_choice where user_id={$uid} and DATE_FORMAT(read_date,'%Y-%m-%d')>='{$date}'";
		return $this->db->query($sql)->getResultObject();
		/*if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}*/
	}

	/**
	 * get user specific plan list
	 * @param  int $uid
	 * @return object    
	 */
	function get_my_plans($uid)
	{
		$sql="select users_choice.*,ref_text.name from users_choice join ref_text on users_choice.chapter_id=ref_text.id where user_id={$uid} order by read_date desc";
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

/* End of file user_choice_model.php */
/* Location: ./application/models/member/user_choice_model.php */