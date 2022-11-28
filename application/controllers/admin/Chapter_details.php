<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chapter_details extends Admin_Controller {
	function __construct()
	{
		parent::__construct();
      	
		$this->load->helper('message');
		$this->load->model('ref_text_model');
		$this->load->model('chapter_details_model');
		$this->load->library('ckeditor');
		$this->ckeditor->config['toolbar']='full';
        //$this->ckeditor->config['toolbar']=array(array( 'Image', 'Link', 'Unlink', 'Anchor','Source','Underline','Subscript','Superscript' ));
        $this->ckeditor->config['height']='150px';
	}
	public function index()
	{
		$data['exams']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['chapters']=$this->ref_text_model->get_ref_text_by_group(4);
		$data['title']='Add Chapter Details';
		$data['main_content']='admin/v_chapter_details';
		$this->load->view('layout_admin/admin_layout', $data);
	}

	function add()
	{
		$ref_id=$this->input->post('ddl_chapter');
		$details=$this->input->post('txt_details');
		$tips=$this->input->post('txt_tips');
		//var_dump($tips);
		$data=array('ref_id'=>$ref_id,
			'hot_tips'=>$tips,
			'details'=>$details);
		$data_update=array('hot_tips'=>$tips,"details"=>$details);
		//$count=count($this->chapter_details_model->get_details_by_ref($ref_id));
		//echo $count;
		if($this->chapter_details_model->get_details_by_ref($ref_id))
		{
			if($ref_id!=-1)
			{
				//var_dump($data_update);
				$this->chapter_details_model->update($ref_id,$data_update);
				$this->session->set_flashdata('success', 'successfully updated!');
				redirect(base_url().'admin/chapter_details');
			}
			else
			{
				$this->session->set_flashdata('warning', 'you must select a chapter');
				redirect(base_url().'admin/chapter_details');
			}
		}
		else
		{
			if($ref_id!=-1)
			{
				$this->chapter_details_model->insert($data);
				$this->session->set_flashdata('success', 'successfully saved!');
				redirect(base_url().'admin/chapter_details');
			}
			else{
				$this->session->set_flashdata('warning', 'you must select a chapter');
				redirect(base_url().'admin/chapter_details');
			}	
		}
	}

	function get_ref_details()
	{
		$rid=$this->input->get('rid');
		$ref_details=$this->chapter_details_model->get_details_by_ref($rid);
		$str='';
		if($ref_details)
		{
			$str.=$this->ckeditor->editor("txt_tips",$ref_details->hot_tips);
			$str.=$this->ckeditor->editor("txt_details",$ref_details->details);
		}
		else
		{
			$str.=$this->ckeditor->editor("txt_tips","");
			$str.=$this->ckeditor->editor("txt_details","");
		}
		echo $str;
	}

	function get_subjects()
	{
		$eid=$this->input->post('eid');
		$subjects=$this->ref_text_model->get_subject_of_exam_cat($eid);
		$str="<option value='-1'>Select Subject</option>";
		if($subjects)
		{
			foreach ($subjects as $subj) {
				$str.="<option value='{$subj->id}'>{$subj->name}</option>";
			}
		}
		echo $str;
	}

	function get_chapters()
	{
		$subj=$this->input->post('subj');
		$chapter_group=$this->ref_text_model->get_ref_text_by_parent($subj);
		$str="<option value='-1'>Select Chapter</option>";
		if($chapter_group)
		{
			foreach ($chapter_group as $cpt_grp) {
				$chapters=$this->ref_text_model->get_ref_text_by_parent($cpt_grp->id);
				if($chapters)
				{
					foreach ($chapters as $cpt) {
						$str.="<option value='{$cpt->id}'>{$cpt->name}</option>";
					}
				}
			}
		}
		echo $str;
	}

}

/* End of file chapter_details.php */
/* Location: ./application/controllers/admin/chapter_details.php */