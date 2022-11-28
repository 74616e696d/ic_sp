<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * controller to manage expert user profile
 */
class Profile extends Expert_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('expert_user_model');
		$this->load->model('expert_details_model');
		$this->load->model('expert_education_model');
		$this->load->model('expert_tags_model');
	}

	public function index()
	{

		$data['user_details']=$this->expert_details_model->find($this->userid);
		$data['title']='Manage Your Profile';
		$this->load->blade('profile.index', $data);
	}

	/**
	 * modal page for new education
	 * 
	 * @return void
	 */
	function new_education()
	{
		$data['title']='';
		$this->load->blade('profile.new_education', $data);
	}

	/**
	 * autocomplete search tags from 
	 * @return void
	 */
	function get_tags()
	{
		$term=$this->input->post('term');
		echo $this->expert_tags_model->tags($term);
	}

	/**
	 * save expert tags
	 * @return void
	 */
	function save_tags()
	{
		$tag=$this->input->post('tag');
		if(!empty($tag))
		{
			if(!$this->expert_tags_model->exist('name',$tag))
			{
				$data=['name'=>$tag,'user_id'=>$this->userid];
				$this->expert_tags_model->create($data);
			}
		}
		echo "Tag created !";
	}


	/**
	 * get expert tags by ajax request
	 *
	 * @return  void
	 */
	function get_expert_tags()
	{
		$tags=$this->expert_tags_model->all_by('user_id',$this->userid);
		$str='';
		if($tags)
		{
			foreach ($tags as $tag) {
				$str.="<li>";
				$str.="<div class='row'>";
				$str.="<div class='col-xs-9 text-center'>";
				$str.=$tag->name;
				$str.="</div>";

				$str.="<div class='col-xs-3'>";
				$str.="<btn class='btn btn-sm btn-success btn-icon'><i class='fa fa-times'></i></btn>";
				$str.="</div>";
				$str.="</div>";
				$str.="</li>";
			}
		}
		echo $str;
	}

	/**
	 * show education page
	 * 
	 * @return void
	 */
	function save_education()
	{
		$user_id=$this->userid;
		$degree=$this->input->post('degree');
		$major_topics=$this->input->post('major_topics');
		$result=$this->input->post('result');
		$institution=$this->input->post('institution');
		$passing_year=$this->input->post('passing_year');
		if(!empty($degree) && !empty($user_id)){
			$data=['user_id'=>$user_id,
			'degree'=>$degree,
			'result'=>$result,
			'passing_year'=>$passing_year,
			'institution'=>$institution,
			'major_topics'=>$major_topics
			];

			$this->expert_education_model->create($data);
			echo "Saved successfully !";
		}else{
			echo "Degree must be given !";
		}
	}

	/**
	 * get expert education details via ajax request
	 * 
	 * @return void
	 */
	function get_education_details()
	{
		$data=$this->expert_education_model->all_by('user_id',$this->userid);
		$str="<table class='table table-striped'>";
		$str.="<thead>";
		$str.="<tr>";
		$str.="<th>Degree Name</th>";
		$str.="<th>Institution/University</th>";
		$str.="<th>Major Topics</th>";
		$str.="<th>Result</th>";
		$str.="<th>Passing Year</th>";
		$str.="<th></th>";
		$str.="</tr>";
		$str.="</thead>";
		$str.="<tbody>";
		if($data)
		{
			foreach ($data as $row) {
				$str.="<tr>";
				$str.="<td>{$row->degree}</td>";
				$str.="<td>{$row->institution}</td>";
				$str.="<td>{$row->major_topics}</td>";
				$str.="<td>{$row->result}</td>";
				$str.="<td>{$row->passing_year}</td>";
				$str.="<td>";
				$edit_url=base_url().'expert/profile/edit_education/'.$row->id;
				// $delete_url=base_url().'expert/profile/delete_education/'.$row->id;
				$str.="<a href='{$edit_url}' data-toggle='modal' data-target='#editEducationModal' title='Edit Education' role='button' class='text-info'><i class='fa fa-edit'></i></a>";

				$str.="<a href='' data-id='{$row->id}' class='btnDeleteEdu'><i class='fa fa-trash'></i></a>";
				
				$str.="</td>";
				$str.="</tr>";
			}
		}
		else{
			$str.="<tr>";
			$str.="<td colspan='5'>No Education Found !</td>";
			$str.="</tr>";
		}
		$str.="</tobdy>";
		$str.="</table>";

		echo $str;
	}

	/**
	 * display edit education modal dialog
	 * @return void
	 */
	function edit_education()
	{
		$id=$this->uri->segment(4);
		$data['education']=$this->expert_education_model->find($id);
		$this->load->blade('profile.edit_education', $data);
	}

	/**
	 * update expert education
	 * @return void
	 */
	function update_education()
	{
		$id=$this->input->post('id');
		$userid=$this->userid;
		$degree=$this->input->post('degree');
		$major_topics=$this->input->post('major_topics');
		$result=$this->input->post('result');
		$institution=$this->input->post('institution');
		$passing_year=$this->input->post('passing_year');
		if(!empty($degree)){
			$data=[
			'degree'=>$degree,
			'result'=>$result,
			'passing_year'=>$passing_year,
			'institution'=>$institution,
			'major_topics'=>$major_topics
			];

			$this->expert_education_model->update_education($id,$userid,$data);
			echo "Updated successfully !";
		}else{
			echo "Degree must be given !";
		}
	}

	/**
	 * delete expert education details
	 * 
	 * @return void
	 */
	function delete_education()
	{
		$id=$this->input->post('id');
		$this->expert_education_model->delete_education($id,$this->userid);
		echo "Education details removed successfully !";
	}

}

/* End of file profile.php */
/* Location: ./application/modules/expert/controllers/profile.php */