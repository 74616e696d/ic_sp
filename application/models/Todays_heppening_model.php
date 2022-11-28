<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todays_heppening_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='what_happened_today';
	}

	function get_on_this_day()
	{
		$this->db->where('display',1);
		$this->db->where("DATE_FORMAT(happening_date,'%m-%d')",date('m-d'));
		$qry=$this->db->get('what_happened_today');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function get_happenings($term='')
	{
		$sql="select * from what_happened_today {$term}";

		$qry=$this->db->query($sql);

		if($qry->num_rows()>0)
		{
			return $qry->result();
		}

		return false;
	}

}

/* End of file todays_heppening_model.php */
/* Location: ./application/models/todays_heppening_model.php */