<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Roadmap for model test for upcoming exams(bcs,bank etc.)
 */
class Roadmap_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='roadmap';
	}


	/**
	 * get roadmap data by term
	 * @param  string $term
	 * @return object|bool     
	 */
	function get_roadmap($term='')
	{
		$sql="select * from roadmap $term";
		$qry=$this->db->query($sql);

		if($qry->num_rows()>0)
		{
			return $qry->result();
		}

		return false;
	}

	/**
	 * count roadmaps by term
	 * @param  string $term
	 * @return integer     
	 */
	function count_all($term='')
	{
		$sql="select id from roadmap $term";
		$qry=$this->db->query($sql);
		return $qry->num_rows();
	}

	/**
	 * get todays roadmap by date and category
	 *
	 * @param  integer $category
	 * 
	 * @return object|boolean
	 */
	function todays_roadmap($category)
	{
		$now=date('Y-m-d');
		$sql="select * from roadmap where category={$category} and DATE(exam_date)='{$now}'";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		return false;
	}
	/**
	 * get all roadmap items by category
	 * 
	 * @param  integer $category
	 * 
	 * @return object|boolean          
	 */
	function get_all($category)
	{
		$now=date('Y-m-d H:i:s');
		$sql="select * from roadmap where display=1 and category={$category}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	/**
	 * get roadmap schedule by category
	 * 
	 * @param  integer  $category
	 * @param  integer $limit   
	 * 
	 * @return object|boolean           
	 */
	function get_shcedule($category,$limit=5)
	{
		$now=date('Y-m-d H:i:s');
		$sql="select * from roadmap where display=1 and category={$category} limit {$limit}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	/**
	 * get exam name by id
	 * 
	 * @param  integer $id
	 * 
	 * @return string    
	 */
	static function get_text($id)
	{
		$ci =& get_instance();
		$sql="select exam_name from roadmap where id={$id}";
		$qry=$ci->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->row()->exam_name;
		}
		return '';
	}

	/**
	 * get top scorer details attending roadmaped exams
	 * 
	 * @param  integer  $test_id
	 * @param  date  $dt     
	 * @param  integer $limit  
	 * 
	 * @return object|boolean         
	 */
	function get_top_scorer($test_id,$dt,$limit=5)
	{
		$sql="select distinct email,max(total_correct) as points from 
(select distinct u.email, mqs.id,mqs.test_id,mqs.time_taken,mqs.total_correct,mqs.total_wrong, u.user_name,udtls.full_name,udtls.photo from model_quiz_summery mqs join users u on mqs.user_id=u.id join user_details udtls on udtls.user_id=u.id where test_id={$test_id} and DATE(quiz_date)='{$dt}' order by total_correct desc ) as tbl 
group by email order by points desc ";
		// $sql="select distinct u.email, mqs.id,mqs.test_id,mqs.time_taken,mqs.total_correct,mqs.total_wrong, ";
		// $sql.="u.user_name,udtls.full_name,udtls.photo from model_quiz_summery mqs ";
		// $sql.="join users u on mqs.user_id=u.id ";
		// $sql.="join user_details udtls on udtls.user_id=u.id ";
		// $sql.="where test_id={$test_id} and ";
		// $sql.="DATE(quiz_date)='{$dt}' ";
		// $sql.="order by total_correct desc limit {$limit}";

		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

}

/* End of file roadmap_model.php */
/* Location: ./application/models/roadmap_model.php */