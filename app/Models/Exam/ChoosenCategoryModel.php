<?php 
namespace App\Models\Exam;
use CodeIgniter\Model;


class ChoosenCategoryModel extends Model {
    protected $allowedFields = ['user_id', 'exam_cat', 'status', 'request_date', 'expiry_date'];
	function __construct()
	{
		parent::__construct();
                $this->table="choosen_exam_cat";
	}

	function insert1($data)
	{
		$this->db->insert('choosen_exam_cat',$data);
	}

	function exists($user,$cat)
	{
		$res = $this->db->table('choosen_exam_cat')->where('user_id',$user)->where('exam_cat',$cat)->get()->getRow();
		if($res)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function get_exam_by_choosen($uid)
	{
		$this->db->where('user_id',$uid);
		$this->db->where('status','2');
		$qry=$this->db->get('choosen_exam_cat');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}

	}

	function get_exam_by_choosen_arr($uid)
	{
		$this->db->where('user_id',$uid);
		$this->db->where('status','2');
		$qry=$this->db->get('choosen_exam_cat');
		$ch_arr=array();
		if($qry->num_rows()>0)
		{
			$result= $qry->result();
			foreach($result as $r)
			{
				$this->db->where('parent_id',$r->exam_cat);
				$this->db->where('group_id','5');
				$qry1=$this->db->get('ref_text');
				if($qry1->num_rows()>0)
				{
					$result1=$qry1->result();
					foreach ($result1 as $r1) 
					{
						array_push($ch_arr,$r1->id);
					}
				}
			}
			return $ch_arr;
		}
		else
		{
			return false;
		}

	}

	function get_exam_choosen_by_cat($uid,$cat)
	{
		$this->db->where('user_id',$uid);
		$this->db->where('exam_cat',$cat);
		$qry=$this->db->get('choosen_exam_cat');
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}
	function get_choosen($uid)
	{
		//$this->db->where('user_id',$uid);
		//$qry = $this->db->get('choosen_exam_cat');
		
		return $this->db->table('choosen_exam_cat')->where('user_id',$uid)
		->where('status !=','0')->get()->getResultObject();
		//$qry = $;
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}
	function choosen_count_key($key)
	{
		$sql="select user_id from choosen_exam_cat {$key}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->num_rows();
		}
		else
		{
			return 0;
		}
	}

	function get_choosen_cat_by_key($start=0,$limit=10,$key='')
	{
		$sql="select *from choosen_exam_cat {$key} order by request_date desc limit {$start},{$limit}";
		//echo $sql;
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

	function get_choosen_cat($uid)
	{
		$this->db->where('user_id',$uid);
		$this->db->select('exam_cat');
		$qry=$this->db->get('choosen_exam_cat');
		$choosen_arr=array();
		if($qry->num_rows()>0)
		{
			$choosen=$qry->result();
			foreach ($choosen as $ch) {
				array_push($choosen_arr,$ch->exam_cat);
			}
			return $choosen_arr;
		}
		else
		{
			return false;
		}

	}

	/**
	 * Count Number Of Users Choosen Exam
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	function choosen_count($user_id)
	{
		$this->db->where('user_id',$user_id);
		$qry=$this->db->get('choosen_exam_cat');
		if($qry->num_rows()>0)
		{
			return $qry->num_rows();
		}
		else
		{
			return 0;
		}
	}

	function approval_count($uid)
	{
		$this->db->where('user_id',$uid);
		$this->db->where('status','2');
		$qry=$this->db->get('choosen_exam_cat');
		if($qry->num_rows()>0)
		{
			return $qry->num_rows();
		}
		else
		{
			return 0;
		}
	}

	function update1($user_id,$cat,$data)
	{
		$this->db->where('user_id',$user_id);
		$this->db->where('exam_cat',$cat);
		$this->db->update('choosen_exam_cat',$data);
	}

	function delete1($user_id,$cat)
	{
		$this->db->where('user_id',$user_id);
		$this->db->where('exam_cat',$cat);
		$this->db->delete('choosen_exam_cat');
	}
}

/* End of file choosen_category_model.php */
/* Location: ./application/models/Exam/choosen_category_model.php */