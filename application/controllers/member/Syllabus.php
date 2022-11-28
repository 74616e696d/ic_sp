<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Syllabus extends Member_controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('instruction_model');
		$this->load->model('ref_text_model');
	}

	public function index()
	{
		$data['exams']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['title']='Syllabus';
		$this->load->blade('member.syllabus.index', $data);
	}

	function load_syllabus()
	{
		$ref_id=$this->input->post('eid');
		$syllabus=$this->get_syllabus($ref_id);
		echo $syllabus;
	}

	function get_syllabus($refid)
	{
		$ins=$this->instruction_model->get_published_instructions($refid);
		$str="";
		if($ins)
		{
			$str.="<div>";
			$str.="<h4>Apply Instructions</h4>";
			$str.="<div>{$ins->details}</div>";
			$str.="</div>";

			$str.="<div>";
			$str.="<h4>Syllabus</h4>";
			$str.="<div>{$ins->syllabus}</div>";
			$str.="</div>";

			$str.="<div>";
			$str.="<h4>How To Prepare</h4>";
			$str.="<div>{$ins->hwprepare}</div>";
			$str.="</div>";
		}
		else
		{
			$str.="<div>No Syllabus Found!!</div>";
		}
		return $str;
	}


	function bcs()
	{
		$data['title']='BCS Guideline';
		$this->load->blade('member.syllabus.bcs', $data);
	}

	function bank()
	{
		$data['title']='Bank Recuitment Guideline';
		$this->load->blade('member.syllabus.bank', $data);
	}

	function bcs_written()
	{
		$data['title']='BCS Written Guideline';
		$this->load->blade('member.syllabus.bcs_written', $data);
	}

	function mba()
	{
		$data['title']='MBA Guideline';
		$this->load->blade('member.syllabus.mba', $data);
	}

	function nibondhon()
	{
		$data['title']='বেসরকারি শিক্ষক নিবন্ধন Guideline';
		$this->load->blade('member.syllabus.nibondhon', $data);
	}

}

/* End of file syllabus.php */
/* Location: ./application/controllers/member/syllabus.php */