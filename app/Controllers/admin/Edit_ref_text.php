<?php

class Edit_ref_text extends Admin_Controller {

	public function __construct() 
	{	 
		parent::__construct(); 
		$this->load->model('ref_text_model');
	}

	public function index()
	{

		$id=$this->uri->segment(4);
		$data['reftxt']=$this->ref_text_model->get_ref_text_by_id($id);
		
		//show selected parent text
		$prnt_id=$this->ref_text_model->get_ref_text_by_id($id)->parent_id;
		$prnt='';
		$pid=0;
		if($prnt_id!=0)
		{
			if(ref_text_model::get_text($prnt_id))
			{
			$prnt=$this->ref_text_model->get_ref_text_by_id($prnt_id)->name;
			$pid=$this->ref_text_model->get_ref_text_by_id($prnt_id)->id;
			}
			
		}
		$data['gid']=$this->ref_text_model->get_ref_text_by_id($id)->group_id;
		$data['parent_txt']=$prnt;
		$data['parent_id']=$pid;
		//end show selected parent text
		
		$data['ref_group']=$this->ref_text_model->get_ref_group();
		$data['title']='Edit Reference Text';
		$this->load->view('admin/v_edit_ref_text',$data);	
	}
	
	function get_ref_text_ddl()
	{
		$grp=$this->input->post('groupid');
		$ref_text_ddl=$this->ref_text_model->get_ref_text_by_group($grp);
		$str='';
		foreach($ref_text_ddl as $rtxt)
		{
			$str.='<option  value="'.$rtxt->id.'">'.$rtxt->name.'</option>';
		}
		echo $str;
	}
	function update()
	{
		$id=$this->input->post('hdn_id');
		$name=$this->input->post('txtRefTextEdit');
		$group_id=$this->input->post('ddlRefGroupEdit');
		$ckParent=$this->input->post('ckParentEdit');
		$parent=0;
		if($ckParent){
			$parent=$this->input->post('ddlParentEdit');
		}else
		{
			if($this->input->post('hdn_id'))
			$parent=$this->input->post('hdn_pid');
		}
		$serial=$this->input->post('txtOrderEdit');
		$display=$this->input->post('ckDisplayEdit');
		$data=array('name'=>$name,
		'group_id'=>$group_id,
		'parent_id'=>$parent,
		'serial'=>$serial,
		'display'=>$display);
	
		if(!empty($name))
		{
			$this->ref_text_model->update_ref_text($id,$data);
		}
		redirect(base_url().'admin/reference_text');
		
	}
}
	
	