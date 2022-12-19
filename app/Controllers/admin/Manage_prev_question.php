<?php

class Manage_prev_question extends Admin_Controller {


	public function __construct() 
	{ 
		parent::__construct(); 
		
		$this->load->model('question_model');
		$this->load->model('ref_text_model');
		$this->load->library('pagination');
		
	}
		
	public function index()
	{
		//common property declaration
		$search_key='';
		$exm='';
		$sbj='';
		$chp='';
		$strt=0;
		$lmt=5;
		$total=0;
		//end common property declaration
		
		//building where statement
		if($this->uri->segment(5)){$exm=$this->uri->segment(5);}
		if($this->uri->segment(6)){$sbj=$this->uri->segment(6);}
		if($this->uri->segment(7)){$chp=$this->uri->segment(7);}
		if(!empty($exm)&& $exm!='all')
		{
			$search_key='where exam='.$exm;
			if(!empty($sbj) && $sbj!='allsub')
			{
			$search_key='where exam='.$exm.' and subject='.$sbj;
				if(!empty($chp) && $chp!='allchap')
				{
					$search_key='where exam='.$exm.' and subject='.$sbj.' and chapter='.$chp;
				}
			}
		}
		//end bbuilding where statement
	
		//getting total record
		$total=$this->question_model->prev_question_total($search_key);
		//end getting total record
		
		
		$data['ques']=$this->tbl_question($search_key,$strt,$lmt);
		
		//pagination
		$config['base_url']=base_url().'admin/manage_prev_question/index/';
		$config['total_rows']=$total;
		$config['uri_segment']=4;
		$config['per_page']=5;
		$config['num_links']=3;
		$config['full_tag_open']='<div class="pagination"><ul>';
		$config['full_tag_close']='</ul></div>';
		$config['num_tag_open']='<li>';
		$config['num_tag_close']='</li>';
		$config['cur_tag_open'] = '<li class="curr"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['prev_link'] = '&lt;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&gt;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$this->pagination->initialize($config);
       	$data['make_page']=$this->pagination->create_links();
		//end pagination
		
		$data['exams']=$this->question_model->ref_text_get_exam_all();
		$data['title']='Manage Previous Questions';
		$data['main_content']='admin/v_manage_prev_question';
		$this->load->view('layout_admin/admin_master',$data);		
	}
	
	function tbl_question($key='',$start,$limit)
	{
		$questions=$this->question_model->prev_question_get_all($key,$start,$limit);
		$str='';
		if($questions){
			foreach($questions as $q)
			{
				$exam_name='';
				if($this->ref_text_model->get_ref_text_by_id($q->exam)){
					$exam_name=$this->ref_text_model->get_ref_text_by_id($q->exam)->name;
				}
				$period_name='';
				if($this->ref_text_model->get_ref_text_by_id($q->period))
				{
					$period_name=$this->ref_text_model->get_ref_text_by_id($q->period)->name;	
				}
				$subject_name='';
				if($this->ref_text_model->get_ref_text_by_id($q->subject)){
					$subject_name=$this->ref_text_model->get_ref_text_by_id($q->subject)->name;
				}
				$chapter_name='';
				if(	$chapter_name=$this->ref_text_model->get_ref_text_by_id($q->chapter)){
					$chapter_name=$this->ref_text_model->get_ref_text_by_id($q->chapter)->name;
				}
				
				$str.='<tr>';
				$str.='<td><label>'.$q->question.'</label></td>';
				$str.='<td>'.$exam_name.'</td>';
				$str.='<td>'.$period_name.'</td>';
				$str.='<td>'.$subject_name.'</td>';
				$str.='<td>'.$chapter_name.'</td>';
				$str.='<td><a href="'.base_url().'admin/prev_ans/index/'.$q->id.'" title="add" role="button" data-toggle="modal" data-target="#add_dlg"><i class="icon-plus-sign"></i></a></td>';
				$str.='<td><a id="edit_prev_ques" role="button" data-toggle="modal" data-target="#edit_dlg" href="'.base_url().'admin/edit_prev_question/index/'.$q->id.'"><i class="icon-edit"></i></a></td>';
				$str.='<td><a href=""><i class="icon-trash"></i></a></td>';
				$str.='</tr>';
			}
		}
		
		return $str;
	}
	
	function delete()
	{
		//$this->
	}
	
	function get_subject()
	{
		$pid=$this->input->post('eid');

		$subjects=$this->question_model->ref_text_get_subject_by_parent($pid);
		$str='<option value="-1">-Select Subject-</option>';
		if($subjects){
		foreach($subjects as $s)
		{
			$str.='<option value="'.$s->id.'">'.$s->name.'</option>';
		}	
		}
		
		echo $str;
	}
	
	function get_chapter()
	{
		$cid=$this->input->post('cid');
		$chapters=$this->question_model->ref_text_get_chapter_by_parent($cid);
		$str='<option value="-1">-Select Chapter-</option>';
		foreach($chapters as $c)
		{
			$str.='<option value="'.$c->id.'">'.$c->name.'</option>';
		}
		echo $str;	
	}
	
	
}
	
	