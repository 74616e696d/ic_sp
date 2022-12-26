<?php

namespace App\Models;

use CodeIgniter\Model;
use Illuminate\Support\Str;

class Current_news_category_model extends Model {

	function __construct()
	{
		parent::__construct();
		$this->table='current_news_category';
	}

	/**
	 * get category text by id
	 * @param  int $id
	 * @return string
	 */
	static function get_text($id)
	{
		$db = \Config\Database::connect();
		//$ci =& get_instance();
		$builder = $db->table('current_news_category');
		$builder->where('id',$id);
		$qry=$builder->get();
		if($qry->getNumRows()>0)
		{
			return $qry->getRow()->name;
		}
		else
		{
			return '';
		}
	}

	function get_category($terms='')
	{
		$sql="select *from current_news_category $terms";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

}

/* End of file current_news_category_model.php */
/* Location: ./application/models/current_news_category_model.php */