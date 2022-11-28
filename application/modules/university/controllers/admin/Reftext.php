<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reftext extends Uniadmin_Controller {

	public function __construct() 
	{ 
		parent::__construct(); 
		
		$this->load->model('reftext_model');
		$this->load->library('pagination');
		$this->load->helper('common');
	}
	public function index()
	{
		$data['ref_group']=$this->reftext_model->get_ref_group();
		$data['title']='Manage Reference Text';	
		$this->load->blade('admin.reftext.index',$data);
	}

		/**
		 * ref text list for datatables
		 * 
		 * @return json
		 */
		function ref_list_dt()
	    {
	       $length=$_POST['length'];
	       $term='';
	       $search=$_POST['search']['value'];
	       $filterStr='';
	       if($search){
	           $search_terms=json_decode($search);
	           $searchStr=' where';
	           if(!empty($search_terms->name))
	           {
	               $searchStr.=" rtxt.name like '%{$search_terms->name}%' and ";
	           }

	           if(!empty($search_terms->group))
	           {
	               $searchStr.=" rtxt.group_id={$search_terms->group} and ";
	           }

	           if($searchStr!=' where')
	           {
	               $term.=substr($searchStr,0,strlen($searchStr)-4);
	           }
	           $filterStr=$term;
	       }

	      $no = $_POST['start'];
	      $term.=" order by id desc limit {$no},{$length}";
	      $list = $this->reftext_model->get_search($term);
	      
	      $data = array();
	      if($list)
	      {
	          foreach($list as $item) 
	          {
	              $no++;
	              $row = array();
	              // $ques=strip_tags($item->question);
	              $row[] = $item->id;
	              $row[] = $item->name;
	              $row[] = $item->group_name;
	              $row[] = $item->parent_text;
	              $row[] = $item->serial;
	              $add_lnk=base_url().'university/admin/reftext/child_ref_text/'.$item->id;
	              $edit_lnk=base_url().'university/admin/reftext/edit/'.$item->id;
	              $action='';
	              $action.="<a href='{$add_lnk}' data-toggle='modal' data-target='#addChildReftext' class='btn btn-small btn-success'><i class='fa fa-plus'></i></a> ";
	              $action.="<a class='btn btn-small btn-primary' title='Edit' data-toggle='modal' data-target='#addEditReftext' href='{$edit_lnk}'><i class='fa fa-edit'></i></a>";
	              $action.=" <a class='btn btn-small btn-danger' href='javascript:void(0)' title='Delete' onclick='delete_job({$item->id})'><i class='fa fa-trash-o'></i></a>";
	              $row[] = $action;
	                    

	              $data[] = $row;
	          }
	      }
	      $total=$this->reftext_model->get_search_total();
	      $total_filtered=$this->reftext_model->get_search_total($filterStr);
	      $output = array(
	                      "draw" => $_POST['draw'],
	                      "recordsTotal" =>$total ,
	                      "recordsFiltered" => $total_filtered,
	                      "data" => $data,
	              );
	      //output to json format
	      echo json_encode($output);
	    }


	/**
	 * display reference group by ajax call
	 * @return void
	 */
	function ref_group_table()
	{
		$groups=$this->reftext_model->get_ref_group();

		$str='';
		if($groups)
		{
			foreach($groups as $rg)
			{
				$str.="<tr>";
				$str.="<td>{$rg->id}</td>";
				$str.="<td>{$rg->name}</td>";
				$str.="<td>";
				$new_ref_text_lnk=base_url().'university/admin/reftext/new_ref_text/grp/'.$rg->id;
				$str.="<a href='{$new_ref_text_lnk}' data-target='#addReftext' class='btn btn-small' data-toggle='modal'>";
				$str.="<i class='fa fa-plus-circle'></i> Add Reftext To This Group</a>";
				$str.="</td>";
				$str.="</tr>";
			}
		}
		else
		{
			$str.="<tr>";
			$str.="<td colspan='3'>No Group Found !</td>";
			$str.="</tr>";
		}

		echo $str;
	}

	function new_ref_text()
	{
		$ref='';
		$ref_id=0;

		if($this->uri->segment(5))
		{
			$ref=$this->uri->segment(5);//Referer may be grp for grp or prnt for parent
			$ref_id=$this->uri->segment(6);
		}
		$data['ref']=$ref; 
		$data['ref_id']=$ref_id;

		$data['ref_group']=$this->reftext_model->get_ref_group();
		$this->load->blade('admin.reftext.create', $data);
	}


	/**
	 * display view to add child reftext
	 * @return void
	 */
	function child_ref_text()
	{
		$ref_id=$this->uri->segment(5);
		$data['ref_id']=$ref_id;
		$data['ref_group']=$this->reftext_model->get_ref_group();
		$this->load->blade('admin.reftext.create_child', $data);
	}

	/**
	 * save child reftext to database
	 * @return void
	 */
	function save_child_ref_text()
	{
		$name=$this->input->post('txtRefText');
		$group=$this->input->post('ddlRefGroup');
		$order=$this->input->post('txtOrder');
		$display=$this->input->post('ckDisplay');
		$parent_id=$this->input->post('hdn_parent');

		$data=array('name'=>$name,
		'group_id'=>$group,
		'parent_id'=>$parent_id,
		'serial'=>$order,
		'display'=>$display);

		if(!empty($name) && $group!=-1)
		{
			$ins_id=$this->reftext_model->insert_ref_text($data);
		}
		echo "ok";
	}


	function edit()
	{
		$id=$this->uri->segment(5);
		$data['ref_group']=$this->reftext_model->get_ref_group();
		$data['reftext']=$this->reftext_model->find($id);
		$this->load->blade('admin.reftext.edit', $data);
	}

	function update()
	{
		$parent=$this->input->post('ckParent');
		$parent_text=0;
		if($parent)
		{
			$parent=1;
		}
		$id=$this->input->post('hdn_id');
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
			$ins_id=$this->reftext_model->update($id,$data);
		}
		echo "ok";
	}

	/**
	 * add new ref group to database
	 *
	 * @return  void
	 */
	function add_ref_group()
	{
		$group=$this->input->post('group');
		$data=array('name'=>$group);
		if(!empty($group))
		{
			$group_id=$this->reftext_model->insert_ref_group($data);
			echo $group_id;
		}
		echo "Ok";
	}
	
	function add_ref_rext()
	{
		$parent=$this->input->post('ckParent');
		$parent_text=0;
		if($parent)
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
			$ins_id=$this->reftext_model->insert_ref_text($data);
			if($group==5)
			{
				if($parent_text!=0)
				{
				$data_exam=array('exam_cat'=>$parent_text,
					'ref_id'=>$ins_id,
					'test_type'=>'16',
					'test_name'=>$name);
				$this->reftext_model->add_to_exam($data_exam);
				}
			}
		}
		echo "ok";
	}
	

	
	function ref_text_tbl($start=0,$limit=20,$key='')
	{
		$rtxt=$this->reftext_model->get_ref_text($start,$limit,$key);
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
		$sel=$this->input->post('sel')?$this->input->post('sel'):'';
		$ref_text_ddl=$this->reftext_model->get_ref_text_by_group($grp);
		$str='';
		if($ref_text_ddl)
		{
			foreach($ref_text_ddl as $rtxt)
			{
				$selected=$sel==$rtxt->id?"selected":'';
				$str.='<option '.$selected.'  value="'.$rtxt->id.'">'.$rtxt->name.'</option>';
			}
		}
		echo $str;
	}
	
	function ref_text_by_group($gid)
	{
		if($this->reftext_model->get_ref_group_by_id($gid))
		return $this->reftext_model->get_ref_group_by_id($gid)->name;
	}
	function get_text($id)
	{
		if(!reftext_model::get_text($id))
		{
			return 'No Parent';
		}else{
			return reftext_model::get_text($id);
		}
		
	}

	function delete()
	{
		$id=$this->uri->segment(4);
		$this->reftext_model->delete_ref_text($id);
		redirect(base_url().'university/admin/reftext');
	}
}
	
	