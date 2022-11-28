<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_exam extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
        	
		$this->load->helper('message');
		$this->load->model('exam_model');
		$this->load->model('ref_text_model');
		$this->load->library('my_validation');
		$this->load->model('Exam/marks_mapping_model','mmm');
	}

	public function index()
	{
		$data['subject']=$this->ref_text_model->get_ref_text_by_group(3);
		$data['exam_cat']=$this->ref_text_model->get_ref_text_by_group(2);

		$data['test_types']=$this->ref_text_model->get_ref_text_by_group(7);	
		$data['test_name']=$this->exam_model->get_test_name();
		$data['title']='Create Exam';
		$data['main_content']='admin/v_add_exam';
		$this->load->view('layout_admin/admin_layout', $data);
	}


	function get_chapter_group()
	{
		$sid=$this->input->post('eid');
		$chapter_group=$this->ref_text_model->get_ref_text_by_parent($sid);
		$str="<option value='-1'>-Select a Test-</option>";
		if($chapter_group)
		{
			foreach($chapter_group as $s)
			{
				$str.="<option value='{$s->id}'>{$s->name}</option>";
			}
		}

		echo $str;
	}

	function get_chapters()
	{
		$cid=$this->input->post('eid');
		$chapter=$this->ref_text_model->get_ref_text_by_parent($cid);
		$str="<option value='-1'>-Select Chapter-</option>";
		if($chapter)
		{
			foreach($chapter as $s)
			{
				$str.="<option value='{$s->id}'>{$s->name}</option>";
			}
		}
		echo $str;
	}

	function save_mark_mapping()
	{
		$exam_id=$this->input->post('ddl_exam_list');
		$subject=$this->input->post('ddl_subject');
		$chapter_group=$this->input->post('ddl_chapter_group');
		$chapter=$this->input->post('ddl_chapter');
		//echo "subject={$subject}\nchapter_group={$chapter_group}\nchapter={$chapter}\n";
		$marks=$this->input->post('txt_marks');
		$parent=0;
		$topics=0;
		if($chapter==-1 && $chapter_group==-1){
			$parent=0;
			$topics=$subject;
		}
		else if($chapter==-1 && $chapter_group!=-1)
		{
			$parent=$subject;
			$topics=$chapter_group;
		}
		else if($chapter_group!=-1 && $chapter!=-1)
		{
			$parent=$chapter_group;
			$topics=$chapter;
		}
		
		$data=array('exam_id'=>$exam_id,
			'parent'=>$parent,
			'topics'=>$topics,
			'marks'=>$marks);
		if($subject!=-1)
		{
			$ttl_mrk=$this->exam_model->get_total_marks($exam_id);
			//echo $ttl_mrk."  ".$subject;
			if($marks<=$ttl_mrk)
			{

				if($this->mmm->check_topics($exam_id,$topics))
				{
					$this->session->set_flashdata('error', 'this topics already mapped!');
					redirect(base_url().'admin/add_exam');
				}
				else
				{
					$this->mmm->add($data);
					$this->session->set_flashdata('success', 'marks mapped successfully!');
					redirect(base_url().'admin/add_exam');
				}
			}
			else
			{
				$this->session->set_flashdata('error', 'subject marks cannot exceeds exam total marks!');
				redirect(base_url().'admin/add_exam');
			}
		}
		else
		{
			$this->session->set_flashdata('error', 'you must select a topics!');
			redirect(base_url().'admin/add_exam');
		}
	}
	function subject_list()
	{
		$subject=$this->ref_text_model->get_ref_text_by_group(3);
		$subj_arr=array();
		foreach ($subject as $s) 
		{
			array_push($subj_arr,array('id'=>$s->id,'name'=>$s->name));
		}

		echo json_encode($subj_arr);
	}

	function mapping_list()
	{
		$eid=$this->input->get('exam_id');
		$mlist=$this->mmm->get_mapping_list($eid);
		$str='';
		if($mlist)
		{
			$str="<table class='table table-striped'>";
			$str.='<tr>';
			$str.="<th>Exam</th><th>Parent</th><th>Topics</th><th>Marks</th><th>Action</th>";
			$str.="</tr>";
			foreach($mlist as $ml) 
			{
				$exam_text=exam_model::get_text($ml->exam_id);
				$parent_text=ref_text_model::get_text($ml->parent);
				$topics_text=ref_text_model::get_text($ml->topics);
				$edit_url=base_url().'admin/edit_marks_mapping/index/'.$ml->id;
				$str.="<tr>";
					$str.="<td>$exam_text</td>";
					$str.="<td>{$parent_text}</td>";
					$str.="<td>{$topics_text}</td>";
					$str.="<td>{$ml->marks}</td>";
					$str.="<td><a href='{$edit_url}' role='button' data-toggle='modal' data-target='#edit_dlg'><i class='icon icon-edit'></i></a>&nbsp;&nbsp;
					<a href='<?php echo base_url(); ?>admin/add_question/delete'><i class='icon icon-trash'></i></a></td>";
				$str.="</tr>";
			}
			$str.="</table>";
		}
		else
		{
			$str.="<div class='well'>you have not mapped any marks for this exam!</div>";
		}
		
		echo $str;
	}
	function refresh()
	{
		$prev_exam=$this->exam_model->get_refresh_exam();
		if($prev_exam)
		{
			foreach($prev_exam as $exm)
			{
				$data=array('exam_cat'=>$exm->parent_id,
					'ref_id'=>$exm->id,
					'test_type'=>16,
					'negative_marks'=>0,
					'total_marks'=>100);
				$this->exam_model->add_exam($data);
			}
		}
	}
	function add()
	{
		$exam_cat=$this->input->post('ddl_exam_cat');
		//$subject=$this->input->post('ck_subj')?implode(',',$this->input->post('ck_subj')):'';
		$test_type=$this->input->post('ddl_test_type');
		$test_name=$this->input->post('txt_test_name');
		$total_marks=$this->input->post('txt_total_marks');
		$mark_carry=$this->input->post('txt_mark_carry');
		$negative_marks=$this->input->post('txt_neg_marks');
		$weight=$this->input->post('txt_weight');
		$total_ques=$this->input->post('txt_total_ques');
		$data=array('exam_cat'=>$exam_cat,
			//'consist_of'=>$subject,
			'test_type'=>$test_type,
			'total_marks'=>$total_marks,
			'mark_carry'=>$mark_carry,
			'test_name'=>$test_name,
			'negative_marks'=>$negative_marks,
			'weight'=>$weight,
			'total_ques'=>$total_ques);

		$rules=array('txt_test_name|Test Name'=>'required',
			'ddl_exam_cat|Exam Category'=>'min:0',
			'ddl_test_type|Test Type'=>'min:0',
			'txt_neg_marks|Negetive Marks'=>'number');
	
		if($this->my_validation->validate($_POST,$rules))
		{
			$this->exam_model->add_exam($data);
			$this->session->set_flashdata('success', 'successfully inserted!');
			redirect(base_url().'admin/exam');
		}
		else
		{
			$msg=$this->my_validation->errors;
			
			$this->session->set_flashdata('msg',$msg);
			redirect(base_url().'admin/add_exam');
		}
		
	}

		function check_integrity()
		{
			$exam_id=$this->input->get('exam_id');
			$subject=$this->input->get('subject');
			$chapter_group=$this->input->get('chapter_group');
			$chapter=$this->input->get('chapter');
			
			$marks=$this->input->get('mark');
			$parent=0;
			$topics=0;
			if($chapter==-1 && $chapter_group==-1){
				$parent=0;
				$topics=$subject;
			}
			else if($chapter==-1 && $chapter_group!=-1)
			{
				$parent=$subject;
				$topics=$chapter_group;
			}
			else if($chapter_group!=-1 && $chapter!=-1)
			{
				$parent=$chapter_group;
				$topics=$chapter;
			}
			$str='';
			//echo $this->mmm->check_topics_integrity($exam_id,$parent,$marks);
			if(!$this->mmm->check_topics_integrity($exam_id,$parent,$marks))
			{
				$str.="1-topics sum cannot exceeds its parent marks!";
			}
			echo $str;
		}

}

/* End of file add_exam.php */
/* Location: ./application/controllers/admin/add_exam.php */