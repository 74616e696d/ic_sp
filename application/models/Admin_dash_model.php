<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_dash_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function total_user()
	{
		$this->db->select('id');
		$qry=$this->db->get('users');
		return $qry->num_rows();
	}

	function get_todays_user()
	{
		$this->db->where("DATE_FORMAT(creation_date,'%Y-%m-%d')",date('Y-m-d'));
		$this->db->select('id');
		$qry=$this->db->get('users');
		return $qry->num_rows();
	}

	function get_months_user()
	{
		$this->db->where("DATE_FORMAT(creation_date,'%Y-%m')",date('Y-m'));
		$this->db->select('id');
		$qry=$this->db->get('users');
		return $qry->num_rows();
	}

}

/* End of file admin_dash_model.php */
/* Location: ./application/models/admin_dash_model.php */