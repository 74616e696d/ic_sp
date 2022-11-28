<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_syllabus extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
	
		$this->load->model('syllabus_model');
		$this->load->model('ref_text_model');
		$this->load->helper('message');
		$this->load->library('my_validation');
	}

	public function index()
	{
		$data['syllabus']=$this->syllabus_list(0,10,'');
		$data['title']='Manage Syllabus';
		$data['main_content']='admin/v_manage_syllabus';
		$this->load->view('layout_admin/admin_layout', $data);
	}


	function syllabus_list($start,$limit,$key)
	{
		$syllabus=$this->syllabus_model->all_with_page($start,$limit,$key);
		$str='';
		foreach ($syllabus as $s) 
		{
			$exam_text=ref_text_model::get_text($s->exam_id);
			$sbj_text=ref_text_model::get_text($s->subject_id);
			$str.="<tr>";
			$str.="<td>{$exam_text}</td>";
			$str.="<td>{$sbj_text}</td>";
			$str.="<td><span class='more'>{$s->details}</span></td>";
			$str.="<td><a class='btn btn-info btn-mini' href=''><i class='icon icon-edit icon-white'></i>&nbsp;Edit</a>
			<a onclick='return(confirm(\"are you sure to delete?\"));' class='btn btn-info btn-mini' href=''><i class='icon icon-trash icon-white'></i>&nbsp;Delete</a></td>";
			$str.="</tr>";
		}
		return $str;
	}

}

/* End of file manage_syllabus.php */
/* Location: ./application/controllers/admin/manage_syllabus.php */