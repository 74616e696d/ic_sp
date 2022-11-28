<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_comprehension extends Admin_Controller {

	public $editor=array();
	public function __construct()
	{
		parent::__construct();
		$this->load->library('ckeditor');

		$this->load->model('question_bank_model');
        $this->load->model('ref_text_model');
        $this->load->model('manage_comprehension_model');
        $this->load->helper('message');

	}


	public function index()
	{
        $data['comp_list']=$this->comprehension_list(0,100,'');
		$data['title']='Manage Comprehension';
		$data['main_content']='admin/v_manage_comprehension';
		$this->load->view('layout_admin/admin_layout',$data);
	}



    function comprehension_list($start,$limit,$key)
    {
        $lists=$this->manage_comprehension_model->get_list($start,$limit,$key);
        $str='';
        if($lists)
        {
            foreach ($lists as $l) 
            {
                $ques=explode(',',$l->question_id);
                $ques_arr=array();
                foreach ($ques as $q) 
                {
                    array_push($ques_arr,question_bank_model::ques_text($q));
                }

                //$ques_str=implode('<br/>',$ques_arr);
                $edit_url=base_url().'admin/manage_comprehension/edit_view/'.$l->id;
                $delete_url=base_url().'admin/manage_comprehension/remove/'.$l->id;
                $assign_url=base_url().'admin/ques_to_comprehension/index/'.$l->id;
                $edit_assigned=base_url().'admin/ques_to_comprehension/edit_assigned_view/'.$l->id;
                $str.="<tr>";
                    $str.="<td><span>{$l->title}</span></td>";
                    $str.="<td id='middle'><span class='more'>{$l->details}</span></td>";
                    $str.="<td><a href='{$assign_url}' role='button' data-target='#assign_dlg' data-toggle='modal' data-dismiss='modal' class='btn btn-default' href=''><i class='fa fa-save'></i>&nbsp;Assign</a>&nbsp;";
                    $str.="<a href='{$edit_assigned}' role='button' data-target='#edit_assign_dlg' data-toggle='modal' data-dismiss='modal' class='btn btn-default' href=''><i class='fa fa-edit'></i>&nbsp;Edit Assigned Question</a>";
                    $str.="<br/><a class='btn btn-default' href='{$edit_url}'><i class='fa fa-edit'></i>&nbsp;Edit</a>&nbsp;";
                   $str.="<a class='btn btn-default' onclick='return(confirm(\"are you sure to delete?\"));' href='{$delete_url}'><i class='fa fa-trash-o'></i>&nbsp;Delete</a></td>";
                $str.="</tr>";
            }   
        }
       
        return $str;
    }

	function add_comprehension()
	{
        $data['exam_cats']=$this->ref_text_model->get_ref_text_by_group(2);
        $data['subjects']=$this->ref_text_model->get_ref_text_by_group(3);
		$data['exams']=$this->question_bank_model->ref_text_get_exam_all();
		$data['title']='Add Comprehension';
		$data['ck_editor']=$this->editor;
		$data['main_content']='admin/v_add_comprehension.php';
		$this->load->view('layout_admin/admin_layout',$data);
	}

	function get_exam_ques()
	{
		$subj_id=-1;
		if($this->input->post('eid'))
		{
			$subj_id=$this->input->post('eid');
		}
		$questions=$this->question_bank_model->get_ques_by_chapter($subj_id);
		$str="";
        $str.="<label>Questions List:</label>";
        $str.="<input type='text' id='qsearch' placeholder='Quick Search'/>";
        $str.="<div class='ck_list'>";
        $str.="<ul>";
        if($questions)
        {
            foreach ($questions as $q) 
            {
                $ques=strip_tags($q->question,'img');
                $str.="<label for='ck_ques_{$q->id}'>
                <input style='float:left;margin-right:4px;' class='ck_cat' id='ck_ques_{$q->id}' type='checkbox' name='ck_ques[]' value='{$q->id}'/>{$ques}</label>";
            }
        } 
        $str.="</ul>";
        $str.="</div>";
		echo $str;
	}

    function get_subjects()
    {
        $eid=$this->input->post('eid');
        $subjects=$this->ref_text_model->get_exam_wise_subject($eid);
        $str='';
        $str.="<option value='-1'>Select Subject</option>";
        if($subjects)
        {
            foreach($subjects as $sbj)
            {
                $str.="<option value='{$sbj->id}'>{$sbj->name}</option>";
            }
        }
        echo $str;
    }

    function save()
    {
     
        $title=$this->input->post('txt_title');

        $details=$this->input->post('txt_comprehension');
        $data=array('title'=>$title,
                    'details'=>$details);
 
        if(!empty($title))
        {
            $this->manage_comprehension_model->insert($data);
            $this->session->set_flashdata('success','successfully inserted!');
           redirect(base_url().'admin/manage_comprehension');
        }
        else
        {
            $this->session->set_flashdata('warning','title cannot be empty!!');
            redirect(base_url().'admin/manage_comprehension');
        }
    }


    function edit_view()
    {
        $id=$this->uri->segment(4);
        $data['item']=$this->manage_comprehension_model->find($id);
        // $data['exams']=$this->question_bank_model->ref_text_get_exam_all();
        $data['title']='Edit Comprehension';
        $data['main_content']='admin/v_edit_comprehension';
        $this->load->view('layout_admin/admin_layout',$data);
    }

    function edit()
    {
        $id=$this->input->post('hdn_id');
        $title=$this->input->post('txt_title');
        $details=$this->input->post('txt_comprehension');
        $data=array('title'=>$title,
            'details'=>$details);
        if(!empty($title))
        {
            $this->manage_comprehension_model->update($id,$data);
            $this->session->set_flashdata('success', 'Successfully updated!');
            redirect(base_url().'admin/manage_comprehension');
        }
        else
        {
            $this->session->set_flashdata('error', 'Title cannot be empty');
            redirect(base_url().'admin/manage_comprehension/edit_view/'.$id);
        }
    }

    function remove()
    {
        $id=$this->uri->segment(4);
        $this->manage_comprehension_model->delete($id);
        $this->session->set_flashdata('success', 'Successfully deleted!');
        redirect(base_url().'admin/manage_comprehension');
    }

}

