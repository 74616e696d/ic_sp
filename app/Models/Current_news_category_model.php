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
		$ci =& get_instance();
		$ci->db->where('id',$id);
		$qry=$ci->db->get('current_news_category');
		if($qry->num_rows()>0)
		{
			return $qry->row()->name;
		}
		else
		{
			return '';
		}
	}

	function get_category($terms='')
	{
		$sql="select * from current_news_category $terms";
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