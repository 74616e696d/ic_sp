<?php

class Add_question_manually extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('message');
        $this->load->model('question_bank_model');
        $this->load->model('ref_text_model');
        $this->load->model('exam_model');
        $this->load->model('model_test_question_model');
		$this->load->helper('url');
		$this->load->helper('form');
        $this->load->helper('common');
        $this->load->helper('directory');
        $this->load->library('ckeditor');
        $this->ckeditor->config['height']='80px';
        $this->load->library('my_validation');
        $roles=array('101','102');
        membership_model::is_authenticate($roles);
	}
	public function index()
	{
		$data['test_id']=$this->uri->segment(4);
		$data['cats']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['subjects']=$this->ref_text_model->get_ref_text_by_group(3);
		$data['chapter_group']=$this->ref_text_model->get_ref_text_by_group(6);
		$data['chapters']=$this->ref_text_model->get_ref_text_by_group(4);
		$data['prev_exam']=$this->exam_model->get_prev_exam();

		$data['title']='<i class="icon-plus" style="color:#999 !important;"></i>&nbsp;Add Question Manually';
		$data['exams']=$this->question_bank_model->ref_text_get_exam_all();
		$data['main_content']='admin/add_question_manually';
		$this->load->view('layout_admin/admin_layout',$data);	
	}


    function add()
    {
        $exam_name='aa';
        if($this->input->post('ddl_exam_name'))
        {
            $exam_name=implode(',',$this->input->post('ddl_exam_name'));
        }
        $exam_cat=$this->input->post('ddl_exam_cat');
        $subject=$this->input->post('ddl_subject');
        $question=$this->input->post('txt_ques');
        $options=$this->input->post('txtoptions');
        $has_para=$this->input->post('ck_has_para');
        $hint=$this->input->post('txt_hints');
        $inserted_from_ip=$this->get_client_ip();
        $question_by=$this->userid;
        $display=0;

        $test_id=$this->input->post('hdn_test_id');

        $rules=array('ddl_subject|Subjects'=>'min:0',
            'txt_ques|Question'=>'required',
            'txtoptions|Options'=>'required');
		
        $data=array('exam_name'=>$exam_name,
        'subject'=>$subject,
        'question'=>$question,
        'hints'=>$hint,
        'inserted_from_ip'=>$inserted_from_ip,
        'question_by'=>$question_by,
        'display'=>$display,
		'options'=>$options,
        'has_paragraph'=>$has_para,
        'created_at'=>date('Y-m-d H:i:s'));
        $save=$this->input->post('btn_save');
        $save_new=$this->input->post('btn_save_new');
      
        if($this->my_validation->validate($_POST,$rules))
        {
            $qid= $this->question_bank_model->add_question($data);
            //$this->add_to_exam_question($qid);
            $this->add_to_test_question($test_id,$qid);
            if($save)
            {
                $this->session->set_flashdata('success','Question added successfully!');
                redirect(base_url()."admin/modeltest");
            }
            if($save_new)
            {
                $this->session->set_flashdata('success','Question added successfully!');
                set_old_value($data);
                $this->session->set_flashdata('exam_cat',$exam_cat);

                redirect(base_url()."admin/add_question_manually/index/{$test_id}");
            }
        }
        else
        {
            set_old_value($data);
            $msg=$this->my_validation->errors;
            $this->session->set_flashdata('msg',$msg);
            redirect(base_url()."admin/add_question_manually/index/{$test_id}");   
        }

    }



    function add_to_test_question($test_id,$qid)
    {
    	$data=array('test_id'=>$test_id,
    		'qid'=>$qid);
    	$this->model_test_question_model->create($data);
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

/* End of file add_question_manually.php */
/* Location: ./application/controllers/admin/add_question_manually.php */