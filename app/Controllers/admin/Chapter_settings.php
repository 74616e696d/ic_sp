<?php

class Chapter_settings extends CI_Controller {
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
        $this->load->model('chapter_details_model');
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

        $data['title']='<i class="icon-plus" style="color:#999 !important;"></i>&nbsp;Chapter Settings';
        $data['main_content']='admin/v_chapter_settings';
        $this->load->view('layout_admin/admin_layout',$data);

    }


    function add()
    {
        $exam_cat1=$this->input->post('ddl_exam_cat1');
        $subject1=$this->input->post('ddl_subject1');
        $chapter_group1=$this->input->post('ddl_chapter_group1');
        $chapter1=$this->input->post('ddl_chapter1');

        $exam_cat2=$this->input->post('ddl_exam_cat2');
        $subject2=$this->input->post('ddl_subject2');
        $chapter_group2=$this->input->post('ddl_chapter_group2');
        $chapter2=$this->input->post('ddl_chapter2');

        $rules=array(
            'ddl_exam_cat1|Exam Category(Left)'=>'min:0',
            'ddl_subject1|Subjects(Left)'=>'min:0',
            'ddl_chapter_group1|Chapter Group(Left)'=>'min:0',
            'ddl_chapter1|Chapter(Left)'=>'min:0',

            'ddl_exam_cat2|Exam Category(Right)'=>'min:0',
            'ddl_subject2|Subjects(Right)'=>'min:0',
            'ddl_chapter_group2|Chapter Group(Right)'=>'min:0',
            'ddl_chapter2|Chapter(Right)'=>'min:0',
        );

        $data_old=array(
        	'subject'=>$subject1,
        	'chapter_group'=>$chapter_group1,
        	'chapter'=>$chapter1,
        );
        $save=$this->input->post('btn_save');
        $save_new=$this->input->post('btn_save_new');
      
        if($this->my_validation->validate($_POST,$rules))
        {
            $data=array(
                'chapter1'=>$chapter1,
                'chapter2'=>$chapter2,
            );

            $check = $this->chapter_details_model->check_link($chapter1,$chapter2);

            if($check == 0){
                $this->chapter_details_model->chapter_link($data);
            }else{
                set_old_value($data_old);
                $this->session->set_flashdata('exam_cat',$exam_cat1);
                $this->session->set_flashdata('error','Chapters are already linked!');
                redirect(base_url().'admin/chapter_settings');
            }

            if($save)
            {
                $this->session->set_flashdata('success','Chapter Linked successfully!');
                redirect(base_url().'admin/chapter_settings');
            }
            if($save_new)
            {
                $this->session->set_flashdata('success','Chapter Linked successfully!');
                set_old_value($data_old);
                $this->session->set_flashdata('exam_cat',$exam_cat1);

                redirect(base_url().'admin/chapter_settings');
            }
        }
        else
        {
            set_old_value($data_old);
            $this->session->set_flashdata('exam_cat',$exam_cat1);
            $msg=$this->my_validation->errors;
            $this->session->set_flashdata('msg',$msg);
            redirect(base_url().'admin/chapter_settings');   
        }

    }

    function copy_question()
    {
        $exam_cat1=$this->input->post('ddl_exam_cat3');
        $subject1=$this->input->post('ddl_subject3');
        $chapter_group1=$this->input->post('ddl_chapter_group3');
        $chapter1=$this->input->post('ddl_chapter3');

        $exam_cat2=$this->input->post('ddl_exam_cat4');
        $subject2=$this->input->post('ddl_subject4');
        $chapter_group2=$this->input->post('ddl_chapter_group4');
        $chapter2=$this->input->post('ddl_chapter4');

        $rules=array(
            'ddl_exam_cat3|Exam Category(Left)'=>'min:0',
            'ddl_subject3|Subjects(Left)'=>'min:0',
            'ddl_chapter_group3|Chapter Group(Left)'=>'min:0',
            'ddl_chapter3|Chapter(Left)'=>'min:0',

            'ddl_exam_cat4|Exam Category(Right)'=>'min:0',
            'ddl_subject4|Subjects(Right)'=>'min:0',
            'ddl_chapter_group4|Chapter Group(Right)'=>'min:0',
            'ddl_chapter4|Chapter(Right)'=>'min:0',
        );

        $data_old=array(
            'subject1'=>$subject1,
            'chapter_group1'=>$chapter_group1,
            'chapter1'=>$chapter1,
        );
        $save=$this->input->post('btn_save');
        $save_new=$this->input->post('btn_save_new');
      
        if($this->my_validation->validate($_POST,$rules))
        {
            $this->db->where('exam_name',$exam_cat1);
            $this->db->where('subject',$subject1);
            $this->db->where('chapter_group',$chapter_group1);
            $this->db->where('chapter',$chapter1);
            $questions = $this->db->get('question_bank');

            if($questions->num_rows() > 0){
                /*echo "<pre>";
                var_dump($questions->result_array());
                echo "</pre>";*/
                foreach ($questions->result_array() as $key => $value) {
                    $data = array(
                            'exam_name'=>$exam_cat2,
                            'subject'=>$subject2,
                            'chapter_group'=>$chapter_group2,
                            'chapter'=>$chapter1,
                            'question'=>$value['question'],
                            'hints'=>$value['hint'],
                            'inserted_from_ip'=>$value['inserted_from_ip'],
                            'question_by'=>$value['question_by'],
                            'display'=>$value['display'],
                            'options'=>$value['options'],
                            'has_paragraph'=>$value['has_para'],
                            'created_at'=>$value['created_at'],
                            'updated_at'=>date('Y-m-d H:i:s')
                    );
                    $this->question_bank_model->add_question($data);
                }
            }else{
                set_old_value($data_old);
                $this->session->set_flashdata('exam_cat1',$exam_cat1);
                $this->session->set_flashdata('error','No Question in this Chapter!');
                redirect(base_url().'admin/chapter_settings');
            }

            if($save)
            {
                $this->session->set_flashdata('success','Chapter Questions Copied successfully!');
                redirect(base_url().'admin/chapter_settings');
            }
            if($save_new)
            {
                $this->session->set_flashdata('success','Chapter Questions Copied successfully!');
                set_old_value($data_old);
                $this->session->set_flashdata('exam_cat1',$exam_cat1);

                redirect(base_url().'admin/chapter_settings');
            }
        }
        else
        {
            set_old_value($data_old);
            $this->session->set_flashdata('exam_cat1',$exam_cat1);
            $msg=$this->my_validation->errors;
            $this->session->set_flashdata('msg',$msg);
            redirect(base_url().'admin/chapter_settings');   
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
	
	