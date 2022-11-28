<?php 
namespace App\Models;
use CodeIgniter\Model;

use App\Models\UsersVocabuloryModel;

class Days_vocabulary_model extends Model {

    protected $allowedFields = ['user_id', 'vocabulary_id', 'display_date'];
	function __construct()
	{
		parent::__construct();
		$this->table='days_vocabulary';
                
                $this->UsersVocabuloryModel = new UsersVocabuloryModel();
	}

	function get_todays_word($user_id)
	{
		$today=date('Y-m-d');
		//$this->db->cache_off();
		$sql="select v.* from users_vocabulary uv join vocabulary v on uv.vocabulary_id=v.id  where DATE_FORMAT(uv.display_date,'%Y-%m-%d')='{$today}' and uv.user_id={$user_id}";
		return $this->db->query($sql)->getResultArray();
	/*	if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}*/
	}

	function add($data)
	{
		 $this->UsersVocabuloryModel->insert($data);
                return $this->db->insertID();
		//return $this->db->insert_id();
	}

	function clean_data($user_id)
	{
		$today=date('Y-m-d');
		$this->db->table('users_vocabulary')->where('user_id',$user_id)->delete();
	}

	function check_date($user_id)
	{
		$today=date('Y-m-d');
		$sql="select * from users_vocabulary where DATE_FORMAT(display_date,'%Y-%m-%d')='{$today}' and user_id={$user_id} limit 1";
		 return $this->db->query($sql)->getNumRows();
                /*if($qry > 0)
                {
                    return true;
                }
		return $qry->num_rows()>0?true:false; */
	}

	function user_max($user_id)
	{	
		$sql="select max(vocabulary_id)  as vocabulary_id from users_vocabulary where user_id={$user_id}";
		return $this->db->query($sql)->getRow()->vocabulary_id;
		/*if($qry->num_rows()>0)
		{
			return $qry->row()->vocabulary_id;
		}
		else
		{
			return 0;
		}*/
	}

}

/* End of file days_vocabulary_model.php */
/* Location: ./application/models/days_vocabulary_model.php */