<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questions extends Uniadmin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('reftext_model');
		$this->load->model('exam_model');
		$this->load->model('question_bank_model');
		$this->load->library('my_validation');
		$this->load->library('ckeditor');
	}
	public function index()
	{
		$data['test_name']=$this->exam_model->get_test_name();
		$data['exams']=$this->question_bank_model->ref_text_get_exam_all();
		$data['cats']=$this->reftext_model->get_ref_text_by_group(2);
		$data['subjects']=$this->reftext_model->get_ref_text_by_group(3);
		$data['chapter_group']=$this->reftext_model->get_ref_text_by_group(6);
		$data['chapter']=$this->reftext_model->get_ref_text_by_group(4);

		$data['title']='<i class="icon-plus" style="color:#999 !important;"></i>&nbsp; Question Bank';
		$data['exams']=$this->question_bank_model->ref_text_get_exam_all();
		$data['title']='Question List';
		$this->load->blade('admin.question.index', $data);
	}

	/**
	 * question list to show in datatables
	 * @return json
	 */
	function question_list_dt()
	{
	     $term='';
	     $search=$_POST['search']['value'];
	     $filterStr='';
	     if($search)
	     {
	         $search_terms=json_decode($search);
	         $searchStr=' where';

	         if(!empty($search_terms->id))
	         {
	             $searchStr.=" id={$search_terms->id} and ";
	         }
	         if(!empty($search_terms->subject))
	         {
	             $searchStr.=" subject={$search_terms->subject} and ";
	         }
	         if(!empty($search_terms->chapter_group))
	         {
	             $searchStr.=" chapter_group={$search_terms->chapter_group} and ";
	         }

	         if(!empty($search_terms->chapter))
	         {
	             $searchStr.=" chapter={$search_terms->chapter} and ";
	         }

	         if(!empty($search_terms->ques))
	         {
	             $searchStr.=" question like '%{$search_terms->ques}%' and ";
	         }

	         if(!empty($search_terms->test))
	         {
	             $ques=$this->exam_model->get_exam_question($search_terms->test);
	             if($ques)
	             {

	             $searchStr.=" id in(".rtrim($ques->ques_id,',').") and ";
	             }
	             else
	             {
	                 $searchStr.=" id in(0) and ";
	             }
	         }
	         if($searchStr!=' where')
	         {
	             $term.=substr($searchStr,0,strlen($searchStr)-4);
	         }
	         $filterStr=$term;
	     }
	     $term.=" order by id desc";
	     $no = $_POST['start'];
	     $length = $_POST['length'];
	     $term.=" limit {$no},{$length}";
	    $list = $this->question_bank_model->qlist_get_all($term);
	    
	    $data = array();
	    if($list)
	    {
	        foreach($list as $q) 
	        {
	            $no++;
	            $row = array();
	            // $ques=strip_tags($item->question);
	            $row[]=$q->id;
	            $row[] = reftext_model::get_text($q->subject);
	            $row[] = $q->question;
	            $row[] = $this->process_options($q->options);
	            $row[]=$q->hints;
	            $action="<a href='".base_url()."admin/edit_question/index/{$q->id}' class='ttp' data-toggle='tooltip' data-placement='top' title='Edit'><i class='icon-edit'></i></a>";
	            $action.="<a onclick='return(confirm(\"are you sure to delete?\"))' href='".base_url()."admin/question_bank/deletequestion/{$q->id}'class='ttp' data-toggle='tooltip' data-placement='top' title='Delete'><i class='icon-trash'></i></a>";
	            $row[] = $action;
	            $data[] = $row;
	        }
	    }
	    $total=$this->question_bank_model->count_all();
	    $total_filtered=$this->question_bank_model->count_all($filterStr);
	    $output = array(
	                    "draw" => $_POST['draw'],
	                    "recordsTotal" =>$total ,
	                    "recordsFiltered" => $total_filtered,
	                    "data" => $data,
	            );
	    //output to json format
	    echo json_encode($output);
	}


    /**
     * create_question_list description
     * @param  [int] $start [description]
     * @param  [int] $limit [description]
     * @param  [string] $key   [description]
     * @return [string]        [description]
     */
    private function create_question_list($start,$limit,$key)
    {
        $questions=$this->question_bank_model->question_get_all($start,$limit,$key);
        $str='';
        if(!empty($questions))
        {		
            $ttl_ques=count($questions);
             $str.="<tbody>";
            foreach($questions as $q){
                $examcat='No Category';
                $exname='-';
                $subject='-';
                $chapter_group='-';
                $chapter='-';

                $exname=$this->get_text_by_csv($q->exam_name);
                
                $subject=reftext_model::get_text($q->subject);

                $chapter_group=reftext_model::get_text($q->chapter_group);

                $chapter=reftext_model::get_text($q->chapter);

    			$b=explode('///',$q->options);
    			$mx="";
    			$i=1;
               
    			foreach($b as $k)
                {
        			if($k!=null)
        			{
                        $correct=substr(trim(strip_tags($k,'<p><img>')),0,2)=="@@"?true:false;
                          
                        if($correct)
                        {
        				    $mx.=$i++.")<span style='color:green;'>".str_replace('@@','',strip_tags($k,'<p><img>'))."*</span><br/>  ";
                        }
                        else
                        {
                            $mx.=$i++.")".strip_tags($k,'<p><img>')."<br/>  ";
                        }
        			}
    			}
                $str.='<tr>';
              
                $str.="<td>{$subject}</td>";
                $str.="<td>{$q->question}</td>";
                $str.="<td>{$mx}</td>";
                $str.="<td>{$q->hints}</td>";
                $str.="<td><a href='".base_url()."admin/edit_question/index/{$q->id}' class='ttp' data-toggle='tooltip' data-placement='top' title='Edit'><i class='icon-edit'></i></a></td>";
                $str.="<td><a onclick='return(confirm(\"are you sure to delete?\"))' href='".base_url()."admin/question_bank/deletequestion/{$q->id}'class='ttp' data-toggle='tooltip' data-placement='top' title='Delete'><i class='icon-trash'></i></a></td>";
                $str.='</tr>';
            }
            $ttl=$this->total;
            $str.="</tbody>";
            $str.="<tfoot><tr>";
            $str.="<td></td><td></td><td></td>";
            $str.="<td>Total:</td><td>{$ttl_ques} of {$ttl}</td>";
            $str.="</tr></tfoot>";
            //return  $str;

        }
        else
        {
            $str.="<tr>";
            $str.="<td colspan='5' style='text-align:center;'>";
            $str.="No question found";
            $str.="</td>";
            $str.="</tr>";
        } 
        return $str;  
    }

    function process_options($options)
    {
        $b=explode('///',$options);
        $mx="";
        $i=1;
       
        foreach($b as $k)
        {
            if($k!=null)
            {
                $correct=substr(trim(strip_tags($k,'<p><img>')),0,2)=="@@"?true:false;
                  
                if($correct)
                {
                    $mx.=$i++.")<span style='color:green;'>".str_replace('@@','',strip_tags($k,'<p><img>'))."*</span><br/>  ";
                }
                else
                {
                    $mx.=$i++.")".strip_tags($k,'<p><img>')."<br/>  ";
                }
            }
        }

        return $mx;
    }
	public function  editQuestion()
	{
		$qid=$this->uri->segment(4);
		$data['title']='<i class="icon-plus" style="color:#999 !important;"></i>&nbsp;Edit Question';
		$data['query']=$this->question_bank_model->question_by_id($qid);
		//print_r($data);
		$data['main_content']='admin/v_edit_answer';
        $this->load->view('layout_admin/admin_layout',$data);
	}
	
	public function deletequestion()
	{
    	$qid=$this->uri->segment(4);
    	$this->question_bank_model->question_delete($qid);
        $this->session->set_flashdata('success', 'successfully deleted!');
        redirect(base_url().'admin/question_bank');
	}
	
    function get_text_by_csv($csv='0')
    {
        $csv_arr=explode(',',$csv);
        $text_arr=array();
        for($i=0;$i<count($csv_arr);$i++)
        {
            $rtext=reftext_model::get_text($csv_arr[$i]);
            array_push($text_arr,$rtext);
        }
        return implode(',',$text_arr);
    }

	function updateQuestion()
	{
    	$qid=$this->input->post('pid');
    	$question=$this->input->post('txtq');
    	$answare=$this->input->post('ans');
    	$year=$this->input->post('year');
        	$update=array(
        	'question'=>$question,
        	'options'=>$answare,
        	'period'=>$year
        	);
    	 $this->question_bank_model->question_update($qid,$update);
    	 $data['ques']=$this->create_question_list(0,10,'');
         $data['title']='<i class="icon-plus" style="color:#999 !important;"></i>&nbsp; Question Bank';
         $data['exams']=$this->question_bank_model->ref_text_get_exam_all();
         $data['main_content']='admin/v_question_bank';
         $this->load->view('layout_admin/admin_layout',$data);
	}


    function ans_option_view()
    {
        $this->load->library('ckeditor');
        $this->ckeditor->config['toolbar']=array(array( 'Image', 'Link', 'Unlink', 'Anchor','Source' ));
        $this->ckeditor->config['height']='80px';
        $qid=$this->uri->segment(4);
        $data['qid']=$qid;
        $data['opt']=$this->question_bank_model->get_ans_options($qid);
        $this->load->view('admin/v_ans_option',$data);
    }

	/**
	 * show add new question view
	 * @return void
	 */
	function create()
	{
		$data['cats']=$this->reftext_model->get_ref_text_by_group(2);
		$data['subjects']=$this->reftext_model->get_ref_text_by_group(3);
		$data['chapter_group']=$this->reftext_model->get_ref_text_by_group(6);
		$data['chapters']=$this->reftext_model->get_ref_text_by_group(4);
		$data['prev_exam']=$this->exam_model->get_prev_exam();

		$data['exams']=$this->question_bank_model->ref_text_get_exam_all();
		$data['title']='New Question';
		$this->load->blade('admin.question.create', $data);
	}

	/**
	 * save new question to database
	 * @return void
	 */
	function store()
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

	/**
	 * add exam name to question
	 * @param void
	 */
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


	/**
	 * get all subjects by exam category id
	 * @return void
	 */
	function get_subjects()
	{
	    $cid=$this->input->post('eid');
	    $exam_names=$this->reftext_model->get_ref_text_by_parent_group($cid,3);
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

	/**
	 * get all prev exam list by exam category id
	 * @return void
	 */
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

	/**
	 * get all chanpter group
	 * @return void
	 */
	function get_chapter_group()
	{
	    $cid=$this->input->post('eid');
	    $exam_names=$this->reftext_model->get_ref_text_by_parent($cid);
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

	/**
	 * get chapters by exam category id
	 * @return void
	 */
	function get_chapter()
	{
	    $cid=$this->input->post('eid');
	    $exam_names=$this->reftext_model->get_ref_text_by_parent($cid);
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
	 * get exam names
	 * @return void
	 */
	function get_exam_name()
	{
	    $exam_names=$this->reftext_model->get_ref_text_by_group(2);
	    $exams=array();
	    foreach ($exam_names as $exm) {
	       array_push($exams,array('exam_text'=>$exm->name,'exam_id'=>$exm->id));
	    }
	    echo json_encode($exams);
	}

	/**
	 * get all similar questions 
	 * @return void
	 */
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
	 * getting client machine ip adddress
	 * @return string
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

/* End of file questions.php */
/* Location: ./application/modules/university/controllers/admin/questions.php */