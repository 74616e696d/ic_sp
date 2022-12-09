<?php

class Written_ques extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('written_ques_model');
		$this->load->model('written_ques_ans_model');
		$this->load->model('written_ques_mapping_model');
		$this->load->model('ref_text_model');
		$this->load->model('exam_model');
		$this->load->helper('text');
		//$this->output->enable_profiler(true);
	}

	public function index()
	{
		$data['cats']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['title']='Written Question List';
		$this->load->blade('admin.written.index', $data);
	}


	function ques_list_dt()
	{
		 $length=$_POST['length'];
		 $term='';
		 $search=$_POST['search']['value'];
		 $filterStr='';
		 if($search){
		     $search_terms=json_decode($search);
		     $searchStr=' where';
		     if(!empty($search_terms->cat))
		     {
		         $searchStr.=" category={$search_terms->cat} and ";
		     }
		     if(!empty($search_terms->subj))
		     {
		         $searchStr.=" subject={$search_terms->subj} and ";
		     }

		     if(!empty($search_terms->ques))
		     {
		         $searchStr.=" question like '%{$search_terms->ques}%' and ";
		     }

		     if($searchStr!=' where')
		     {
		         $term.=substr($searchStr,0,strlen($searchStr)-4);
		     }
		     $filterStr=$term;
		 }

		 $no = $_POST['start'];
		 $term.=" order by wq.id desc limit {$no},{$length}";
		$list = $this->written_ques_model->get_all($term);
		
		$data = array();
		if($list)
		{
		    foreach($list as $item) 
		    {
		        $no++;
		        $row = array();
		        // $ques=strip_tags($item->question);
		        $row[]=$no;
		        $row[] = ref_text_model::get_text($item->category);
		        $row[] = ref_text_model::get_text($item->subject);
		        $row[] = ref_text_model::get_text($item->chapter);
		        $row[] = strip_tags($item->question);
		        $row[] = word_limiter($item->answer,30);
		        $edit_lnk=base_url().'admin/written_ques/edit/'.$item->id;
		        $delete_lnk=base_url().'admin/written_ques/destroy/'.$item->id;
		        $row[] = "<a class='btn btn-small btn-primary' title='Edit' href='{$edit_lnk}'><i class='fa fa-edit'></i></a>
		              <a onclick='return(confirm(\"are you sure to delete??\"))' title='Delete' class='btn btn-small btn-danger' href='{$delete_lnk}' title='Delete'><i class='fa fa-trash-o'></i></a>";

		        $data[] = $row;
		    }
		}
		$total=$this->written_ques_model->get_total();
		$total_filtered=$this->written_ques_model->get_total($filterStr);
		$output = array(
		                "draw" => $_POST['draw'],
		                "recordsTotal" =>$total ,
		                "recordsFiltered" => $total_filtered,
		                "data" => $data,
		        );
		//output to json format
		echo json_encode($output);
	}


	function create()
	{
		$data['cats']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['subjects']=$this->ref_text_model->get_ref_text_by_group(3);
		$data['title']='Written Question | Create';
		$this->load->blade('admin.written.create', $data);
	}

	function store()
	{
		$category=$this->input->post('category');
		$exam_name=$this->input->post('exam_name');
		$subject=$this->input->post('subject');
		$chapter=$this->input->post('chapter');
		$question=$this->input->post('ques');
		$ans=$this->input->post('ans');
		$display=1;

		$data=array('category'=>$category,
			'subject'=>$subject,
			'chapter'=>$chapter,
			'question'=>$question,
			'inserted_by'=>$this->userid,
			'created_at'=>date('Y-m-d H:i:s'),
			'display'=>$display);
		
		if(!empty($category))
		{
			// if(!empty($subject))
			// {
				if(!empty($question))
				{
					$qid=$this->written_ques_model->create($data);
					$data_ans=array('qid'=>$qid,
						'answer'=>$ans);
					$this->written_ques_ans_model->create($data_ans);
					if(count($exam_name)>0)
					{
						foreach ($exam_name as $name) 
						{
							$data_mapping=array('qid'=>$qid,
							'exam_name'=>$name);
							$this->written_ques_mapping_model->create($data_mapping);
						}
					}

					if($this->input->post('save'))
					{
						$this->session->set_flashdata('success', 'New Question Saved Successfully!');
						redirect(base_url()."admin/written_ques");
					}
					else
					{
						$this->session->set_flashdata('cat',$category);
						$this->session->set_flashdata('exam',$exam_name);
						$this->session->set_flashdata('subject',$subject);
						$this->session->set_flashdata('chapter',$chapter);
						$this->session->set_flashdata('success', 'New Question Saved Successfully!');
						redirect(base_url()."admin/written_ques/create");
					}
					
				}
				else
				{
					$this->session->set_flashdata('error', 'Question cannot be empty!');
					redirect(base_url()."admin/written_ques/create");
				}
			// }
			// else
			// {
			// 	$this->session->set_flashdata('error', 'Subject must be selected !');
			// 	redirect(base_url()."admin/written_ques/create");
			// }
		}
		else
		{
			$this->session->set_flashdata('error', 'Category must be selected !');
			redirect(base_url()."admin/written_ques/create");
		}
		
	}

	function edit()
	{
		$qid=$this->uri->segment(4);
		$data['cats']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['subjects']=$this->ref_text_model->get_ref_text_by_group(3);
		$data['ques']=$this->written_ques_model->find($qid);
		$data['ans']=$this->written_ques_ans_model->find_by('qid',$qid);

		$exams=$this->written_ques_mapping_model->get_all($qid);
		
		$data['exams']=$exams;

		$data['title']='Written Question | Edit';
		$this->load->blade('admin.written.edit', $data);
	}

	function update()
	{
		$qid=$this->input->post('hdn_id');
		$category=$this->input->post('category');
		$exam_name=$this->input->post('exam_name');
		$subject=$this->input->post('subject');
		$chapter=$this->input->post('chapter');
		$question=$this->input->post('ques');
		$ans=$this->input->post('ans');
		$display=1;

		$data=array('category'=>$category,
			'subject'=>$subject,
			'chapter'=>$chapter,
			'question'=>$question,
			'inserted_by'=>$this->userid,
			'created_at'=>date('Y-m-d H:i:s'),
			'display'=>$display);
		
		if(!empty($category))
		{
			// if(!empty($subject))
			// {
				if(!empty($question))
				{
					$this->written_ques_model->update($qid,$data);
					$data_ans=array('qid'=>$qid,
						'answer'=>$ans);
					$this->written_ques_ans_model->update_by('qid',$qid,$data_ans);
					if(count($exam_name)>0)
					{
						$this->written_ques_mapping_model->delete_by('qid',$qid);
						foreach ($exam_name as $name) 
						{
							$data_mapping=array('qid'=>$qid,
							'exam_name'=>$name);
							$this->written_ques_mapping_model->create($data_mapping);
						}
					}

						$this->session->set_flashdata('success', 'New Question Saved Successfully!');
						redirect(base_url()."admin/written_ques");
					
				}
				else
				{
					$this->session->set_flashdata('error', 'Question cannot be empty!');
					redirect(base_url()."admin/written_ques/create");
				}
			// }
			// else
			// {
			// 	$this->session->set_flashdata('error', 'Subject must be selected !');
			// 	redirect(base_url()."admin/written_ques/create");
			// }
		}
		else
		{
			$this->session->set_flashdata('error', 'Category must be selected !');
			redirect(base_url()."admin/written_ques/create");
		}
	}

	function destroy()
	{
		$id=$this->uri->segment(4);
		$this->written_ques_model->delete($id);
		$this->written_ques_ans_model->delete_by('qid',$id);
		$this->written_ques_mapping_model->delete_by('qid',$id);
		$this->session->set_flashdata('success', 'Question deleted successfully!!');
		redirect(base_url()."admin/written_ques");
	}

	function get_prev_exam()
	{
	    $cid=$this->input->post('eid');
	    $old_exam=$this->input->post('sel_exam')?$this->input->post('sel_exam'):'';
	    $sel_exam=json_decode($old_exam);

	    $exam_names=$this->exam_model->get_prev_exam_by_eid($cid);
	    $str='';
	    if($exam_names)
	    {
	        foreach($exam_names as $exam)
	        {
	        	$selected=in_array($exam->id,$sel_exam)?'selected':'';
	            $str.="<option {$selected} value='{$exam->id}'>{$exam->name}</option>";
	        }
	    }
	    echo $str;
	}

	function get_chapters()
	{
		$id=$this->input->post('subj');
		$sel_chap=$this->input->post('sel_chap')?$this->input->post('sel_chap'):'';
		$chapt_group=$this->ref_text_model->get_ref_text_by_parent($id);
		$str="<option value=''>Select Chapter</option>";
		if($chapt_group)
		{
			foreach ($chapt_group as $cgrp) 
			{
				$chapter=$this->ref_text_model->get_ref_text_by_parent($cgrp->id);
				if($chapter)
				{
					foreach ($chapter as $cpt) {
						$selected=$sel_chap==$cpt->id?'selected':'';
						$str.="<option {$selected} value='{$cpt->id}'>{$cpt->name}</option>";
					}
				}
			}
		}
		echo $str;
	}

	function get_subjects()
	{
	    $cid=$this->input->post('eid');
	    $old_sub=$this->input->post('sel_subj');
	    $exam_names=$this->ref_text_model->get_ref_text_by_parent_group($cid,3);
	    $str='';
	    $str.="<option value=''>-Select Subject-</option>";
	    if($exam_names)
	    {
	        foreach($exam_names as $exam)
	        {
	        	$selected=$old_sub==$exam->id?'selected':'';
	            $str.="<option {$selected} value='{$exam->id}'>{$exam->name}</option>";
	        }
	    }

	    echo $str;

	}

}

/* End of file written_ques.php */
/* Location: ./application/controllers/admin/written_ques.php */