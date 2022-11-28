<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_exam_mapping_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='company_exam_mapping';
	}

	function get_one($company,$cat)
	{
		$sql="select * from company_exam_mapping where company_id={$company} and cat_id={$cat}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		return false;
	}

	function already_mapped($company_id,$cat_id)
	{
		$sql="select company_id from company_exam_mapping where company_id={$company_id} and cat_id={$cat_id}";
		$qry=$this->db->query($sql);
		return $qry->num_rows()>0?true:false;
	}

	function get_prev_exam($parent_id)
	{
		$sql="select * from ref_text where group_id=5 and parent_id={$parent_id}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	function get_model_test($cat)
	{
		$sql="select * from model_test where category={$cat}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	function get_mapping()
	{
		$sql="select jem.*,c.company_name from company_exam_mapping jem join company_info c on jem.company_id=c.id";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			$result=$qry->result();
			$data_array=[];
			foreach ($result as $item) 
			{
				$data['company_id']=$item->company_id;
				$data['company_name']=$item->company_name;
				$data['cat_id']=$item->cat_id;
				$prev_exam=!empty($item->prev_exam)?json_decode($item->prev_exam):[];
				$data['prev_exam_name']=$this->prev_exam_name($prev_exam);
				$model_test=!empty($item->model_test)?json_decode($item->model_test):[];
				$data['model_test_name']=$this->model_test_name($model_test);
				array_push($data_array, $data);
			}
			return $data_array;
		}
		return false;
	}

	function model_test_name($model_test_id)
	{
		$str_model_test=implode(',',$model_test_id);
		$sql="select name from model_test where id in({$str_model_test})";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			$result=$qry->result();
			$str="";
			foreach ($result as $item) {
				$str.="<span class='badge'>{$item->name}</span> ";
			}
			return $str;
		}
		return '';
	}

	function prev_exam_name($ref_text_id)
	{
		$str_ref_text=implode(',',$ref_text_id);
		$sql="select name from ref_text where id in({$str_ref_text})";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			$result=$qry->result();
			$str="";
			foreach ($result as $item) {
				$str.="<span class='badge'>{$item->name}</span> ";
			}
			return $str;
		}
		return '';
	}

	function update_mapping($company_id,$cat_id,$data)
	{
		$this->db->where('company_id',$company_id);
		$this->db->where('cat_id',$cat_id);
		$this->db->update('company_exam_mapping',$data);
	}

}

/* End of file company_exam_mapping.php */
/* Location: ./application/models/job/job_exam_mapping.php */