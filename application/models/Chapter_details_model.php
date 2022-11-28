<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chapter_details_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function insert($data)
	{
		$this->db->insert('ref_details',$data);
		return ;
	}

	function  get_details_by_ref($ref_id)
	{
		$this->db->where('ref_id',$ref_id);
		$query=$this->db->get('ref_details');
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}

	

	function update($ref_id,$data)
	{
		$this->db->where('ref_id',$ref_id);
		$this->db->update('ref_details',$data);
	}

	function chapter_link($data)
	{
		$this->db->insert('chapter_settings',$data);
		return ;
	}

	function check_link($chap1,$chap2)
	{
		if($chap1 != $chap2){
			$this->db->where('chapter1',$chap1);
			$this->db->where('chapter2',$chap2);
			$check1 = $this->db->get('chapter_settings')->num_rows();

			$this->db->where('chapter1',$chap2);
			$this->db->where('chapter2',$chap1);
			$check2 = $this->db->get('chapter_settings')->num_rows();

			if($check1 > 0 || $check2 > 0){
				return 1;
			}else{
				return 0;
			}
		}else{
			return 1;
		}
	}

	function get_linked_chapter($chap)
	{
		$result = array();
		$this->db->where('chapter1',$chap);
		$check1 = $this->db->get('chapter_settings')->result_array();
		if(count($check1) > 0){
			foreach ($check1 as $value) {
				if(!in_array($value['chapter2'],$result)){
					array_push($result,$value['chapter2']);
				}
			}
		}

		
		$this->db->where('chapter2',$chap);
		$check2 = $this->db->get('chapter_settings')->result_array();
		if(count($check2) > 0){
			foreach ($check2 as $value) {
				if(!in_array($value['chapter1'],$result)){
					array_push($result,$value['chapter1']);
				}
			}
		}

		return array_unique($result);
	}

	function get_category($id){
		$subject = $this->get_subject($id);
		$category = $this->db->get_where('ref_text', array('id'=>$subject->parent_id))->row();
		return $category;
	}

	function get_subject($id){
		$chapter_group = $this->get_chapter_group($id);
		$subject = $this->db->get_where('ref_text', array('id'=>$chapter_group->parent_id))->row();
		return $subject;
	}

	function get_chapter_group($id){
		$chapter = $this->get_chapter($id);
		$chapter_group = $this->db->get_where('ref_text', array('id'=>$chapter->parent_id))->row();
		return $chapter_group;
	}

	function get_chapter($id){
		$chapter = $this->db->get_where('ref_text', array('id'=>$id))->row();
		return $chapter;
	}

}

/* End of file chapter_details_model.php */
/* Location: ./application/models/chapter_details_model.php */