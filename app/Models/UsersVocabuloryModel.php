<?php 
namespace App\Models;
use CodeIgniter\Model;

class UsersVocabuloryModel extends Model {

    protected $allowedFields = ['user_id', 'vocabulary_id', 'display_date'];
	function __construct()
	{
		parent::__construct();
		$this->table='users_vocabulary';
	}
}