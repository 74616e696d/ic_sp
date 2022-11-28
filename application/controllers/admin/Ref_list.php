<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ref_list extends Admin_Controller {

	var $sel_id='na';
	var $sel_group=-1;
	var $sel_parent=-1;
	var $total=0;
	function  __construct()
	{
		parent::__construct();
		$this->load->model('ref_text_model');
		$this->load->library('pagination');	
	}
	public function index()
	{
		$total=0;
		//getting search key
		if($this->uri->segment(4)){$this->sel_id=$this->uri->segment(4);}
		if($this->uri->segment(5)){$this->sel_group=$this->uri->segment(5);}
		if($this->uri->segment(6)){$this->sel_parent=$this->uri->segment(6);}


		$term=$this->search_term();
		$total=$this->ref_text_model->search_total($term);
		//end getting search key
		
		//pagination
		$start=0;
		if($this->uri->segment(7))
		{
		$start=$this->uri->segment(7);	
		}
		
		$limit=25;
		$total=$this->ref_text_model->search_total($term);
       	$burl=base_url()."admin/ref_list/index/{$this->sel_id}/{$this->sel_group}/{$this->sel_parent}/";
       	$links=create_pagination($burl,$total,7,3,$limit);
       	$parent_list='';
       	if($this->sel_group!=-1)
       	{
       		$parent_list=$this->parent($this->sel_group);
       	}
       	//end pagination
       	
       	$data['parent_list']=$parent_list;
       	$data['page_link']=$links;
       	$data['sel_id']=$this->sel_id;
       	$data['sel_group']=$this->sel_group;
       	$data['sel_parent']=$this->sel_parent;
       	$data['ref_group']=$this->ref_text_model->get_ref_group();
       	$data['ref_text']=$this->ref_text_tbl($start,$limit,$term);
		$data['title']='Reference Text List';
		$this->load->blade('admin.ref_list', $data);
	}


	function search_term()
	{
        $stringToFinalReturn='';
        $stringReturned=' where';
        if($this->sel_id!='na')
        {
        	if(is_numeric($this->sel_id))
        	{
            	$stringReturned.=" rtxt.id={$this->sel_id} and ";
        	}
        	else
        	{
        		$stringReturned.=" rtxt.name='{$this->sel_id}' and ";
        	}
        }
        if($this->sel_group!=-1 && $this->sel_parent==-1)
        {
            $stringReturned.=" rtxt.group_id={$this->sel_group} and ";
        }
        if($this->sel_parent!=-1 && $this->sel_parent!='null')
        {
            $stringReturned.=" rtxt.parent_id={$this->sel_parent} and ";
        }

        if($stringReturned!=' where')
        {
            $stringToFinalReturn=substr($stringReturned,0,strlen($stringReturned)-4);
        }
        return $stringToFinalReturn;
	}

	function ref_text_tbl($start=0,$limit=20,$key='')
	{
		$rtxt=$this->ref_text_model->all_ref_text($start,$limit,$key);
		$str='';
		if($rtxt)
		{
		$str.="<table class='table table-striped table-bordered'>";
		$str.="<thead>";
		$str.="<tr>";
		$str.="<th>Name</th>";
		$str.="<th>Group</th>";
		$str.="<th>Parent</th>";
		$str.="<th>Order</th>";
		$str.="<th>Display</th>";
		$str.="<th>Action</th>";
		$str.="</tr>";
		$str.="</thead>";
		$str.="<tbody>";
		foreach($rtxt as $rt )
		{
			$edit_url=base_url().'admin/edit_ref_text/index/'.$rt->id;
			$parent=empty($rt->parent_text)?'No Parent':$rt->parent_text;
			$display=$rt->display?'Displayed':'Not Displayed';
			$str.='<tr>';
				$str.="<td>{$rt->name}</td>";
				$str.="<td>{$rt->group_name}</td>";
				$str.="<td>{$parent}</td>";
				$str.="<td>{$rt->serial}</td>";
				$str.="<td>{$display}</td>";
				$str.='<td>';
				$str.="<span class='ttp' data-toggle='tooltip' data-placement='top' title='Edit'><a id='edit_ref' role='button' data-toggle='modal' data-target='#edit_dlg' href='{$edit_url}'><i class='icon-edit'></i></a></span>";
				$str.='&nbsp;&nbsp;&nbsp;&nbsp;<span class="ttp" data-toggle="tooltip" data-placement="top" title="Delete"><a onclick="return(confirm(\'are you sure to delete?\'));" href="'.base_url().'admin/reference_text/delete/'.$rt->id.'"><i class="icon-trash"></i></a></span>';
				$str.='</td>';
			$str.='</tr>';
		}
		$str.="</tbody>";
		$str.="</table>";
		}
		return $str;
	}

	function parent($group)
	{

		$parents=$this->ref_text_model->get_ref_text_by_group($group);
		$str="<option value='-1'>Select Parent</option>";
		if($parents)
		{
			foreach ($parents as $prnt) {
				$str.="<option value='{$prnt->id}'>{$prnt->name}</option>";
			}
		}
	
		return $str;
	}	

	function  parent_list()
	{
		$group=$this->input->get('group');
		$prnt_list=$this->parent($group);
		echo $prnt_list;

	}

}

/* End of file ref_list.php */
/* Location: ./application/controllers/admin/ref_list.php */
