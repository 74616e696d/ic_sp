<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_info extends Admin_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('company_model');
	}
	public function index()
	{
		$data['title']='Company Info';
		$this->load->blade('admin.companyinfo.index', $data);
	}

	function company_info_dt()
	{
		 $length=20;
		 $term='';
		 $search=$_POST['search']['value'];
		 $filterStr='';
		 if($search){
		     $search_terms=json_decode($search);
		     $searchStr=' where';
		     if(!empty($search_terms->company))
		     {
		         $searchStr.=" company_name like '%{$search_terms->company}%' and ";
		     }

		     if($searchStr!=' where')
		     {
		         $term.=substr($searchStr,0,strlen($searchStr)-4);
		     }
		     $filterStr=$term;
		 }
		 $term.=" order by id desc";
		 $no = $_POST['start'];
		 $term.=" limit {$no},{$length}";
		$list = $this->company_model->get_info($term);
		
		$data = array();
		if($list)
		{
		    foreach($list as $item) 
		    {
		        $no++;
		        $row = array();
		        $row[] =$no;
		        $logo_tag='';
		        if(file_exists('asset/job/'.$item->logo))
		        {
		        	$logo=base_url().'asset/job/'.$item->logo;
		        	$logo_tag="<img width='45' src='{$logo}' alt=''/>";

		        }
		        $row[] =$logo_tag.' '.$item->company_name;
		        $row[] = $item->email;
		        $row[] = $item->web;
		        $row[]=$item->address;

		        $edit_url=base_url().'admin/company_info/edit/'.$item->id;
		        $action = "<a class='btn btn-small btn-primary' title='Edit' href='{$edit_url}'><i class='fa fa-edit'></i></a>";

		        $delete_url=base_url().'admin/company_info/delete/'.$item->id;
		        $action.=" <a onclick='return(confirm(\"Are you sure to delete?\"))' class='btn btn-small btn-danger' href='{$delete_url}' title='Delete'><i class='fa fa-trash-o'></i></a>";

		        $row[]=$action;

		        $data[] = $row;
		    }
		}
		$total=$this->company_model->count_all();
		$total_filtered=$this->company_model->count_all($filterStr);
		$output = array(
		                "draw" => $_POST['draw'],
		                "recordsTotal" =>$total ,
		                "recordsFiltered" => $total_filtered,
		                "data" => $data,
		        );
		//output to json format
		echo json_encode($output);
	}

	function create()
	{
		$data['title']='Add New Company';
		$this->load->blade('admin.companyinfo.create', $data);
	}

	function store()
	{
		$company_name=$this->input->post('txt_company_name');
		$email=$this->input->post('txt_email');
		$web=$this->input->post('txt_web');
		$address=$this->input->post('txt_address');
		$logo=$this->input->post('txt_logo');
		$active=$this->input->post('ck_active');
		if(!empty($company_name))
		{
			$data=[
			'company_name'=>$company_name,
			'email'=>$email,
			'web'=>$web,
			'address'=>$address,
			'logo'=>$logo,
			'active'=>$active
			];

			$this->company_model->create($data);
			$this->session->set_flashdata('success', 'Company added successfully !');
			redirect(base_url().'admin/company_info');
		}
		else
		{
			$this->session->set_flashdata('error', 'Company name required !');
			redirect(base_url().'admin/company_info/create');
		}
	}

	function edit()
	{
		$id=$this->uri->segment(4);
		$data['company']=$this->company_model->find($id);
		$data['title']='Edit Company Info';
		$this->load->blade('admin.companyinfo.edit', $data);
	}

	function update()
	{
		$id=$this->input->post('hdn_id');
		$company_name=$this->input->post('txt_company_name');
		$email=$this->input->post('txt_email');
		$web=$this->input->post('txt_web');
		$address=$this->input->post('txt_address');
		$logo=$this->input->post('txt_logo');
		$active=$this->input->post('ck_active');
		if(!empty($company_name))
		{
			$data=[
			'company_name'=>$company_name,
			'email'=>$email,
			'web'=>$web,
			'address'=>$address,
			'logo'=>$logo,
			'active'=>$active
			];

			$this->company_model->update($id,$data);
			$this->session->set_flashdata('success', 'Company updated successfully !');
			redirect(base_url().'admin/company_info');
		}
		else
		{
			$this->session->set_flashdata('error', 'Company name required !');
			redirect(base_url().'admin/company_info/edit/'.$id);
		}
	}

	function delete()
	{
		$id=$this->uri->segment(4);
		$this->company_model->delete($id);
		$this->session->set_flashdata('success', 'Successfully Deleted !');
		redirect(base_url().'admin/company_info/index');
	}

}

/* End of file company_info.php */
/* Location: ./application/controllers/admin/company_info.php */