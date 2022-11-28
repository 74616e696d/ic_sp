<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referral_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='referer_info';
	}
	

}

/* End of file referral_model.php */
/* Location: ./application/models/referral_model.php */