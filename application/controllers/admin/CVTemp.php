<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CVTemp extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('cvtemp_model');
	}

	public function index()
	{
		$data['cvs']=$this->cvtemp_model->all();
		$data['title']='Manage CV Template';
		$this->load->blade('admin.cv.index',$data);
	}

	function create()
	{
		$data['title']='Create CV Template';
		$this->load->blade('admin.cv.create', $data);
	}

	function store()
	{
		$name=$this->input->post('fl_name');
		$details=$this->input->post('details');
		$ck_external=$this->input->post('ck_external');
		$display=$this->input->post('display');

		// var_dump($ck_external);die();
		$filename='';
		if($ck_external){
			$filename=$this->input->post('link');
		}else{
			$filename=$this->do_upload();
		}
		if($filename=='0'){
			$this->session->set_flashdata('error', 'Unable to upload !');
			redirect(base_url().'admin/cvtemp/create');
		}
		else{
			$data=[
			'name'=>$name,
			'details'=>$details,
			'file_name'=>$filename,
			'is_external'=>$ck_external,
			'display'=>$display
			];
			$this->cvtemp_model->create($data);
			$this->session->set_flashdata('success', 'CV Template uploaded successfully');
			redirect(base_url().'admin/cvtemp/index');
		}
		
	}


	function edit()
	{
		$id=$this->uri->segment(4);
		$data['cv']=$this->cvtemp_model->find($id);
		$data['title']='Edit CV Template';
		$this->load->blade('admin.cv.edit', $data);
	}

	function cover_letter($id)
	{
		$data['cv']=$this->cvtemp_model->find($id);
		$data['title']='';
		$this->load->blade('admin.cv.cover_letter', $data);
	}

	function upload_cover_letter()
	{
		$id=$this->input->post('hdn_id');
		$ck_external=$this->input->post('ck_external');
		// var_dump($ck_external);die();
		$filename='';
		if($ck_external){
			$filename=$this->input->post('link');
		}else{
			$filename=$this->do_upload();
		}
		if($filename=='0'){
			$this->session->set_flashdata('error', 'Unable to upload !');
			redirect(base_url().'admin/cvtemp/index');
		}
		else{
			$data=[
			'cover_letter'=>$filename,
			'cover_external'=>$ck_external,
			];
			$this->cvtemp_model->update($id,$data);
			$this->session->set_flashdata('success', 'Cover Letter added successfully');
			redirect(base_url().'admin/cvtemp/index');
		}
	}

	function details()
	{
		$data['details']=$this->cvtemp_model->get_details();
		$data['title']='';
		$this->load->blade('admin.cv.details', $data);
	}

	function save_details()
	{
		$id=$this->input->post('hdn_id');
		$details=$this->input->post('details');
		$link=$this->input->post('video_link');
		$this->cvtemp_model->save_details($details,$link,$id);
		$this->session->set_flashdata('success', 'Details  saved successfully');
		redirect(base_url().'admin/cvtemp/index');
	}


	function do_upload()
	{
		$config['upload_path'] = './asset/cv/';
		$config['allowed_types'] = 'docx|doc|pdf';
		$config['max_size']	= '1500';
		$date=date('dmYHis');
		$config['file_name']	= "studypress_cv_".$date;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			return 0;
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			return $data['upload_data']['orig_name'];
		}
	}

	function delete($id,$file,$external)
	{
		if($external)
		{
			$this->cvtemp_model->delete($id);
			$this->session->set_flashdata('success', 'CV Template deleted successfully');
			redirect(base_url().'admin/cvtemp/index');
		}
		else
		{
			if(file_exists('asset/cv/'.$file))
			{
				unlink('asset/cv/'.$file);
			}
			// if(file_exists('asset/cv/'.$file))
			// {
			// 	echo "Hhi there";
			// 	unlink('asset/cv/'.$file);
			// }
			$this->cvtemp_model->delete($id);
			$this->session->set_flashdata('success', 'CV Template deleted successfully');
			redirect(base_url().'admin/cvtemp/index');
		}
	}

}

/* End of file CVTemp.php */
/* Location: ./application/controllers/admin/CVTemp.php */