<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reference_text extends Admin_Controller {

	public function __construct() 
	{ 
		parent::__construct(); 
		
		$this->load->model('ref_text_model');
		$this->load->library('pagination');
		$this->load->helper('common');
	}
	public function index()
	{
		$total=0;
		//getting search key
		$selected_index=-1;
		if($this->uri->segment(4))
		{
			if($this->uri->segment(4)!='-1')
			{
				$selected_index=$this->uri->segment(4);
				$total=$this->ref_text_model->total('where group_id='.$selected_index);
			}else
			{
				$total=$this->ref_text_model->total('');
			}
		}
		else
		{
			$total=$this->ref_text_model->total('');
		}
		$data['selected_index']=$selected_index;

		$term='';
		if($selected_index!=-1)
		{
		$term='where group_id='.$selected_index;
		}
		//end getting search key
		
		//pagination
		$start=0;
		if($this->uri->segment(5)){
		$start=$this->uri->segment(5);	
		}
		
		$limit=25;
       	$burl=base_url().'admin/reference_text/index/'.$selected_index.'/';
       	$data['make_page']=create_pagination($burl,$total,5,3,$limit);
       	//end pagination
       	
		$data['ref_group']=$this->ref_text_model->get_ref_group();
		$data['ref_text']=$this->ref_text_tbl($start,$limit,$term);
		$data['title']='Manage Reference Text';	
		$data['main_content']='admin/v_reference_text';	
		$this->load->view('layout_admin/admin_layout',$data);
	}
	function add_ref_group()
	{
		$group=$this->input->post('txt_ref_group');
		$data=array('name'=>$group);
		if(!empty($group))
		{
			$this->ref_text_model->insert_ref_group($data);
		}
		redirect(base_url().'admin/reference_text');
	}
	
	function add_ref_rext()
	{
		$parent=$this->input->post('ckParent');
		$parent_text=0;
		IF($parent)
		{
			$parent=1;
		}
		
		$name=$this->input->post('txtRefText');
		$group=$this->input->post('ddlRefGroup');
		$order=$this->input->post('txtOrder');
		$display=$this->input->post('ckDisplay');
		if(!empty($parent))
		{
			$parent_text=$this->input->post('ddlParent');
		}
		$data=array('name'=>$name,
		'group_id'=>$group,
		'parent_id'=>$parent_text,
		'serial'=>$order,
		'display'=>$display);
		if(!empty($name))
		{
			$ins_id=$this->ref_text_model->insert_ref_text($data);
			if($group==5)
			{
				if($parent_text!=0)
				{
				$data_exam=array('exam_cat'=>$parent_text,
					'ref_id'=>$ins_id,
					'test_type'=>'16',
					'test_name'=>$name);
				$this->ref_text_model->add_to_exam($data_exam);
				}
			}
		}
		redirect(base_url().'admin/reference_text');
		
	}
	

	
	function ref_text_tbl($start=0,$limit=20,$key='')
	{
		$rtxt=$this->ref_text_model->get_ref_text($start,$limit,$key);
		$str='';
		if($rtxt){
		foreach($rtxt as $rt )
		{
			$cked='';
			if($rt->display)
			{
				$cked='checked';
			}
			$str.='<tr>';
				$str.='<td>'.$rt->name.'</td>';
				$str.='<td>'.$this->ref_text_by_group($rt->group_id).'</td>';
				$str.='<td>'.$this->get_text($rt->parent_id).'</td>';
				$str.='<td>'.$rt->serial.'</td>';
				$str.='<td><input disabled type="checkbox" '.$cked.'/></td>';
				$str.='<td>';
					$str.='<span class="ttp" data-toggle="tooltip" data-placement="top" title="Edit"><a id="edit_ref" role="button" data-toggle="modal" data-target="#edit_dlg" href="'.base_url().'admin/edit_ref_text/index/'.$rt->id.'"><i class="icon-edit"></i></a></span>';
					$str.='&nbsp;&nbsp;&nbsp;&nbsp;<span class="ttp" data-toggle="tooltip" data-placement="top" title="Delete"><a onclick="return(confirm(\'are you sure to delete?\'));" href="'.base_url().'admin/reference_text/delete/'.$rt->id.'"><i class="icon-trash"></i></a></span>';
				$str.='</td>';
			$str.='</tr>';
		}
		}
		return $str;
	}
	
	function get_ref_text_ddl()
	{
		$grp=$this->input->post('groupid');
		$ref_text_ddl=$this->ref_text_model->get_ref_text_by_group($grp);
		$str='';
		foreach($ref_text_ddl as $rtxt)
		{
			$str.='<option value="'.$rtxt->id.'">'.$rtxt->name.'</option>';
		}
		echo $str;
	}
	
	function ref_text_by_group($gid)
	{
		if($this->ref_text_model->get_ref_group_by_id($gid))
		return $this->ref_text_model->get_ref_group_by_id($gid)->name;
	}
	function get_text($id)
	{
		if(!ref_text_model::get_text($id))
		{
			return 'No Parent';
		}else{
			return ref_text_model::get_text($id);
		}
		
	}

	function delete()
	{
		$id=$this->uri->segment(4);
		$this->ref_text_model->delete_ref_text($id);
		redirect(base_url().'admin/reference_text');
	}
}
	
	