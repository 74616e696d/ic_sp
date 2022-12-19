<?php

class Ans_option extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
       
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('message');
        $this->load->model('question_bank_model');
        $this->load->library('ckeditor');
        //$this->ckeditor->config['toolbar']=array(array( 'Image', 'Link', 'Unlink', 'Anchor','Source' ));
        //$this->ckeditor->config['height']='';
    }
    public function index()
    {
        $qid=$this->uri->segment(4);
        $data['qid']=$qid;
        $data['opt']=$this->question_bank_model->get_ans_options($qid);
        $this->load->view('admin/v_ans_option',$data);
    }

    function save_ans()
    {
      $qid=$this->input->post('hdn_id');
    }
}
	
	