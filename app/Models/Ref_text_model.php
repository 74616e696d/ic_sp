<?php 
namespace App\Models;
use CodeIgniter\Model;
    
/**
 * Author : Shamim
 * Description : small Description
 */
class Ref_text_model extends Model {

    function __construct()
    {
        parent::__construct();
        $this->table='ref_text';
        $this->database = \Config\Database::connect();
    }
	
	//functions for reference group
	function insert_ref_group($data)
	{
		$this->db->cache_delete_all();
		$this->db->insert('ref_group',$data);
		return;
	}
	function get_ref_group()
	{
		$sql='select *from ref_group';
		$this->db->cache_on();
		$q=$this->db->query($sql);
		if($q->num_rows()>0)
		{
			$result=$q->result();
			return $result;
		}else
		{
			return false;
		}
	}
	
	function search_ref_text($term,$order_by_field=[])
	{
		if(count($order_by_field)>0)
		{
			$order_by_field_str=implode(',',$order_by_field);
			$sql="select *from ref_text {$term} order by FIELD({$order_by_field_str})";
		}
		else
		{
			$sql="select *from ref_text {$term} order by serial";
		}
		
		//$this->db->cache_on();
		return $this->db->query($sql)->getResultObject();
		/*if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}*/
	}

	function total_prev_exams()
	{
		$sql="SELECT *FROM ref_text WHERE group_id=5 AND  parent_id IN(7,318,642,680,713)";
		//$this->db->cache_on();
		$query = $this->db->query($sql);
                return $query->getFieldCount();
	//	return $qry->num_rows();
	}

	function get_ref_group_by_id($id)
	{
		$sql='select *from ref_group where id='.$id;
		$this->db->cache_on();
		$q=$this->db->query($sql);
		if($q->num_rows()>0)
		{
			$result=$q->first_row();
			return $result;
		}else
		{
			return false;
		}
	}
	function update_ref_group($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('ref_group',$data);
	}
	//end functions for reference group
	
	//functions for reference text
	function insert_ref_text($data)
	{
		$this->db->cache_delete_all();
		$this->db->trans_start();
		$this->db->insert('ref_text',$data);	
		$insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
	} 
	function get_total($term)
	{
		$sql='select *from ref_text '.$term.' order by serial';
		$this->db->cache_on();
		$q=$this->db->query($sql);
		if($q->num_rows()>0)
		{
			return $q->num_rows();
		}else
		{
			return false;
		}
	}
	function get_ref_text($start=0,$limit=10,$key='')
	{
		$sql='select *from ref_text '.$key.' limit '.$start.','.$limit;
		$this->db->cache_on();
		$q=$this->db->query($sql);
		if($q->num_rows()>0)
		{
			$result=$q->result();
			return $result;
		}else
		{
			return false;
		}
	}

	function search_total($key)
	{
		$sql="select rtxt.id,rg.name as group_name,ptxt.name as parent_text from ref_text rtxt inner join ref_group rg on rtxt.group_id=rg.id";
		$sql.=" left join ref_text ptxt on rtxt.parent_id=ptxt.id {$key}";
		$this->db->cache_on();
		$q=$this->db->query($sql);
		if($q->num_rows()>0)
		{
			return $q->num_rows();
		}else
		{
			return 0;
		}
	}
	function all_ref_text($start=0,$limit=10,$key='')
	{
		$sql="select rtxt.*,rg.name as group_name,ptxt.name as parent_text from ref_text rtxt inner join ref_group rg on rtxt.group_id=rg.id";
		$sql.=" left join ref_text ptxt on rtxt.parent_id=ptxt.id";
		$sql.=" {$key} limit {$start},{$limit}";
		$this->db->cache_on();
		$q=$this->db->query($sql);
		if($q->num_rows()>0)
		{
			$result=$q->result();
			return $result;
		}else
		{
			return false;
		}
	}

	public function get_text($id)
	{
		//$ci =& get_instance();
		//$ci->db->cache_on();
		return $this->db->table('ref_text')->where('id',$id)->select('name')->get()->getRow()->name;
		/*$ci->db->cache_off();
		if($query->num_rows()>0){
			$result=$query->row()->name;
			return $result;
		}
		else
		{
			return '';
		}*/
	}


	function ref_text_group_in($cats=[])
	{
		$cats_str=implode(',',$cats);
		$sql="select *from ref_text where id in ({$cats_str}) order by FIELD($cats_str)";
		return $this->db->query($sql)->getResultObject();
		/*if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}*/

	}

	public static function get_group_text($id)
	{
		$ci =& get_instance();
		$ci->db->cache_on();
		$ci->db->where('id',$id);
		$ci->db->select('name');
		$query=$ci->db->get('ref_group');
		if($query->num_rows()>0){
			$result=$query->row()->name;
			return $result;
		}
		else
		{
			return false;
		}
	}

	function add_to_exam($data)
	{
		$this->db->insert('exam',$data);
	}

	function get_ref_text_by_id($id)
	{
		$sql='select *from ref_text where id='.$id.' order by serial';
		$this->db->cache_on();
		$q=$this->db->query($sql);
		if($q->num_rows()>0)
		{
			$result=$q->row();
			return $result;
		}else
		{
			return false;
		}
	}

	function get_exam_wise_subject($eid)
	{
		//$this->database->table('users')->cache_on();
		return $this->database->table('ref_text')->where('parent_id',$eid)
		->where('group_id',3)
		->orderBy('serial')
		->get()->getResult();
		/*if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}*/
	}

	function get_ref_text_by_group($group)
	{
		$sql='select *from ref_text where group_id='.$group.' order by serial';
		//$this->db->cache_on();
		return $this->db->query($sql)->getResultObject();
		/*if($q->num_rows()>0)
		{
			$result=$q->result();
			return $result;
		}else
		{
			return false;
		}*/
	}

	function get_subject_of_exam_cat($pid)
	{
		$sql="select *from ref_text where group_id=3 and parent_id={$pid} order by serial";
		//$sql='select *from ref_text where parent_id='.$pid.' order by serial';
		//$this->db->cache_on();
		return $this->db->query($sql)->getResultObject();
		/*if($q->num_rows()>0)
		{
			$result=$q->result();
			return $result;
		}
		else
		{
			return false;
		}*/
	}


	static function total_subj_chapter($sbj)
	{
		$ci =& get_instance();
		$ci->db->cache_on();
		$ci->db->where('parent_id',$sbj);
		$ci->db->order_by('serial','asc');
		$qry=$ci->db->get('ref_text');
		$i=0;
		if($qry->num_rows()>0)
		{
			$items=$qry->result();
			if($items)
			{
				foreach ($items as $item) 
				{
					$ci->db->where('parent_id',$item->id);
					$qry1=$ci->db->get('ref_text');
					$i=$i+$qry1->num_rows();	
				}
			}
		}
		return $i;
	}

	static function get_subjects_chapter($subj)
	{
		$ci =& get_instance();
		$ci->db->cache_on();
		$ci->db->where('parent_id',$subj);
		$ci->db->order_by('serial','asc');
		$qry=$ci->db->get('ref_text');
		$data=array();
		if($qry->num_rows()>0)
		{
			$items=$qry->result();
			if($items)
			{
				foreach ($items as $item) 
				{
					$ci->db->where('parent_id',$item->id);
					$qry1=$ci->db->get('ref_text');
					if($qry1->num_rows()>0)
					{
						$result1=$qry1->result();
						foreach ($result1 as $r) {
							array_push($data,$r->id);
						}
					}	
				}
			}
			return $data;
		}
		else
		{
			return false;
		}
	}
	

	function get_chapter_by_subject($subj)
	{
		$this->db->cache_on();
		$this->db->where('parent_id',$subj);
		$this->db->order_by('serial','asc');
		$qry=$this->db->get('ref_text');
		$data=array();
		if($qry->num_rows()>0)
		{
			$items=$qry->result();
			if($items)
			{
				foreach ($items as $item) 
				{
					$this->db->where('parent_id',$item->id);
					$qry1=$this->db->get('ref_text');
					if($qry1->num_rows()>0)
					{
						$result1=$qry1->result();
						foreach ($result1 as $r) {
							array_push($data,$r);
						}
					}	
				}
			}
			return $data;
		}
		else
		{
			return false;
		}
	}
	function get_ref_text_by_parent($pid)
	{
		$sql='select *from ref_text where parent_id='.$pid.' order by serial';
		$this->db->cache_on();
		$q=$this->db->query($sql);
		if($q->num_rows()>0)
		{
			$result=$q->result();
			return $result;
		}
		else
		{
			return false;
		}
	}

	function get_ref_text_by_parent_group($pid,$group)
	{
		$sql='select *from ref_text where group_id='.$group.' and parent_id='.$pid.' order by serial';
		$this->db->cache_on();
		$q=$this->db->query($sql);
		if($q->num_rows()>0)
		{
			$result=$q->result();
			return $result;
		}
		else
		{
			return false;
		}
	}
	
	function update_ref_text($id,$data)
	{
		$this->db->cache_delete_all();
		$this->db->where('id',$id);
		$this->db->update('ref_text',$data);
	}
	function delete_ref_text($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('ref_text');
	}
	//end functions for reference text
    
   
    
}