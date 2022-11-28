<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question_management extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('message');
        $this->load->model('question_bank_model');
		$this->load->helper('url');
		$this->load->helper('form');
    }
	 public function index()
    {
        $data['title']='<i class="icon-plus" style="color:#999 !important;"></i>&nbsp;Question Management';
        $data['exams']=$this->question_bank_model->ref_text_get_exam_all();
        $data['main_content']='admin/question_management_view';
        $this->load->view('layout_admin/admin_layout',$data);
    }
	
	public function set_comprehesion()
	{
		$title=$this->input->post('title');
		$description=$this->input->post('des');
		$exam_ctg=$this->input->post('ctg');
		$exam_name=$this->input->post('e_name');
		$subject=$this->input->post('subject');
		$chapter=$this->input->post('chapter');
		$module=$this->input->post('module');
		$data=array(
		'exam_category'=>$exam_ctg,
		'exam_name'=>$exam_name,
		'subject'=>$subject,
		'chapter'=>$chapter,
		'title'=>$title,
		'module'=>$module,
		'description'=>$description
		);
		$this->question_bank_model->add_comprehension($data);
	
	}
	public function add_question()
	{
		$md=$this->input->post('moduleName');
		$exam_cat=$this->input->post('ddl_exam');
        $exam_name=$this->input->post('ddl_exam_name');
        //$period=$this->input->post('ddl_period');
        $subject=$this->input->post('ddl_subject');
        $chapter=$this->input->post('ddl_chapter');
        $marks_carry=$this->input->post('txt_marks');
        $question=$this->input->post('txt_ques');
        $options=$this->input->post('txtoptions');
        $inserted_from_ip='';
        $question_by='';
        $display=$this->input->post('ck_display');
        $is_prev=$this->input->post('ck_prev');
		
		$data=array('exam_cat'=>$exam_cat,
        'exam_name'=>$exam_name,
      //  'period'=>$period,
        'subject'=>$subject,
        'chapter'=>$chapter,
        'marks_carry'=>$marks_carry,
        'question'=>$question,
        'inserted_from_ip'=>$inserted_from_ip,
        'question_by'=>$question_by,
        'display'=>$display,
        'is_prev'=>$is_prev,
     'options'=>$options);
		$this->question_bank_model->add_question($data);
	}
}
?>