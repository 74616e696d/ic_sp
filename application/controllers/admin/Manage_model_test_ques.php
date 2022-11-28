<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_model_test_ques extends CI_Controller {

    var $total=0;
    var $selected_id=-1;
    var $selected_cat=-1;
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
        $this->load->model('model_test_model');
        $this->load->model('model_test_question_model','model_ques');
        $this->load->helper('common');
        $roles=array('101','102');
        membership_model::is_authenticate($roles);
    }
    public function index()
    {
        $data['cats']=$this->ref_text_model->get_ref_text_by_group(2);
        $query_param=$this->search_string();
        $this->total=$this->question_bank_model->total_model_test_question($query_param);
        $data['selected_qid']=$this->selected_id=='-1'?'':$this->selected_id;

        $start=0;
        $limit=100;
        if($this->uri->segment(7))
        {
            $start=$this->uri->segment(7);
        }
        
        $baseurl=base_url().'admin/manage_model_test_ques/index/'.$this->selected_id.'/'.$this->selected_test.'/'.$this->selected_cat.'/';
        $data['display_page']=create_pagination($baseurl,$this->total,7,5,100);
        $data['selected_id']=$this->selected_id;
        $data['selected_cat']=$this->selected_cat;
        $data['selected_test']=$this->selected_test;
        $data['ques']=$this->create_question_list($start,$limit,$query_param);
        $data['title']='<i class="icon-plus" style="color:#999 !important;"></i>&nbsp; Question Bank';
        $data['exams']=$this->question_bank_model->ref_text_get_exam_all();
        $this->load->blade('admin.manage_model_test_ques',$data);
    }

    function question()
    {
        $data['cats']=$this->ref_text_model->get_ref_text_by_group(2);
        $data['title']='Model Test Question List';
        $this->load->blade('admin.modeltest.test_questions', $data);
    }

    /**
     * model test question list display in jquery datatables
     * @return json
     */
    function dt_qlist()
    {
        $length=$_POST['length'];
        $term='';
        $search=$_POST['search']['value'];
        $filterStr='';
        if($search){
            $search_terms=json_decode($search);
            $searchStr=' where';
            // var_dump($search_terms);
            if(!empty($search_terms->test_name))
            {
                $searchStr.=" test_id={$search_terms->test_name} and ";
            }
            if(!empty($search_terms->ques))
            {
                $searchStr.=" question LIKE '%{$search_terms->ques}%' and ";
            }
        
            if($searchStr!=' where')
            {
                $term.=substr($searchStr,0,strlen($searchStr)-4);
            }
            $filterStr=$term;
        }
   
        $no = $_POST['start'];
        $term.=" limit {$no},{$length}";
       $list = $this->model_ques->get_questions_dt($term);
   
       $data = array();
       if($list)
       {
           foreach($list as $item) 
           {
               $no++;
               $row = array();
               $ques=strip_tags($item->question);
               $row[] = $ques;
               $row[] = $item->options;
               $row[] = $item->subject_name;
               $row[] = "<a class='btn btn-small btn-primary' title='Edit' href='javascript:void(0)' onclick='edit_question({$item->id})'><i class='fa fa-edit'></i> Edit</a>
                     <a class='btn btn-small btn-danger' href='javascript:void(0)' title='Delete' onclick='delete_question({$item->id})'><i class='fa fa-trash-o'></i> Delete</a>";

               $data[] = $row;
           }
       }
       $total=$this->model_ques->get_count();
       $total_filtered=$this->model_ques->get_count($filterStr);
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
     * building dynamic search criteria
     * @return [string] [description]
     */
    private function search_string()
    {

        if($this->uri->segment(4))
        {
            $qid=$this->uri->segment(4);
            if($qid!=-1)
            {
                $this->selected_id=$qid;
            }
        }
        if($this->uri->segment(5))
        {
            $test_id=$this->uri->segment(5);
            if($test_id!=-1)
            {
                $this->selected_test=$test_id;
            }
        }

        if($this->uri->segment(6))
        {
            $test_cat=$this->uri->segment(6);
            if($test_cat!=-1)
            {
                $this->selected_cat=$test_cat;
            }
        }

        $stringToFinalReturn='';
        $stringReturned=' where';
        if($this->selected_id!=-1)
        {
            $stringReturned.=" qb.id={$this->selected_id} and ";
        }
       

        if($this->selected_test!=-1)
        {
            $stringReturned.=" mtq.test_id={$this->selected_test} and ";
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
        $questions=$this->question_bank_model->model_test_question($start,$limit,$key);
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
        				    $mx.=$i++.")<span style='color:green;'>".str_replace('@@','',strip_tags($k,'<img>'))."*</span><br/>  ";
                        }
                        else
                        {
                            //echo $k;
                            $mx.=$i++.")".strip_tags($k,'<img>')."<br/>  ";
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

	public function delete_question_dt()
    {
        $qid=$this->input->get('id');
        $this->question_bank_model->question_delete($qid);
        echo json_encode(array("status" => TRUE));
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


    function get_model_test()
    {
        $pid=$this->input->post('eid');
        $sel=$this->input->post('sel')?$this->input->post('sel'):'';
        $model_test=$this->model_test_model->all_by('category',$pid);
        $str="<option value='-1'>Select Model Test</option>";
        if($model_test)
        {
            foreach ($model_test as $test) {
                $selected=$sel==$test->id?'Selected':'';
               $str.="<option {$selected} value='$test->id'>{$test->name}</option>";
            }
        }
        echo $str;
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
	
	