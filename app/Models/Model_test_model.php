<?php 
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');
namespace App\Models;
use CodeIgniter\Model;

class Model_test_model extends Model {

	function __construct()
	{
		parent::__construct();
		$this->table='model_test';
	}


	static function get_text($id)
	{
		$ci =& get_instance();
		$ci->db->where('id',$id);
		$qry=$ci->db->get('model_test');
		if($qry->num_rows()>0)
		{
			return $qry->row()->name;
		}
		else
		{
			return '';
		}
	}

	function get_test_ques($test_id)
	{
		$this->db->where('test_id',$test_id);
		$this->db->select(array('mq.id as mqid,mq.test_id','qb.id','qb.question','qb.options'));
		$this->db->from('model_test_question mq');
		$this->db->join('question_bank qb','mq.qid=qb.id');
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

	function get_model_test($limit=0)
	{
		if($limit!=0)
		{
			$this->db->limit($limit);
		}

		$this->db->order_by('id','DESC');
		$qry=$this->db->get('model_test');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}
	function get_live_model_test()
	{

		$this->db->where('display',1)->where('type',55)->order_by('id','DESC')->limit(10);
		$qry=$this->db->get('model_test');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}

	}

	function get_live_model_test_dash()
	{

		return $this->db->table('model_test')->where('type',55)->where('display',1)->orderBy('id','DESC')->limit(2)->get()->getResultObject();
		/*if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}*/

	}





	function model_test($limit=0)
	{
		$sql="select *from model_test where marks_carry*total_ques=200 and display=1 order by id DESC";
		if($limit!=0)
		{
			// $this->db->limit($limit);
			$sql="select *from model_test where marks_carry*total_ques=200 and display=1 order by id DESC limit {$limit}";
		}

		// $this->db->where("marks_carry*total_ques",200);
		// $this->db->where('display','1');
		// $this->db->order_by('id','DESC');
		// $qry=$this->db->get('model_test');
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

	function model_test_bank($limit=0)
	{
		//$sql="select *from model_test where id not in(select test_id from roadmap) and display=1 order by id DESC limit {$limit}";
		$sql="select *from model_test where display=1 AND type=1 AND is_featured=1 order by id DESC limit {$limit}";
		if($limit!=0)
		{
			// $this->db->limit($limit);
			//$sql="select *from model_test where id not in(select test_id from roadmap) and display=1 order by id DESC limit {$limit}";
			$sql="select *from model_test where display=1 AND type=1 AND is_featured=1 order by id DESC limit {$limit}";
		}

		$qry=$this->db->query($sql)->getResultObject();
		/*if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}*/
	}

	/**
	 * getting model test by category
	 * @param  [type] $cat [description]
	 * @return [type]      [description]
	 */
	function get_model_test_by_cat($cat,$limit='')
	{
		$query = $this->db->table('model_test')->where('category',$cat)
		->where('display','1')
		->where('type',1);
		if(!empty($limit))
		{
			$query = $query->limit($limit);
		}
		//$this->db->order_by('q_type','DESC');
		$query = $query->orderBy('id','DESC');
		return $query->get()->getResultArray();
		/*if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}*/
	}

	/**
	 * getting model test by category in
	 * @param  [type] $cat [description]
	 * @return [type]      [description]
	 */
	function get_model_test_by_cat_limit($cat)
	{
		$this->db->where('category',$cat);
		$this->db->where('display','1');
		$this->db->where('type',1);
		$this->db->order_by('q_type','DESC');
		$this->db->order_by('id','ASC');
		$this->db->limit(3);
		$qry=$this->db->get('model_test');
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

/* End of file model_test_model.php */
/* Location: ./application/models/model_test_model.php */