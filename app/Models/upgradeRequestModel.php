<?php 

namespace App\Models;
use CodeIgniter\Model;

class upgradeRequestModel extends Model {

    protected $allowedFields = ['user_id', 'mem_type', 'status', 'req_date', 'approval_date'];
	function __construct()
	{
		parent::__construct();
                $this->table='upgrade_request';
                $this->database = \Config\Database::connect();
                
                
	}	
}