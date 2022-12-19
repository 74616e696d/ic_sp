<?php

class Add_syllabus extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('syllabus_model');
		$this->load->model('ref_text_model');
		$this->load->library('ckeditor');
       //Ckeditor's configuration
        $this->data['ckeditor'] = array(
 
           //ID of the textarea that will be replaced
            'id'    =>'content',
           'path'  => 'js/ckeditor',
 
           //Optionnal values
            'config' => array(
            'toolbar'       =>      "Full",         //Using the Full toolbar
            'width'         =>      "550px",        //Setting a custom width
            'height'        =>      '100px',        //Setting a custom height
 
            ));

        $this->load->library('my_validation');
        $this->load->helper('message');
	}

	public function index()
	{
		$data['exams']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['subjects']=$this->ref_text_model->get_ref_text_by_group(3);
		$data['title']='Add Syllabus';
		$data['main_content']='admin/v_add_syllabus';
		$this->load->view('layout_admin/admin_layout', $data);
	}

	function add()
	{
		$exam_id=$this->input->post('ddl_exam');
		$subject_id=$this->input->post('ddl_subject');
		$details=$this->input->post('txt_details');
		$display=$this->input->post('ck_display');
		$data=array('exam_id'=>$exam_id,
			'subject_id'=>$subject_id,
			'details'=>$details,
			'display'=>$display);
		$rules=array('ddl_exam|Exam Name'=>'min:0',
			'ddl_subject|Subject'=>'min:0',
			'txt_details|Details'=>'required');
		if($this->my_validation->validate($_POST,$rules))
		{
			$this->syllabus_model->add($data);
			$this->session->set_flashdata('success', 'successfully inserted!');
			redirect(base_url().'admin/manage_syllabus');
		}
		else
		{
			$msg=$this->my_validation->errors;
			$this->session->set_flashdata('msg',$msg);
			redirect(base_url().'admin/add_syllabus');
		}
	}

}

/* End of file add_syllabus.php */
/* Location: ./application/controllers/admin/exam/add_syllabus.php */