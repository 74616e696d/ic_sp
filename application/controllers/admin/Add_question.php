<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_question extends CI_Controller {
    public $editor=array();
    var $userid=0;
    var $utype=0;
    var $email='';
    var $username='';
    var $msg='';
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('message');
        $this->load->model('question_bank_model');
        $this->load->model('ref_text_model');
        $this->load->model('exam_model');
		$this->load->helper('url');
		$this->load->helper('form');
        $this->load->helper('common');
        $this->load->helper('directory');
        $this->load->library('ckeditor');
        $this->ckeditor->config['height']='80px';
        $this->load->library('my_validation');

        if($this->session->userdata('userid'))
        {
            $this->userid=$this->session->userdata('userid');
            $this->utype=$this->session->userdata('utype');
            $this->email=$this->session->userdata('email');
            $this->username=$this->session->userdata('username');
        }

        $roles=array('101','102');
        membership_model::is_authenticate($roles);

    }
    public function index()
    {
        //$data['fls']=directory_map('./asset/qimg');
        $data['cats']=$this->ref_text_model->get_ref_text_by_group(2);
        $data['subjects']=$this->ref_text_model->get_ref_text_by_group(3);
        $data['chapter_group']=$this->ref_text_model->get_ref_text_by_group(6);
        $data['chapters']=$this->ref_text_model->get_ref_text_by_group(4);
        $data['prev_exam']=$this->exam_model->get_prev_exam();

        $data['title']='<i class="icon-plus" style="color:#999 !important;"></i>&nbsp;Add Question';
        $data['exams']=$this->question_bank_model->ref_text_get_exam_all();
        $data['main_content']='admin/v_add_question';
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
        $chapter_group=$this->input->post('ddl_chapter_group');
        $chapter=$this->input->post('ddl_chapter');
        $question=$this->input->post('txt_ques');
        $options=$this->input->post('txtoptions');
        $inserted_from_ip=$this->get_client_ip();
        $question_by=$this->userid;
        $display=0;
        $is_prev=$this->input->post('ck_prev');
        $has_para=$this->input->post('ck_has_para');
        $hint=$this->input->post('txt_hints');
        $grade=$this->input->post('rd_grade');
        $question_source=$this->input->post('txt_source');
        $tags=$this->input->post('txt_tag');
        $period=$this->input->post('ddl_period');
        $is_changeable=$this->input->post('ck_changeable');


        $rules=array('ddl_subject|Subjects'=>'min:0',
            'ddl_chapter_group|Chapter Group'=>'min:0',
            'txt_ques|Question'=>'required',
            'txtoptions|Options'=>'required');
		
        $data=array('exam_name'=>$exam_name,
        'subject'=>$subject,
        'chapter_group'=>$chapter_group,
        'chapter'=>$chapter,
        'question'=>$question,
        'hints'=>$hint,
        'inserted_from_ip'=>$inserted_from_ip,
        'question_by'=>$question_by,
        'display'=>$display,
        'is_prev'=>$is_prev,
		'options'=>$options,
        'has_paragraph'=>$has_para,
        'question_grade'=>$grade,
        'question_source'=>$question_source,
        'tags'=>$tags,
        'period'=>$period,
        'is_changeable'=>$is_changeable);
        $save=$this->input->post('btn_save');
        $save_new=$this->input->post('btn_save_new');
      
        if($this->my_validation->validate($_POST,$rules))
        {
            $qid= $this->question_bank_model->add_question($data);
            $this->add_to_exam_question($qid);
            if($save)
            {
                $this->session->set_flashdata('success','Question added successfully!');
                redirect(base_url().'admin/question_bank');
            }
            if($save_new)
            {
                $this->session->set_flashdata('success','Question added successfully!');
                set_old_value($data);
                $this->session->set_flashdata('exam_cat',$exam_cat);

                redirect(base_url().'admin/add_question');
            }
        }
        else
        {
            set_old_value($data);
            $msg=$this->my_validation->errors;
            $this->session->set_flashdata('msg',$msg);
            redirect(base_url().'admin/add_question');   
        }

    }


    function add_to_exam_question($qid)
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
	
    function get_subjects()
    {
        $cid=$this->input->post('eid');
        $exam_names=$this->ref_text_model->get_ref_text_by_parent_group($cid,3);
        $str='';
        $str.="<option value='-1'>-Select Subject-</option>";
        if($exam_names)
        {
            foreach($exam_names as $exam)
            {
                $str.="<option value='{$exam->id}'>{$exam->name}</option>";
            }
        }
        echo $str;

    }


    function get_prev_exam()
    {
        $cid=$this->input->post('eid');
        $exam_names=$this->exam_model->get_prev_exam_by_eid($cid);
        $str='';
        if($exam_names)
        {
            foreach($exam_names as $exam)
            {
                $str.="<option value='{$exam->id}'>{$exam->name}</option>";
            }
        }
        echo $str;

    }

    function get_chapter_group()
    {
        $cid=$this->input->post('eid');
        $exam_names=$this->ref_text_model->get_ref_text_by_parent($cid);
        $str='';
        $str.="<option value=''>-Select Chapter Group-</option>";
        if($exam_names)
        {
            foreach($exam_names as $exam)
            {
                $str.="<option value='{$exam->id}'>{$exam->name}</option>";
            }
        }
        echo $str;
    }



    function get_chapter()
    {
        $cid=$this->input->post('eid');
        $exam_names=$this->ref_text_model->get_ref_text_by_parent($cid);
        $str='';
        $str.="<option value=''>-Select Chapter-</option>";
        if($exam_names)
        {
            foreach($exam_names as $exam)
            {
                $str.="<option value='{$exam->id}'>{$exam->name}</option>";
            }
        }
        echo $str;
    }
 
    function get_exam_name()
    {
        $exam_names=$this->ref_text_model->get_ref_text_by_group(2);
        $exams=array();
        foreach ($exam_names as $exm) {
           array_push($exams,array('exam_text'=>$exm->name,'exam_id'=>$exm->id));
        }
        echo json_encode($exams);
    }

    function find_similar_question()
    {
        $ques=strip_tags($this->input->get('ques','<img>'));
    
        //$cat=$this->input->get('cat');
        $subj=$this->input->get('subj');
        $str='';
       
        $questions=$this->question_bank_model->get_matched_question($subj);
        //var_dump($questions);
        if($questions)
        {
            foreach ($questions as $q) 
            {
                $qs=strip_tags(trim($q->question),'<img>');
               similar_text($ques,$qs,$percent);
               $per=number_format($percent,2);
               
               if($per>70)
               {
                    $str.='<div class="alert alert-error">';
                    $str.="<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                    $str.="<strong>Question ID:&nbsp;&nbsp;</strong>{$q->id}<br/>";
                    $str.="<strong>Matching Questions:&nbsp;&nbsp;</strong>{$qs}<br/><strong>Matches:&nbsp;&nbsp;</strong>{$per}%";
                    $str.='</div>';
               }
            } //end foreach loop
        }
       
        echo $str;
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
	
	