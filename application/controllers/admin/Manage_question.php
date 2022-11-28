<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_question extends Admin_Controller {

    var $total=0;
    var $selected_id=-1;
    var $selected_cat=-1;
    var $selected_subject=-1;
    var $selected_chapter_group=-1;
    var $selected_chapter=-1;
    var $selected_test=-1;
    var $sel_user=-1;
    var $sel_status=-1;
    public function __construct()
    {
        parent::__construct();

		$this->load->helper('url');
		$this->load->helper('form');
        $this->load->helper('message');
        $this->load->model('question_bank_model');
        $this->load->model('ref_text_model');
        $this->load->model('exam_model');
        $this->load->model('user_model');
        $this->load->library('pagination');
        $this->load->helper('common');
       //$this->output->enable_profiler(true);
    }
    public function index()
    {
        $data['test_name']=$this->exam_model->get_test_name();
        $data['exams']=$this->question_bank_model->ref_text_get_exam_all();
        $data['cats']=$this->ref_text_model->get_ref_text_by_group(2);
        $data['subjects']=$this->ref_text_model->get_ref_text_by_group(3);
        $data['chapter_group']=$this->ref_text_model->get_ref_text_by_group(6);
        $data['chapter']=$this->ref_text_model->get_ref_text_by_group(4);
        $query_param=$this->search_string();
        $this->total=$this->question_bank_model->total_question($query_param);
        $data['selected_qid']=$this->selected_id=='-1'?'':$this->selected_id;
        $data['selected_subject']=$this->selected_subject;
        $data['selected_chapter_group']=$this->selected_chapter_group;
        $data['selected_chapter']=$this->selected_chapter;
        $data['selected_test']=$this->selected_test;

        $data['users']=$this->user_model->get_reserved_users();

        $start=0;
        $limit=100;
        if($this->uri->segment(11))
        {
            $start=$this->uri->segment(11);
        }
        
        $baseurl=base_url().'admin/question_bank/index/'.$this->selected_subject.'/'.$this->selected_chapter_group.'/'.$this->selected_chapter.'/'.$this->selected_test.'/'.$this->selected_id.'/';
        $data['display_page']=create_pagination($baseurl,$this->total,11,5,100);

        $data['ques']=$this->create_question_list($start,$limit,$query_param);
        $data['title']='<i class="icon-plus" style="color:#999 !important;"></i>&nbsp; Manage Question';
        $data['exams']=$this->question_bank_model->ref_text_get_exam_all();
        $this->load->blade('admin.manage_question',$data);
    }

    /**
     * building dynamic search criteria
     * @return [string] [description]
     */
    private function search_string()
    {

        if($this->uri->segment(4))
        {
            if($this->uri->segment(4)!=-1)
            {
                $this->selected_subject=$this->uri->segment(4);
            }
        }
        if($this->uri->segment(5))
        {
            if($this->uri->segment(5)!=-1)
            {
                $this->selected_chapter_group=$this->uri->segment(5);
            }
        }

        if($this->uri->segment(6))
        {
            if($this->uri->segment(6)!=-1)
            {
                $this->selected_chapter=$this->uri->segment(6);
            }
        }

        if($this->uri->segment(7))
        {
            if($this->uri->segment(7)!=-1)
            {
                $this->selected_test=$this->uri->segment(7);
            }
        }

        if($this->uri->segment(8))
        {
            $qid=$this->uri->segment(8);
            if($qid!=-1)
            {
                $this->selected_id=$qid;
            }
        }


        if($this->uri->segment(9))
        {
            $uid=$this->uri->segment(9);
            if($uid!=-1)
            {
                $this->sel_user=$uid;   
            }
        }

        $stts=$this->uri->segment(10);

        
            if(empty($stts))
            {
                $this->sel_status=0;
            }
            else
            {
                if($stts!=-1)
                {
                    $this->sel_status=$stts;
                }
            }
        

        $stringToFinalReturn='';
        $stringReturned=' where';
        if($this->selected_id!=-1)
        {
            $stringReturned.=" id={$this->selected_id} and ";
        }
        if($this->selected_subject!=-1)
        {
            $stringReturned.=" subject={$this->selected_subject} and ";
        }
        if($this->selected_chapter_group!=-1)
        {
            $stringReturned.=" chapter_group={$this->selected_chapter_group} and ";
        }

        if($this->selected_chapter!=-1)
        {
            $stringReturned.=" chapter={$this->selected_chapter} and ";
        }

        if($this->sel_user!=-1)
        {
            $stringReturned.=" question_by={$this->sel_user} and ";
        }


        if($this->sel_status!=-1)
        {
            $stringReturned.=" display={$this->sel_status} and ";
        }

        if($this->selected_test!=-1)
        {
            $ques=$this->exam_model->get_exam_question($this->selected_test);
            if($ques)
            {
            $stringReturned.=" id in(".$ques->ques_id.") and ";
            }
            else
            {
                $stringReturned.=" id in(0) and ";
            }
        }

        if($stringReturned!=' where')
        {
            $stringToFinalReturn=substr($stringReturned,0,strlen($stringReturned)-4);
        }

        return $stringToFinalReturn;
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
                
                $subject=ref_text_model::get_text($q->subject);

                $chapter_group=ref_text_model::get_text($q->chapter_group);

                $chapter=ref_text_model::get_text($q->chapter);

    			$b=explode('///',$q->options);
    			$mx="";
    			$i=1;
               
    			foreach($b as $k)
                {
        			if($k!=null)
        			{
                        $correct=substr(trim(strip_tags($k,'<img>')),0,2)=="@@"?true:false;
                          
                        if($correct)
                        {
        				    $mx.=$i++.")<span style='color:green;'>".str_replace('@@','',strip_tags($k,'<img>'))."</span><br/>  ";
                        }
                        else
                        {
                            //echo $k;
                            $mx.=$i++.")".strip_tags($k,'<img>')."<br/>  ";
                        }
        			}
    			}

                $status=$q->display?'published':'Not Published';
                $cked=$q->display?'checked':'';
                $str.='<tr>';
              
                $str.="<td>{$subject}</td>";
                $str.="<td>{$q->question}</td>";
                $str.="<td>{$mx}</td>";
                $str.="<td><label class='checkbox'><input {$cked} class='status' type='checkbox' value='{$q->id}'/><span>{$status}</span></label></td>";
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


    function publish()
    {
        $qid=$this->input->get('id');
        $stat=$this->input->get('stat');
        $this->question_bank_model->question_update($qid,array('display'=>$display));
        echo "1";
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
        $this->session->set_flashdata('success', 'successfully deleted!');
        redirect(base_url().'admin/question_bank');
	}
	
    function get_text_by_csv($csv='0')
    {
        $csv_arr=explode(',',$csv);
        $text_arr=array();
        for($i=0;$i<count($csv_arr);$i++)
        {
            $rtext=ref_text_model::get_text($csv_arr[$i]);
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
}
	
	