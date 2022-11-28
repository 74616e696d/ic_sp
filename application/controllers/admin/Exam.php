<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exam extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('message');
		$this->load->model('exam_model');
		$this->load->model('ref_text_model');
	}
	public function index()
	{
		$data['exam_cat']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['title']='Manage Exam';
		$this->load->blade('admin.v_exam', $data);
	}


	
	/**
	 * exam list for datatables
	 * @return json
	 */
	function exam_list_dt()
    {
       $length=$_POST['length'];
       $term='';
       $search=$_POST['search']['value'];
       $filterStr='';
       if($search){
           $search_terms=json_decode($search);
           $searchStr=' where';
           if(!empty($search_terms->exam_cat))
           {
               $searchStr.=" exam_cat={$search_terms->exam_cat} and ";
           }
           if(!empty($search_terms->exam_name))
           {
               $searchStr.=" test_name='{$search_terms->exam_name}' and ";
           }
       
           if($searchStr!=' where')
           {
               $term.=substr($searchStr,0,strlen($searchStr)-4);
           }
           $filterStr=$term;
       }

       $no = $_POST['start'];
      $list = $this->exam_model->get_exams($no,$length,$term);
      
      $data = array();
      if($list)
      {
          foreach($list as $item) 
          {
          	  $ecat=ref_text_model::get_text($item->exam_cat);
          	  $etype='';
          	  //$etype=ref_text_model::get_text($e->test_type);
          	  if($item->test_type==15)
          	  {
          	  	$etype='Model Test';
          	  }
          	  else if($item->test_type==16)
          	  {
          	  	$etype='Previous Test';
          	  }
          	  $edit_url=base_url().'admin/exam/edit_view/'.$item->id;
          	  $delete_url=base_url().'admin/exam/delete/'.$item->id;
              $no++;
              $row = array();
              $row[]=$no;
              $row[] = $ecat;
              $row[] = $etype;
              $row[] = $item->test_name;
              $str="<td><a href='{$edit_url}' id='edit_exam' role='button' data-toggle='modal' data-target='#edit_dlg' class='btn btn-info btn-mini'><i class='icon icon-edit icon-white'></i>&nbsp;Edit</a>&nbsp;&nbsp;&nbsp;";
              $str.="<a href='{$delete_url}' onclick='return(confirm(\"are you sure to delete?\"));' class='btn btn-info btn-mini'><i class='icon icon-trash icon-white'></i>&nbsp;Delete</a></td>";

              $row[]=$str;

              $data[] = $row;
          }
      }
      $total=$this->exam_model->get_total();
      $total_filtered=$this->exam_model->get_total($filterStr);
      $output = array(
                      "draw" => $_POST['draw'],
                      "recordsTotal" =>$total ,
                      "recordsFiltered" => $total_filtered,
                      "data" => $data,
              );
      //output to json format
      echo json_encode($output);
    }

	function edit_view()
	{
		$data['exam_cat']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['test_types']=$this->ref_text_model->get_ref_text_by_group(7);	
		$id=$this->uri->segment(4);
		$exam=$this->exam_model->find($id);
		$data['exam']=$exam;
		$this->load->view('admin/v_edit_exam',$data);
	}

	function edit()
	{
		$id=$this->input->post('hdn_id');
		$exam_cat=$this->input->post('ddl_exam_cat');
		$subject=implode(',',$this->input->post('ck_subj'));
		$test_type=$this->input->post('ddl_test_type');
		$test_name=$this->input->post('txt_test_name');
		$negative_marks=$this->input->post('txt_neg_marks');
		$marks_carry=$this->input->post('txt_mark_carry');
		$total_marks=$this->input->post('txt_total_marks');
		$total_ques=$this->input->post('txt_total_ques');
		$weight=$this->input->post('txt_weight');
		$total_time=$this->input->post('txt_total_time');
		$data=array('exam_cat'=>$exam_cat,
			'test_type'=>$test_type,
			'test_name'=>$test_name,
			'negative_marks'=>$negative_marks,
			'mark_carry'=>$marks_carry,
			'total_marks'=>$total_marks,
			'weight'=>$weight,
			'total_ques'=>$total_ques,
			'total_time'=>$total_time
			);
		if($exam_cat!=-1)
		{
			if($test_type!=-1)
			{
				if(!empty($test_name))
				{
					$this->exam_model->update($id,$data);
					$this->session->set_flashdata('success', 'successfully updated!');
					redirect(base_url().'admin/exam');
				}
				else
				{
					$this->session->set_flashdata('warning', 'test name cannot be empty!');
					redirect(base_url().'admin/exam');
				}
			}
			else
			{
				$this->session->set_flashdata('warning', 'test type must be selected!');
				redirect(base_url().'admin/exam');
			}
		}
		else
		{
			$this->session->set_flashdata('warning', 'exam category must be selected!');
			redirect(base_url().'admin/exam');
		}
	}

	function delete()
	{
		$id=$this->uri->segment(4);
		$this->exam_model->delete($id);
		$this->session->set_flashdata('success', 'successfully deleted!');
		redirect(base_url().'admin/exam');
	}

}

/* End of file exam.php */
/* Location: ./application/controllers/admin/exam.php */