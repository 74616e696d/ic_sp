<?php 
namespace App\Models;
use CodeIgniter\Model;

class Model_test_question_model extends Model {
	function __construct()
	{
		//parent::__construct();
		$this->table='model_test_question';
	}
	function get_questions_dt($terms=''){
		$sql="select qb.id,qb.subject,rtxt.name as subject_name,qb.chapter,qb.question,qb.options,qb.hints,mtq.test_id as model_test_id from question_bank qb";
		$sql.=" inner join model_test_question mtq on qb.id=mtq.qid inner join ref_text rtxt on qb.subject=rtxt.id {$terms}";
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

	function get_count($terms=''){
		$sql="select qb.id from question_bank qb";
		$sql.=" inner join model_test_question mtq on qb.id=mtq.qid inner join ref_text rtxt on qb.subject=rtxt.id {$terms}";
		$qry=$this->db->query($sql);
		return $qry->num_rows();
	}

	static function get_total($test_id)
	{
		$ci =& get_instance();
		$ci->db->where('test_id',$test_id);
		$qry=$ci->db->select('id');
		$qry=$ci->db->get('model_test_question');
		return $qry->num_rows();
	}

	function is_assigned($test_id,$qid)
	{
		$this->db->where('test_id',$test_id);
		$this->db->where('qid',$qid);
		$qry=$this->db->get('model_test_question');
		if($qry->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function update_assigned_ques($test_id,$qid,$data)
	{
		$this->db->where('test_id',$test_id);
		$this->db->where('qid',$qid);
		$this->db->update('model_test_question',$data);
	}
	

}

/* End of file model_test_question_model.php */
/* Location: ./application/models/model_test_question_model.php */