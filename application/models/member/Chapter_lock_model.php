<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chapter_lock_model extends CI_Model {

	/**
	 * check if chapter is locked or not
	 * @param  $chapter_id int  
	 * @param  $locked_chapters array
	 * @return boolean            
	 */
	function is_locked($chapter_id,$locked_chapters=[])
	{
		if(in_array($chapter_id,$locked_chapters))
		{
			return true;
		}
		return false;
	}


	/**
	 * lock chapter
	 * @param  int $chapter_id
	 * @param  bool $is_lock   
	 * @return void            
	 */
	function do_lock($chapter_id)
	{
		if($this->chapter_exist($chapter_id))
		{
			$this->db->where('chapter_id',$chapter_id);
			$this->db->delete('chapter_lock_mapping');
		}
		else
		{
			$qry=$this->db->insert('chapter_lock_mapping',['chapter_id'=>$chapter_id]);
		}
	}

	/**
	 * check chapter already exists or not
	 * @param  int $chapter_id 
	 * @return bool             
	 */
	private function chapter_exist($chapter_id)
	{
		$this->db->where('chapter_id',$chapter_id);
		$qry=$this->db->get('chapter_lock_mapping');
		if($qry->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	function get_chapters($where='')
	{
		$this->db->cache_off();
		$sql="SELECT r.*,c FROM ref_text r 
		LEFT JOIN chapter_lock_mapping clm 
		ON  r.`id`=clm.chapter_id {$where}";
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


	/**
	 * Get Locked Chapter Ids
	 * @return Array
	 */
	function get_locked_chapters()
	{
		$this->db->cache_off();
		$qry=$this->db->get('chapter_lock_mapping');
		if($qry->num_rows()>0)
		{
			$chapters=[];
			foreach ($qry->result() as $row) {
				array_push($chapters,$row->chapter_id);
			}
			return $chapters;
		}
		return [];
	}

}

/* End of file chapter_lock_model.php */
/* Location: ./application/models/member/chapter_lock_model.php */