<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_ref_text extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('ref_text_model');
	}
	public function index()
	{
		$data['groups']=$this->ref_text_model->get_ref_group();
		$data['title']='Order Reference Text';
		$data['main_content']='admin/order_ref_text';
		$this->load->view('layout_admin/admin_layout',$data);
	}

	function search_ref_text()
	{
		$group=$this->input->post('gp');
		$parent=$this->input->post('prnt');
		$exclude_group=$this->input->post('ck');
        $stringToFinalReturn='';
        $stringReturned=' where';
        if($group!=-1)
        {
        	if($exclude_group!='true')
        	{
             	$stringReturned.=" group_id={$group} and ";
            }
        }
        if($parent!=-1)
        {
            $stringReturned.=" parent_id={$parent} and ";
        }

        if($stringReturned!=' where')
        {
            $stringToFinalReturn=substr($stringReturned,0,strlen($stringReturned)-4);
        }

        $items=$this->ref_text_model->search_ref_text($stringToFinalReturn);
    
     	$str='';
     	if($items)
     	{
     		foreach($items as $item)
     		{
     			$str.="<li class='list-group-item' id={$item->id}>";
     			$str.="<input type='hidden' name='hdn_rid[]' value='{$item->id}'/>" ;
     			$str.="<span class='fa fa-arrows-v'></span>&nbsp;&nbsp;&nbsp;$item->name</li>";
     		}
     	}
     	$str.="<br/><button type='submit' name='btn' class='btn btn-info'><i class='fa fa-save'></i>&nbsp;Save</button>";
     	echo $str;

	}

	function save_order()
	{
		$ref_id=$this->input->post('hdn_rid');
		//$data=array();
		if(count($ref_id)>0)
		{

			$i=1;
			foreach ($ref_id as $rid)
			{
				$data=array('serial'=>$i);
				$this->ref_text_model->update_ref_text($rid,$data);
				$i++;
			}

			$this->session->set_flashdata('success', 'new order saved successfully!');
			redirect(base_url().'admin/order_ref_text');
		}
	}

	function get_text_by_group()
	{
		$groupid=$this->input->post('groupid');
		$ref_text=$this->ref_text_model->get_ref_text_by_group($groupid);
		$str='';
		$str.="<option value='-1'>Select Parent(If Any)</option>";
		if($ref_text)
		{
			foreach($ref_text as $rt)
			{
				$str.="<option value='{$rt->id}'>{$rt->name}</option>";
			}
		}
		echo $str;

	}
}

/* End of file order_ref_text.php */
/* Location: ./application/controllers/admin/order_ref_text.php */