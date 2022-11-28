<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chapter_media_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function add($data)
	{
		$this->db->insert('chapter_media',$data);
		return;
	}
	function find($id)
	{
		$this->db->where('id',$id);
		$qry=$this->db->get('chapter_media');
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}

	function all()
	{
		$qry=$this->db->get('chapter_media');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}	

	function get_by_role($chapter_id,$role)
	{
		if(!in_array($role, array('101','102')))
		{
			if($role==4)
			{
				$this->db->where_in('role',array('101','102',$role,'3','2'));
			}
			else if($role==3)
			{
				$this->db->where_in('role',array('101','102',$role,'2'));
			}
			else
			{
				$this->db->where_in('role',array('101','102',$role));
			}
			
		}
		$this->db->where('chapter_id',$chapter_id);
		$qry=$this->db->get('chapter_media');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function update($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('chapter_media',$data);
	}

	function destroy($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('chapter_media');
	}
}

/* End of file chapter_media_model.php */
/* Location: ./application/models/chapter_media_model.php */