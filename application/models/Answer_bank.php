<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Answer_bank extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
			$this->load->helper('url');
		$this->load->helper('form');
        $this->load->helper('message');
        $this->load->model('question_bank_model');
        $this->load->model('ref_text_model');
    }
    public function index()
    {

        $data['ques']=$this->create_question_list(0,10,'');
        $data['title']='<i class="icon-plus" style="color:#999 !important;"></i>&nbsp; Question Bank';
        $data['exams']=$this->question_bank_model->ref_text_get_exam_all();
        $data['main_content']='admin/v_question_bank';
        $this->load->view('layout_admin/admin_layout',$data);
    }

    private function create_question_list($start,$limit,$key)
    {
        $questions=$this->question_bank_model->question_get_all($start,$limit,$key);
        $str='';
if(!empty($questions))
{		
        foreach($questions as $q){
            $examcat='No Category';
            $exname='N/A';
            $subject='N/A';
            $chapter='N/A';
            if($this->ref_text_model->get_ref_text_by_id($q->exam_cat)){
                $examcat=$this->ref_text_model->get_ref_text_by_id($q->exam_cat)->name;}

            if($this->ref_text_model->get_ref_text_by_id($q->exam_name)){
                $exname=$this->ref_text_model->get_ref_text_by_id($q->exam_name)->name;}

            if($this->ref_text_model->get_ref_text_by_id($q->subject)){
                $exname=$this->ref_text_model->get_ref_text_by_id($q->subject)->name;}

            if($this->ref_text_model->get_ref_text_by_id($q->chapter)){
                $exname=$this->ref_text_model->get_ref_text_by_id($q->chapter)->name;}
            $str.='<tr>';
            $str.="<td>{$examcat}</td>";
            $str.="<td>{$exname}</td>";
            $str.="<td>{$subject}</td>";
            $str.="<td>{$chapter}</td>";
            $str.="<td>{$q->period}</td>";
            $str.="<td>{$q->question}</td>";
            $str.="<td><span class='ttp' data-toggle='tooltip' data-placement='top' title='Add Answers'>
            <a href='".base_url()."admin/ans_option/index/{$q->id}' id='add_ans' role='button' data-target='#add_ans_dlg' data-toggle='modal' data-dismiss='modal'><i class='icon-plus-sign'></i></a></span></td>";
            $str.="<td><a href='".base_url()."admin/question_bank/editQuestion/{$q->id}' class='ttp' data-toggle='tooltip' data-placement='top' title='Edit'><i class='icon-edit'></i></a></td>";
            $str.="<td><a href='".base_url()."admin/question_bank/deletequestion/{$q->id}'class='ttp' data-toggle='tooltip' data-placement='top' title='Delete'><i class='icon-trash'></i></a></td>";
            $str.='</tr>';
        }
        return  $str;
}
else{
echo"No question found";
}   
   }
	public function  editQuestion()
	{
		$qid=$this->uri->segment(4);
		$data['title']='<i class="icon-plus" style="color:#999 !important;"></i>&nbsp;Edit Question';
		$data['query']=$this->question_bank_model->question_by_id($qid);
		print_r($data);
		$data['main_content']='admin/v_edit_answer';
        $this->load->view('layout_admin/admin_layout',$data);
	}
	
	public function deletequestion()
	{
	$qid=$this->uri->segment(4);
	$this->question_bank_model->question_delete($qid);
	
	}
	
}
	
	