<?php

class Assign_question extends Admin_Controller {
	private $skey1=array();
	private $skey2=array();
	private $skey3=array();
	private $skey4=array();
	private $skey5=array();
	private $skey6='';
	function __construct()
	{
		parent::__construct();

		$this->load->helper('message');
		$this->load->model('exam_model');
		$this->load->model('ref_text_model');
	}
	public function index()
	{
		$data['test_type']=$this->exam_model->all();
		$data['cats']=$this->ref_text_model->get_ref_text_by_group(2);
        $data['subjects']=$this->ref_text_model->get_ref_text_by_group(3);
        $data['chapter_group']=$this->ref_text_model->get_ref_text_by_group(6);
        $data['chapters']=$this->ref_text_model->get_ref_text_by_group(4);
		$data['title']='Assign Question To Exam';
		$data['main_content']='admin/v_assign_question';
		$this->load->view('layout_admin/admin_layout', $data);
	}


	function search_key()
	{
		if($this->input->get('cat'))
		{
			$this->skey1=explode(',',$this->input->get('cat'));
		}
		if($this->input->get('exam'))
		{
			$this->skey2=explode(',',$this->input->get('exam'));
		}
		if($this->input->get('subj'))
		{
			$this->skey3=explode(',',$this->input->get('subj'));
		}
		if($this->input->get('chapter_group'))
		{
			$this->skey4=explode(',',$this->input->get('chapter_group'));
		}
		if($this->input->get('chapter'))
		{
			$this->skey5=explode(',',$this->input->get('chapter'));
		}
		if($this->input->get('prev'))
		{
			$this->skey6=$this->input->get('prev');
		}
		 $stringToFinalReturn='';
        $stringReturned=' where';
	    if(count($this->skey1)>0)
	    {
		   	foreach($this->skey1 as $sk1)
		    {
	      	$stringReturned.=" find_in_set({$sk1},exam_cat) and ";
	      	}
	    }
     
        if(count($this->skey2)>0)
        {
        	foreach ($this->skey2 as $sk2) {
        		$stringReturned.=" find_in_set({$sk2},exam_name) and ";
        	}
            
        }
        if(count($this->skey3)>0)
        {
        	foreach ($this->skey3 as $sk3) {
        		$stringReturned.=" find_in_set({$sk3},subject) and ";
        	}
        }

        if(count($this->skey4)>0)
        {
        	foreach ($this->skey4 as $sk4) {
        		$stringReturned.=" find_in_set({$sk4},chapter_group) and ";
        	}
            
        }

        if(count($this->skey5)>0)
        {
        	foreach ($this->skey5 as $sk5) {
        		$stringReturned.=" find_in_set({$sk5},chapter) and ";
        	}
            
        }

        if(!empty($this->skey6))
        {
            $stringReturned.=" is_prev=1 and ";
        }
        if($stringReturned!=' where')
        {
            $stringToFinalReturn=substr($stringReturned,0,strlen($stringReturned)-4);
        }
        return $stringToFinalReturn;
	}

	function get_ques_list()
	{
		$skey=$this->search_key();
		$questions=$this->exam_model->get_ques_by_criteria($skey);
		$ques_count=$this->get_subject_wise_count($questions);
		//var_dump($ques_count);
		$str='';
		$str.="<ul class='unstyled pre'>";
		foreach($ques_count as $qc)
		{
			$sbj_text=ref_text_model::get_text($qc['subject']);
			$str.="<li><strong>{$sbj_text}:&nbsp;&nbsp;{$qc['total']}</strong></li>";
		}
		$str.="<p><strong>Total Selected Question:</strong>&nbsp;&nbsp;<span style='color:#2F96B4;' id='ttl'>0</span></p>";
		$str.="</ul>";
		
		
		$str.="<label style='font-weight:bold;'><input style='float:left;' type='checkbox' id='ck_all_ques'/>Select All</label><hr>";
		$str.='<ul class="unstyled">';
		$sl=0;
		if($questions)
		{
			foreach($questions as $q)
			{
				$sl++;
				$qst=strip_tags($q->question,'<img>');
				$str.="<li><label><input style='float:left;' type='checkbox' class='ck_ques' value={$q->id} name='ck_ques[]' id='ck_ques_{$sl}' />&nbsp;&nbsp;{$qst}</label></li>";
			}
		}
		$str.="</ul>";
		echo $str;
	}

	function get_subject_wise_count($question)
	{
		$str='';
		$subject=array();
	
		if($question)
		{
			foreach ($question as $q) 
			{
				$subs=explode(',',$q->subject);
				if($subs!=null)
				{
					foreach ($subs as $s) 
					{
						array_push($subject,$s);

					}
				}
			}
		}
		sort($subject,1);
		$result=array();
		$prev_val=array('subject'=>null,'total'=>0);
		foreach ($subject as $sb) 
		{
			if($prev_val['subject']!=$sb)
			{
				unset($prev_val);
				$prev_val=array('subject'=>$sb,'total'=>0);
				$result[]=& $prev_val;
			}
			$prev_val['total']++;
		}
		return $result;
	}

	function assign()
	{
		$test_type=$this->input->post('ddl_test_type');
		$question=implode(',',$this->input->post('ck_ques'));
		$data=array('exam_id'=>$test_type,
			'ques_id'=>$question);
		if($test_type!=-1)
		{
			try
			{
				$this->exam_model->assign_ques($data);
				$this->session->set_flashdata('success', 'successfully assigned!');
				redirect(base_url().'admin/assign_question');
			}
			catch(Exception $ex)
			{
				$this->session->set_flashdata('success',$ex->getMessage());
				redirect(base_url().'admin/assign_question');
			}
		}
		else
		{
			$this->session->set_flashdata('warning', 'Test Type must be selected!');
			redirect(base_url().'admin/assign_question');
		}
	}
	
	function test()
	{
		$arr = array(1,1,1,2,2,3,3,1,1,2,2,3);
		sort($arr,1);
		print_r($arr);
		$result = array();
		$prev_value = array('value' => null, 'amount' => null);

		foreach ($arr as $val) {
    	if ($prev_value['value'] != $val) {
        unset($prev_value);
        $prev_value = array('value' => $val, 'amount' => 0);
        $result[] =& $prev_value;
    }

    $prev_value['amount']++;
	}

	var_dump($result);
	}
}

/* End of file assign_question.php */
/* Location: ./application/controllers/admin/assign_question.php */