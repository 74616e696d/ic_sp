<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploaded_cv_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='uploaded_cv';
	}

	/**
	 * check if a user already uploaded his/her cv
	 * 
	 * @param  int $userid
	 * @return boolean       
	 */
	function already_uploaded($userid)
	{
		$this->db->where('user_id',$userid);
		$qry=$this->db->get('uploaded_cv');
		if($qry->num_rows()>0)
		{
			return true;
		}
		return false;
	}

	function all_cv()
	{
		$sql="select uc.*,u.email from uploaded_cv uc inner join users u on uc.user_id=u.id";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

}

/* End of file uploaded_cv_model.php */
/* Location: ./application/models/member/uploaded_cv_model.php */