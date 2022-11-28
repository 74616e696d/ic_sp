<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exam_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='exam';
	}

	function add_exam($data)
	{
		$this->db->insert('exam',$data);
		return;
	}


	function assign_ques($data)
	{
		$this->db->insert('exam_question',$data);
		return;
	}


	function get_assigned_question($exam_id)
	{
		$this->db->where('exam_id',$exam_id);
		$q=$this->db->get('exam_question');
		if($q->num_rows()>0)
		{
			return $q->row();
		}
		else
		{
			return false;
		}
	}

	

	public static function is_assigned($exam_id)
	{
		$ci =& get_instance();
		$ci->db->where('exam_id',$exam_id);
		$q=$ci->db->get('exam_question');
		if($q->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}

	public static function assigned($exam_id,$qid)
	{
		$ci =& get_instance();
		$where="FIND_IN_SET('{$qid}',ques_id)";  
		$ci->db->where('exam_id',$exam_id);
		$ci->db->where($where);
		
		$q=$ci->db->get('exam_question');
		if($q->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}

	function total_chapter_question($chapter)
	{
		$this->db->where('chapter',$chapter);
		$this->db->select('id');
		$qry=$this->db->get('question_bank');
		return $qry->num_rows();
	}

	function get_subjects($parent=array())
	{
		$sql='';
		if(count($parent)!=0)
		{
			$prnt=implode(',',$parent);
	 		$sql="select *from ref_text where group_id=3 and parent_id in({$prnt})";
	 	}
	 	else
	 	{
	 		$sql="select *from ref_text where group_id=3";
	 	}
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


	function get_user_top_exam($user,$exam_id)
	{
		$this->db->where('user_id',$user);
		$this->db->where('exam_id',$exam_id);
		$qry=$this->db->get('answer_summery');
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}

	function get_exam_question($exam_id)
	{
		$this->db->where('exam_id',$exam_id);
		$q=$this->db->get('exam_question');
		if($q->num_rows()>0)
		{
			return $q->row();
		}
		else
		{
			return false;
		}
	}


	function get_exam_by_eid($eid)
	{
		$this->db->where('exam_cat',$eid);
		$this->db->where('test_type',16);
		$q=$this->db->get('exam');
		if($q->num_rows()>0)
		{
			return $q->result();
		}
		else
		{
			return false;
		}
	}

	function get_prev_exam_by_eid($eid)
	{
		$sql="SELECT e.id,e.exam_cat,e.ref_id,e.test_type,rt.name FROM exam e INNER JOIN ref_text rt ON e.ref_id=rt.id WHERE e.test_type=16 and e.exam_cat={$eid}";
		$q=$this->db->query($sql);
		if($q->num_rows()>0)
		{
			return $q->result();
		}
		else
		{
			return false;
		}
	}

	function get_exam_list_group_by()
	{
		$qry=$this->db->get('exam');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	public static function get_text($id)
	{
		$ci =& get_instance();
		$ci->db->where('id',$id);
		$ci->db->select(array('ref_id','test_name'));
		$q=$ci->db->get('exam');
		if($q->num_rows()>0)
		{
			if(empty($q->row()->ref_id))
			{
				return $q->row()->test_name;
			}
			else
			{
				$ci->db->where('id',$q->row()->ref_id);
				$ci->db->select('name');
				$qry1=$ci->db->get('ref_text');
				if($qry1->num_rows()>0)
				{
					return $qry1->row()->name;
				}
				else
				{
					return '';
				}
			}
		}
		else
		{
			return '';
		}
	}


	public function exams_all($id)
	{
		$this->db->where('id',$id);
		$this->db->select(array('ref_id','test_name'));
		$q=$this->db->get('exam');
		if($q->num_rows()>0)
		{
			if(empty($q->row()->ref_id))
			{
				return $q->row()->test_name;
			}
			else
			{
				$this->db->where('id',$q->row()->ref_id);
				$this->db->select('name');
				$qry1=$this->db->get('ref_text');
				if($qry1->num_rows()>0)
				{
					return $qry1->row()->name;
				}
				else
				{
					return '';
				}
			}
		}
		else
		{
			return '';
		}
	}

	function get_exam_list_by($cat,$exclude=[],$limit='')
	{
		$this->db->cache_on();
		$this->db->where('exam_cat',$cat);
		$this->db->where('test_type','16');
		if(count($exclude)>0)
		{
			$this->db->where_not_in('ref_id',$exclude);
		}
		if(!empty($limit))
		{
			$this->db->limit($limit);
		}
		$this->db->select(array('exam.*','ref_text.name'));
		$this->db->from('exam');
		$this->db->join('ref_text','exam.ref_id=ref_text.id');
		$this->db->order_by('exam.exam_year','DESC');
		$this->db->order_by('ref_text.name','ASC');
		$qry=$this->db->get();
		$this->db->cache_off();
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function get_exam_list_by_limit($cat,$exclude=[])
	{
		$this->db->where('exam_cat',$cat);
		$this->db->where('test_type','16');
		if(count($exclude)>0){
		$this->db->where_not_in('ref_id',$exclude);
		}
		$this->db->select(array('exam.*','ref_text.name'));
		$this->db->limit(4);
		$this->db->from('exam');
		$this->db->join('ref_text','exam.ref_id=ref_text.id');
		if($cat==318)
		{
			$this->db->order_by('ref_text.name','ASC');
		}
		else
		{
			$this->db->order_by('ref_text.name','DESC');
		}
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


	function get_exam_list_in($exam_id=[])
	{
		$this->db->where_in('ref_id',$exam_id);
		$this->db->where('test_type','16');
		$this->db->select(array('exam.*','ref_text.name'));
		// $this->db->limit(4);
		$this->db->from('exam');
		$this->db->join('ref_text','exam.ref_id=ref_text.id');
		$this->db->order_by('ref_text.name','DESC');
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

	function get_exam_list()
	{
		$this->db->where('test_type','16');
		$this->db->select(array('exam.*','ref_text.name'));
		$this->db->from('exam');
		$this->db->join('ref_text','exam.ref_id=ref_text.id');
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

	function exam_by_cat($cat)
	{
		$this->db->where('exam_cat',$cat);
		$this->db->select(array('exam.*','ref_text.name'));
		$this->db->from('exam');
		$this->db->join('ref_text','exam.ref_id=ref_text.id');
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

	function get_latest_exam_by_cat($group,$parent,$limit=3)
	{
		$this->db->where('group_id',$group);
		$this->db->where('parent_id',$parent);
		$this->db->order_by('id','desc');
		$this->db->limit($limit);
		$qry=$this->db->get('ref_text');
		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		}
		else
		{
			return false;
		}
	}
	function get_latest_exam($num=3)
	{
		$this->db->select(array('exam.*','ref_text.name'));
		$this->db->order_by('id','desc');
		$this->db->limit($num);
		$this->db->from('exam');
		$this->db->join('ref_text','exam.ref_id=ref_text.id');
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

	function get_total_marks($id)
	{
		$this->db->where('id',$id);
		$this->db->select('total_marks');
		$q=$this->db->get('exam');
		if($q->num_rows()>0)
		{
			return $q->row()->total_marks;
		}
		else
		{
			return false;
		}
	}


	function get_total_question($eid)
	{
		$this->db->where('exam_id',$eid);
		$qry=$this->db->get('exam_question');
		if($qry->num_rows()>0)
		{
			$q=$qry->row()->ques_id;
			$questions=explode(',',$q);
			if(count($questions)>0)
			{
				return count($questions);
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 0;
		}
	}

	function get_test_name()
	{
		$this->db->select('id,test_name,ref_id,test_type');
		$q=$this->db->get('exam');
		if($q->num_rows()>0)
		{
			return $q->result();
		}else{
			return false;
		}
	}



	/**
	 * getting all test name by test type from exam table
	 * @param  [int] $test_type [description]
	 * @return [object]            [description]
	 */
	function get_test_name_by_type($test_type)
	{
		$this->db->where('test_type',$test_type);
		$this->db->select('id,test_name,ref_id,test_type');
		$q=$this->db->get('exam');
		if($q->num_rows()>0)
		{
			return $q->result();
		}else{
			return false;
		}
	}


	function get_test_name_by_choosen($test_type,$choosen=array())
	{
		$this->db->where('test_type',$test_type);
		$this->db->where_in('ref_id',$choosen);
		$this->db->select('id,test_name,ref_id,test_type');
		$q=$this->db->get('exam');
		if($q->num_rows()>0)
		{
			return $q->result();
		}else{
			return false;
		}
	}
	function get_prev_test_name()
	{
		$this->db->where('test_type',16);
		$this->db->select('id,test_name');
		$q=$this->db->get('exam');
		if($q->num_rows()>0)
		{
			return $q->result();
		}
		else
		{
			return false;
		}
	}

	function prev_test_by_ques($qid)
	{
		$sql="select exam_id from exam_question where find_in_set({$qid},ques_id)";
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

	function test_name_by_type($test_type)
	{
		$this->db->where('test_type',$test_type);
		$this->db->select('id,test_name');
		$q=$this->db->get('exam');
		if($q->num_rows()>0)
		{
			return $q->result();
		}
		else
		{
			return false;
		}
	}
	
	function get_selected_ref_group()
	{
		
	}


	function get_prev_exam()
	{
		$sql="select e.id,e.exam_cat,e.ref_id,e.test_type,rt.name from exam e inner join ref_text rt on e.ref_id=rt.id where e.test_type=16";
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


	function chapter_ques_in_prev_test($chapter)
	{
		$total=0;
		$total_prev=0;
		$count=0;
		$this->db->where('chapter',$chapter);
		$this->db->where('is_prev','1');
		$qry=$this->db->get('question_bank');
		if($qry->num_rows()>0)
		{
			$count=$qry->num_rows();
		}
		// $this->db->where('chapter',$chapter);
		// $qry1=$this->db->get('question_bank');
		// if($qry1->num_rows()>0)
		// {
		// 	$total=$qry1->num_rows();
		// } 
		// if($total!=0)
		// {
		// 	$count=($total_prev/$total)*100;
		// }
		
		return $count;
	}


	function get_prev_exam_by_cat($eid)
	{
		$sql="select e.id,e.exam_cat,e.ref_id,e.test_type,rt.name from exam e inner join ref_text rt on e.ref_id=rt.id where e.test_type=16 and rt.parent_id={$eid}";
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



	function get_refresh_exam()
	{
		$sql="SELECT *FROM ref_text WHERE group_id=5 AND id NOT IN(SELECT ref_id FROM exam WHERE ref_id IS NOT NULL)";
		$qry=$this->db->query($sql);
		if($qry->num_rows())
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function refresh_assigned_question($eid)
	{
		$sql="select *from exam_question where exam_id={$eid}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			$question=$qry->row();
			
				if(!empty($question->ques_id))
				{
					$ques_arr=explode(',',$question->ques_id);
					$i=0;
					foreach($ques_arr as $q)
					{
						if(!empty($q))
						{
							$sql2="select id from question_bank where id={$q}";
							//echo $q.'_'.$question->exam_id.'<br/>';
							$qry2=$this->db->query($sql2);
						
							if($qry2->num_rows()>0)
							{
								//do nothing
							}
							else
							{
								//unset array ques_arr
								unset($ques_arr[$i]);
							}
						}
						$i++;
					}
					$ques_str='';
					if(count($ques_arr)>0)
					{
					$ques_str=implode(',',$ques_arr);
					}
					$dt=array('ques_id'=>$ques_str);
					$this->db->where('exam_id',$eid);
					$this->db->update('exam_question',$dt);

				}		
			}
		else
		{
			return false;
		}
	}

	function find_duplicate_qid($eid)
	{
		$this->db->where('exam_id',$eid);
		$qry=$this->db->get('exam_question');
		if($qry->num_rows()>0)
		{
			$question=$qry->row();
			if(!empty($question->ques_id))
			{
				$ques_arr=explode(',',$question->ques_id);
				$ques_arr_group=array_count_values($ques_arr);
				$i=0;
				foreach($ques_arr as $q)
				{
					$ttl= $ques_arr_group[$q];
					if($ttl>1)
					{
						unset($ques_arr[$i]);
						$ques_arr_group=array_count_values($ques_arr);
					}
					$i++;
				}
				$ques_str=implode(',',$ques_arr);
				$dt=array('ques_id'=>$ques_str);
				$this->db->where('exam_id',$eid);
				$this->db->update('exam_question',$dt);
			}
		}
		else
		{
			return 0;
		}
	}
	function get_exams($start,$limit,$key)
	{
		$sql='select *from exam '.$key.' limit '.$start.','.$limit;
		$q=$this->db->query($sql);
		if($q->num_rows()>0)
		{
			return $q->result();
		}
		else
		{
			return false;
		}
	}

	/**
	 * count total exams by terms
	 * @param  string $terms
	 * @return integer      
	 */
	function get_total($terms='')
	{
		$sql='select *from exam '.$terms;
		$q=$this->db->query($sql);
		return $q->num_rows();
	}

	function get_all()
	{
		$q=$this->db->get('exam');
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
	
	function get_test_type_by_ec($ec)
	{
		$this->db->where('exam_cat',$ec);
		$q=$this->db->get('exam');

		if($q->num_rows()>0)
		{
			return $q->result();
		}
		else
		{
			return false;
		}
	}

	function get_ques_by_criteria($key)
	{
		$sql='select id,subject,question from question_bank '.$key;
		$q=$this->db->query($sql);
		if($q->num_rows()>0)
		{
			return $q->result();
		}else
		{
			return false;
		}
	}


	function update($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('exam',$data);
	}

	function update_assigned_question($exam_id,$data)
	{
		$this->db->where('exam_id',$exam_id);
		$this->db->update('exam_question',$data);
	}

	function delete($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('exam');
	}


	function add_marked_question($data)
	{
		$this->db->insert('temp_question',$data);
		return;
	}
	function exists_marks_question($user,$qid)
	{
		$this->db->where('user_id',$user);
		$this->db->where('qid',$qid);
		$qry=$this->db->get('temp_question');
		if($qry->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function get_marked_questions($ques_arr)
	{
		$this->db->where_in('id',$ques_arr);
		$this->db->select('id,question');
		$qry=$this->db->get('question_bank');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function get_exam_category()
	{
		$this->db->where('group_id','2');
		$this->db->select('name,id');
		$qry=$this->db->get('ref_text');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function get_exam_cat_by_qid($qid)
	{
		$this->load->model('ref_text_model');
		$sql="select exam_id from exam_question where find_in_set($qid,ques_id)";
		$qry=$this->db->query($sql);
		$exams=array();
		if($qry->num_rows()>0)
		{
			$categories=$qry->result();
			foreach($categories as $cat)
			{

				$sql1="select test_name from exam where id={$cat->exam_id}";
				$qry1=$this->db->query($sql1);
				if($qry1->num_rows()>0)
				{
					array_push($exams,$qry1->row()->test_name);
				}

			}
			return $exams;
		}
		else
		{
			return false;
		}
	}

	function delete_marked_question($user)
	{
		$this->db->where('user_id',$user);
		$this->db->delete('temp_question');
	}

	function is_marked($uid,$qid)
	{
		$this->db->where('user_id',$uid);
		$this->db->where('qid',$qid);
		$qry=$this->db->get('ans_review_list');
		if($qry->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

}

/* End of file exam_model.php */
/* Location: ./application/models/exam_model.php */