<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fix_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='question_bank';
	}


	function fix_user()
	{
		$this->db->update('users',['is_locked'=>0]);
	}

}

/* End of file fix_model.php */
/* Location: ./application/models/fix_model.php */