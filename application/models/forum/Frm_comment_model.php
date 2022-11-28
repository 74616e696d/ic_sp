<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frm_comment_model extends MY_Model {

	function __construct()
	{
		parent::__construct();

		$this->table='frm_comment';
	}


	function total_post_comment($post_id)
	{
		$this->db->where('post_id',$post_id);
		$this->db->where('display',1);
		$qry=$this->db->get('frm_comment');
		return $qry->num_rows();
	}

	static function post_comment_count($post_id)
	{
		$ci =& get_instance();
		$ci->db->where('post_id',$post_id);
		$ci->db->where('display',1);
		$qry=$ci->db->get('frm_comment');
		return $qry->num_rows();
	}

	function post_comment($post_id)
	{
		$this->db->where('post_id',$post_id);
		$this->db->where('display',1);
		$this->db->order_by('id','DESC');
		$qry=$this->db->get('frm_comment');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	/**
	 * get post comment for admin panel
	 * @return object/bool
	 */
	function get_post_comment($start=0,$limit=10,$term='')
	{
		$sql="select cmnt.*,pst.id as forum_post_id,pst.title from frm_comment cmnt ";
		$sql.="join frm_post pst on cmnt.post_id=pst.id {$term} order by cmnt.id desc limit {$start},{$limit}";
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

/* End of file frm_comment_model.php */
/* Location: ./application/models/forum/frm_comment_model.php */