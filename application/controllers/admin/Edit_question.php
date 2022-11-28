<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit_question extends CI_Controller {

  var $userid=0;
  var $utype=0;
  var $email='';
  var $username='';
  var $msg='';

	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->helper('form');
	    $this->load->helper('message');
	    $this->load->model('question_bank_model');
	    $this->load->model('ref_text_model');
	    $this->load->helper('common');
	    $this->load->library('ckeditor');
	    $this->load->library('my_validation');
      $this->load->model('exam_model');

      if($this->session->userdata('userid'))
      {
          $this->userid=$this->session->userdata('userid');
          $this->utype=$this->session->userdata('utype');
          $this->email=$this->session->userdata('email');
          $this->username=$this->session->userdata('username');
      }

      $roles=array('101','102');
      membership_model::is_authenticate($roles);

	    //$this->ckeditor->config['toolbar']=array(array( 'Image', 'Link', 'Unlink', 'Anchor','Underline','Subscript','Superscript','seperator','cans','Source' )); 
	    $this->ckeditor->config['height']='80px';
	    $this->id=$this->uri->segment(4);
	}

	public function index()
	{
		  $id=$this->uri->segment(4);
	    $ques=$this->question_bank_model->question_by_id($id);
	    $data['ques']=$ques;
	    $data['edit_id']=$id;
	    $data['cats']=$this->ref_text_model->get_ref_text_by_group(2);

	    $data['exam_name_val']=explode(',',$ques?$ques->exam_name:'');
	    $data['sbj_val']=$ques->subject;
	    $data['chapter_group_val']=$ques?$ques->chapter_group:'';
	    $data['chapter_val']=$ques->chapter;

      $cpt_grp=$ques->chapter_group;

      $chapters=$this->ref_text_model->where(array('group_id|='=>4,'parent_id|='=>$cpt_grp))->get();

	    $data['subjects']=$this->ref_text_model->get_ref_text_by_group(3);
	    $data['chapter_group']=$this->ref_text_model->get_ref_text_by_group(6);
	    //$data['chapters']=$this->ref_text_model->get_ref_text_by_group(4);
      $data['chapters']=$chapters;
		  $data['exams']=$this->question_bank_model->ref_text_get_exam_all();
      $data['prev_exam']=$this->exam_model->get_prev_exam();
      $data['sel_prev_exam']=$this->exam_model->prev_test_by_ques($id);
    
  		$data['title']='Edit Question';
  		$data['main_content']='admin/v_edit_question';
  		$this->load->view('layout_admin/admin_layout',$data);
	}


	 function exam_by_cat($cat_id=-1)
    {
    	$str='';
    	$exam_names=null;

    	if($cat_id!=-1)
    	{
    		$exam_names=$this->ref_text_model->get_ref_text_by_parent($cat_id);
    		 $str.="<option value='-1'>-Select Exam Name-</option>";
	        if($exam_names!=null)
	        {
	        	foreach($exam_names as $exam)
		        {
		            $str.="<option value='{$exam->id}'>{$exam->name}</option>";
		        }
	    	}
	       
	        return $str;
    	}
    	if(isset($_POST['eid']))
    	{
	    	$cid=$this->input->post('eid');
	        $exam_names=$this->ref_text_model->get_ref_text_by_parent($cid);
	         $str.="<option value='-1'>-Select Exam Name-</option>";
	        if($exam_names!=null)
	        {
	        	foreach($exam_names as $exam)
		        {
		            $str.="<option value='{$exam->id}'>{$exam->name}</option>";
		        }
	    	}
	       
	        echo $str;
        }
    }

    function update_question()
    {
        $exam_name='';
        if($this->input->post('ddl_exam_name'))
        {
         $exam_name=implode(',',$this->input->post('ddl_exam_name'));
        }
        $exam_cat=$this->input->post('ddl_exam_cat');
        $subject=$this->input->post('ddl_subject');
        $chapter_group=$this->input->post('ddl_chapter_group');
        $chapter=$this->input->post('ddl_chapter');
        $question=$this->input->post('txt_ques');
        $options=$this->input->post('txtoptions');
        $inserted_from_ip=$this->get_client_ip();
        $question_by='';
        $display=$this->input->post('ck_display');
        $is_prev=$this->input->post('ck_prev');
        $has_para=$this->input->post('ck_has_para');
        $hint=$this->input->post('txt_hints');
        $grade=$this->input->post('rd_grade');
        $question_source=$this->input->post('txt_source');
        $tags=$this->input->post('txt_tag');
        $period=$this->input->post('ddl_period');
        $is_changeable=$this->input->post('ck_changeable');

        // $rules=array('ddl_subject|Subjects'=>'min:0',
        //     'ddl_chapter_group|Chapter Group'=>'min:0',
        //     'txt_ques|Question'=>'required',
        //     'txtoptions|Options'=>'required');
        
        $rules=array('ddl_subject|Subjects'=>'min:0',
            'txt_ques|Question'=>'required',
            'txtoptions|Options'=>'required');
         
         if($this->my_validation->validate($_POST,$rules))
         {

               $id=$this->input->post('hdn_edit_id');
                $data=array(
                      //'exam_name'=>$exam_name,
                      'subject'=>$subject,
                      'chapter_group'=>$chapter_group,
                      'chapter'=>$chapter,
                      'question'=>$question,
                      'hints'=>$hint,
                      //'inserted_from_ip'=>$inserted_from_ip,
                      //'question_by'=>$question_by,
                      //'display'=>$display,
                      //'is_prev'=>$is_prev,
                      'options'=>$options,
                      'has_paragraph'=>$has_para,
                      'question_grade'=>$grade,
                      'question_source'=>$question_source,
                      //'tags'=>$tags,
                      //'period'=>$period,
                      'is_changeable'=>$is_changeable,
                      'updated_at'=>date('Y-m-d H:i:s')
                      );
             
            
             $this->question_bank_model->question_update($id,$data);  
             $this->save_to_exam_question($id);
             $this->session->set_flashdata('success','successfully updated!');
              redirect(base_url()."admin/question_bank/index");
              }
              else
              {
                $msg=$this->my_validation->errors;
                $this->session->set_flashdata('msg',$msg);
                redirect(base_url()."admin/edit_question/index/{$edit_id}");
              }
                   
    }



    function save_to_exam_question($qid)
    {
        $is_prev=$this->input->post('ck_prev');
        if($is_prev)
        {

            $prev_exam=$this->input->post('ddl_exam_name');
            foreach ($prev_exam as $pxm) {
                $data=array('exam_id'=>$pxm,'ques_id'=>$qid);
                if(exam_model::is_assigned($pxm))
                {
                    $assigned_question=$this->exam_model->get_exam_question($pxm)->ques_id;
                    $ass_ques_arr=explode(',',$assigned_question);
                    array_push($ass_ques_arr,$qid);
                    $ass_ques_str=implode(',',$ass_ques_arr);

                    $data_update=array('ques_id'=>$ass_ques_str);

                    $this->exam_model->update_assigned_question($pxm,$data_update);
                }
                else
                {
                     $this->exam_model->assign_ques($data);
                }
            }

        }
    }
    
         /**
    * [getting client ip]
    * @return [string] [ip]
    */
    function get_client_ip() {
        $ip='';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    } 

}

