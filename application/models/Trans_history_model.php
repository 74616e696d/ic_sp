<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trans_history_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='trans_history';
	}	

}

/* End of file trans_history_model.php */
/* Location: ./application/models/trans_history_model.php */