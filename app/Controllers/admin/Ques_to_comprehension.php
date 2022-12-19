<?php

class Ques_to_comprehension extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('ref_text_model');
		$this->load->model('question_bank_model');
		$this->load->model('manage_comprehension_model');
	}
	public function index()
	{
		$comp_id=$this->uri->segment(4);
		$data['exam_cat']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['com_id']=$comp_id;
		$data['title']='';
		$this->load->view('admin/v_ques_comprehension', $data);	
	}

	function edit_assigned_view()
    {
        $comp_id=$this->uri->segment(4);
        $comp_ques=$this->manage_comprehension_model->comp_ques($comp_id);
        $str='';
        if($comp_ques)
        {
        	$str.="<ul class='list-group'>";
        	foreach ($comp_ques as $cq) {
        		$ques_text=question_bank_model::ques_text($cq->qid);
        		$ques_text_plain=strip_tags($ques_text,"<img><b><i><u><sub><sup>");
        		$url=base_url()."admin/ques_to_comprehension/delete_assigned_ques/{$cq->id}";
        		$str.="<li class='list-group-item'>{$ques_text_plain} <a style='float:right' class='btn btn-small btn-info delete_ques' data-id={$cq->id}><i class='fa fa-trash-o'></i>&nbsp;&nbsp;Delete</a></li>";
        	}
        	$str.="</ul>";
        }
        else
        {
        	$str.="<p>No assigned question found in this comprehension</p>";
        }

        $data['qlist']=$str;
		$data['exam_cat']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['com_id']=$comp_id;
		$data['title']='';
		$this->load->blade('admin/edit_ques_comprehension', $data);	
    }

    function delete_assigned_ques()
    {
    	$id=$this->input->get('id');
    	$this->manage_comprehension_model->delete_ques($id);
    }

	function get_subject()
	{
		$id=$this->input->get('pid');
		$subjects=$this->ref_text_model->get_subject_of_exam_cat($id);
		$str="<option value='-1'>Select Subject</option>";
		if($subjects)
		{
			foreach ($subjects as $subj) {
				$str.="<option value='{$subj->id}'>{$subj->name}</option>";
			}
		}
		echo $str;
	}
	function get_cahpter_group()
	{
		$id=$this->input->get('pid');
		$subjects=$this->ref_text_model->get_ref_text_by_parent($id);
		$str="<option value='-1'>Select Chapter Group</option>";
		if($subjects)
		{
			foreach ($subjects as $subj) {
				$str.="<option value='{$subj->id}'>{$subj->name}</option>";
			}
		}
		echo $str;
	}
	function get_chapter()
	{
		$id=$this->input->get('pid');
		$subjects=$this->ref_text_model->get_ref_text_by_parent($id);
		$str="<option value='-1'>Select Chapter</option>";
		if($subjects)
		{
			foreach ($subjects as $subj) {
				$str.="<option value='{$subj->id}'>{$subj->name}</option>";
			}
		}

		echo $str;
	}

	function search_criteria($subj,$chap_group,$chapter)
	{
		$stringReturned=" where";
		$stringToFinalReturn="";
		$stringReturned.=" has_paragraph=1 and";
		if($subj!=-1  )
		{
		    $stringReturned.=" subject={$subj} and ";
		}
		if($chap_group!=-1)
		{
			$stringReturned.=" chapter_group={$chap_group} and ";
		}
		if($chapter!=-1)
		{
			$stringReturned.=" chapter={$chapter} and "; 
		}
		if($stringReturned!=' where')
		{
		    $stringToFinalReturn=substr($stringReturned,0,strlen($stringReturned)-4);
		}
		return $stringToFinalReturn;
	}

	function ques_list()
	{
		$subj=$this->input->post('subj');
		$chap_group=$this->input->post('chap_group');
		$chapter=$this->input->post('chapter');
		$comp_id=$this->input->post('comp_id');
		$comp_ques=$this->manage_comprehension_model->comp_ques($comp_id);
		$comp_ques_arr=array();
		if($comp_ques)
		{
			foreach ($comp_ques as $cq) {
				array_push($comp_ques_arr,$cq->qid);
			}
		}
		$key=$this->search_criteria($subj,$chap_group,$chapter);
		$questions=$this->question_bank_model->get_questions($key);
		$str="";
		if($questions)
		{
			foreach ($questions as $ques) 
			{
				$cked=in_array($ques->id,$comp_ques_arr)?'checked':'';
				$striped_ques=strip_tags(trim($ques->question),'<img>');
				$str.="<li class='list-group-item'>";
				$str.="<input class='pull-left' {$cked} type='checkbox' name='ck_ques[]' value='{$ques->id}'>";
				$str.="&nbsp;{$striped_ques}</li>";
			}
		}
		echo $str;

	}

	function ques_auto_coomplete()
	{
		$search_key=$this->input->get('ques');
		$key=" where has_paragraph=1 and question like '%{$search_key}%'";
		$questions=$this->question_bank_model->get_questions($key);
		$str="";
		if($questions)
		{
			foreach ($questions as $ques) {
				$striped_ques=strip_tags(trim($ques->question),'<img>');
				$str.="<li class='list-group-item'>";
				$str.="<input class='pull-left' type='checkbox' name='ck_ques[]' value='1{$ques->id}'>";
				$str.="&nbsp;{$striped_ques}</li>";
			}
		}
		echo $str;
	}

	function assign()
	{
		$com_id=$this->input->post('hdn_com_id');
		$ques=$this->input->post('ck_ques');
		$data=array();
		if(count($ques)>0)
		{
			foreach ($ques as $q) 
			{
				if(!$this->manage_comprehension_model->exists_ques($com_id,$q))
				{
						$data_item=array('comp_id'=>$com_id,
							'qid'=>$q);
						array_push($data,$data_item);
				}
			}
			//die(var_dump($data));
			$this->manage_comprehension_model->insert_ques_to_comp($data);
			$this->session->set_flashdata('success', 'selected questions assigned successfully!');
			redirect(base_url().'admin/manage_comprehension');
		}
		redirect(base_url().'admin/manage_comprehension');
	}

}

/* End of file ques_to_comprehension.php */
/* Location: ./application/controllers/admin/ques_to_comprehension.php */