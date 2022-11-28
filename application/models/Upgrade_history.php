<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upgrade_history extends MY_Model {

	function __construct()
	{
		parent::__construct();

		$this->table='upgrade_history';
	}

	/**
	 * get the number of upgrade by today
	 * @return integer
	 */
	function get_payment_stats($term='')
	{
		$sql="select uh.*,m.name,u.id as uid,u.user_name,u.email from upgrade_history uh join membership m on uh.member_type=m.id join users u on u.id=uh.user_id {$term}";


		$qry=$this->db->query($sql);

		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	function get_user_phone($user_id)
	{
		$sql="select phone from user_details where user_id={$user_id}";
		$qry=$this->db->query($sql);

		if($qry->num_rows()>0)
		{
			return $qry->row()->phone;
		}

		return '';
	}

	/**
	 * get the number of upgrade by today
	 * @return integer
	 */
	function get_payment_summery($term='')
	{
		$sql="select sum(amount) as total from upgrade_history uh join membership m on uh.member_type=m.id join users u on u.id=uh.user_id {$term}";


		$qry=$this->db->query($sql);

		if($qry->num_rows()>0)
		{
			return $qry->row()->total;
		}
		return false;
	}

	/**
	 * get the number of upgrade by today
	 * @return integer
	 */
	function get_payment_stats_arr($term='')
	{
		$sql="select uh.*,m.name from upgrade_history uh join membership m on uh.member_type=m.id {$term}";

		$qry=$this->db->query($sql);

		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		}
		return false;
	}

	function get_count($term='')
	{
		$sql="select uh.id from upgrade_history uh join membership m on uh.member_type=m.id {$term}";
		$qry=$this->db->query($sql);

		return $qry->num_rows();
	}

	/**
	 * sum total amount in an object
	 * @param  Object $data
	 * @return integer      
	 */
	static function get_total_amount($data)
	{
		$total=0;
		if(data)
		{
			foreach($data as $row)
			{
				$amount=$row->amount!=NULL?0:$row->amount;
				$total=$amount+$total;
			}
		}

		return $total;
	}


}

/* End of file upgrade_history.php */
/* Location: ./application/models/upgrade_history.php */