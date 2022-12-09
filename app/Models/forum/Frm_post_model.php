<?php 
namespace App\Models\forum;
use CodeIgniter\Model;

class Frm_post_model extends Model {

	function __construct()
	{
		parent::__construct();
		$this->table='frm_post';
	}

	/**
	 * get all forum post with pagination
	 * @param  int $start
	 * @param  int $limit
	 * @param  string $term
	 * @return object/bool
	 */
	function get_forum_posts($start=0,$limit=10,$term='')
	{
		$sql="select *from frm_post $term order by id desc limit $start,$limit";
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
	function top_post($limit=12)
	{
		return $this->db->table('frm_post')->where('display',1)
		->limit($limit)
		->orderBy('id','desc')
		->get()->getResultArray();
		/*if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}*/
	}

	function categorised_post()
	{
		$this->db->where('frm_post.display',1);
		$this->db->group_by('frm_post.sub_category');
		$this->db->select(array('count(frm_post.id) as total_post','frm_post.sub_category','ref_text.name'));
		$this->db->from('frm_post');
		$this->db->join('ref_text','ref_text.id=frm_post.sub_category');
		$this->db->order_by('ref_text.serial','ASC');
		$qry=$this->db->get();
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function get_recent_post($limit=5)
	{
		$this->db->where('display',1);
		$this->db->order_by('id','DESC');
		$this->db->limit($limit);
		$qry=$this->db->get('frm_post');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function all_posts()
	{
		$this->db->order_by('id','DESC');
		$qry=$this->db->get('frm_post');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function get_posts($start=0,$limit=5,$term='')
	{
		$sql="select *from frm_post {$term} order by id desc limit $start,$limit";
		$this->db->cache_off();
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

	function get_user_posts()
	{
		$this->db->where('sub_category',5000);
		$qry=$this->db->get('frm_post');
		return $qry->num_rows();
	}

	/**
	 * get next and previous forum post
	 * @param  int $id
	 * @return object/bool   
	 */
	function get_next_prev_post($id)
	{
		$sql="SELECT id FROM frm_post WHERE id IN ((SELECT MIN(id) FROM frm_post WHERE id > {$id}),(SELECT MAX(id) FROM frm_post WHERE id < {$id}))";
		$qry=$this->db->query($sql);
		$prev_id=0;
		$next_id=0;
		if($qry->num_rows()>0)
		{
			if($qry->num_rows()==1)
			{
				if($qry->row()->id<$id)
				{
					$prev_id=$qry->row()->id;
				}
				else
				{
					$next_id=$qry->row()->id;
				}
			}
			else
			{
				$row=$qry->result_array();
				$prev_id=$row[0]['id'];
				$next_id=$row[1]['id'];
			}
		}
		return ['prev_id'=>$prev_id,'next_id'=>$next_id];
	}

	/**
	 * search forum post by term
	 * 
	 * @param  string $term 
	 * 
	 * @return object|boolean       
	 */
	function search_posts($term='')
	{
		$sql="select * from frm_post {$term}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}

		return false;
	}

	/**
	 * count searched post by term
	 * 
	 * @param  string $term
	 * 
	 * @return integer      
	 */
	function count_posts($term='')
	{
		$sql="select id from frm_post {$term}";
		$qry=$this->db->query($sql);
		return $qry->num_rows();
	}

}

/* End of file frm_post_model.php */
/* Location: ./application/models/forum/frm_post_model.php */