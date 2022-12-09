<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='company_info';
	}


	/**
	 * login as company
	 * @param  string $email   
	 * @param  string $password
	 * @return boolean          
	 */
	public function check($email,$password)
	{
		$attr = array(
			'email' =>$email,
			'password' =>md5($password),
			'active'=>1
			);

		$qry = $this->db->get_where('company_info',$attr);

		if($qry->num_rows()>0)
		{
			$data=$qry->row();
			$attr = array(
				'company_id' => $data->id,
				'company_name' => $data->company_name,
				'company_email' => $data->email,
				'company_logo'=>$data->logo
			);
			$this->session->set_userdata($attr);
			return true;
		}
		return false;
	}

	static function get_company_info($id)
	{
		$ci =& get_instance();
		$sql="select * from company_info where id={$id}";
		$qry=$ci->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		return false;
	}


	function get_info($term='')
	{
		$sql="select *from company_info {$term}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}


function get_company()
	{
		$sql="select *from company_info ORDER BY company_name ASC";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	function count_all($term='')
	{
		$sql="select id from company_info {$term}";
		$qry=$this->db->query($sql);
		return $qry->num_rows();
	}

}

/* End of file company_model.php */
/* Location: ./application/models/company_model.php */