<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meta_tag_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='meta_tags';
	}

	/**
	 * get meta tags
	 * 
	 * @return object|bool
	 */
	static function get_meta()
	{
		$sql="select * from meta_tags where id=1 limit 1";

		$ci =& get_instance();
		$ci->db->cache_on();
		$qry=$ci->db->query($sql);
		$ci->db->cache_off();
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}

		return false;
	}
}

/* End of file meta_tag_model.php */
/* Location: ./application/models/meta_tag_model.php */