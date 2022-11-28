<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funny_facts_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='funny_facts';
	}

}

/* End of file funny_facts_model.php */
/* Location: ./application/models/funny_facts_model.php */