<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question_bank extends CI_Controller {

    var $total=0;
    var $selected_id=-1;
    var $selected_cat=-1;
    var $selected_subject=-1;
    var $selected_chapter_group=-1;
    var $selected_chapter=-1;
    var $selected_test=-1;
    public function __construct()
    {
        parent::__construct();

		$this->load->helper('url');
		$this->load->helper('form');
        $this->load->helper('message');
        $this->load->model('question_bank_model');
        $this->load->model('ref_text_model');
        $this->load->model('exam_model');
        $this->load->library('pagination');
        $this->load->helper('common');
        $roles=array('101','102');
        membership_model::is_authenticate($roles);
    }
    public function index()
    {
       $data['test_name']=$this->exam_model->get_test_name();
        $data['exams']=$this->question_bank_model->ref_text_get_exam_all();
        $data['cats']=$this->ref_text_model->get_ref_text_by_group(2);
        $data['subjects']=$this->ref_text_model->get_ref_text_by_group(3);
        $data['chapter_group']=$this->ref_text_model->get_ref_text_by_group(6);
        $data['chapter']=$this->ref_text_model->get_ref_text_by_group(4);

        $data['title']='<i class="icon-plus" style="color:#999 !important;"></i>&nbsp; Question Bank';
        $data['exams']=$this->question_bank_model->ref_text_get_exam_all();
        $this->load->blade('admin/v_question_bank',$data);
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

             if($search_terms->is_changeable!=false)
             {
                 $searchStr.=" is_changeable={$search_terms->is_changeable} and ";
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
                $row[] = Ref_text_model::get_text($q->subject);
                $row[] = $q->question;
                $row[] = $this->process_options($q->options);
                $row[]=$q->hints;
                $action="<a href='".base_url()."admin/edit_question/index/{$q->id}' class='ttp' data-toggle='tooltip' data-placement='top' title='Edit'><i class='icon-edit'></i></a>";
                $action.="<a onclick='return(confirm(\"are you sure to delete?\"))' href='".base_url()."admin/question_bank/deletequestion/{$q->id}'class='ttp' data-toggle='tooltip' data-placement='top' title='Delete'><i class='icon-trash'></i></a>";
                $row[] = $action;
                $row[] =$q->updated_at!='0000-00-00 00:00:00'?date('d F, Y H:i a',strtotime($q->updated_at)):'';
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
	
	