<?php

class Roadmap extends Admin_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('roadmap_model');
		$this->load->model('roadmap_details_model');
		$this->load->model('model_test_model');
		$this->load->helper('text');
		$this->load->model('ref_text_model');
	}

	function index()
	{
		$data['category']=$this->ref_text_model->where(array('group_id|='=>2))->get();
		$data['title']='Crash Course';
		$this->load->blade('admin.roadmap.index', $data);
	}

	function roadmap_dt()
	{
		 $length=$_POST['length'];
		 $term='';
		 $search=$_POST['search']['value'];
		 $filterStr='';
		 if($search){
		     $search_terms=json_decode($search);
		     $searchStr=' where';
		     if(!empty($search_terms->category))
		     {
		         $searchStr.=" category={$search_terms->category} and ";
		     }
		     if($searchStr!=' where')
		     {
		         $term.=substr($searchStr,0,strlen($searchStr)-4);
		     }
		     $filterStr=$term;
		 }
		 $term.=" order by id desc";
		 $no = $_POST['start'];
		 $term.=" limit {$no},{$length}";
		$list = $this->roadmap_model->get_roadmap($term);
		
		$data = array();
		if($list)
		{
		    foreach($list as $item) 
		    {
		        $no++;
		        $row = array();
		        $row[]=$no;
		        $row[] = $item->exam_name;
		        $row[] = model_test_model::get_text($item->test_id);
		        $tags='';
		       	$rtags= Roadmap_details_model::chapter_tag($item->id);
		       	if($rtags)
		       	{
		       		foreach($rtags as $rtag)
		       		{
		       			$tags.="<span class='badge'>{$rtag->name}</span>  ";
		       		}
		       	}
		        $row[]= $tags;
		        $row[]= date('Y-m-d',strtotime($item->exam_date));

		        $edit_url=base_url().'admin/roadmap/edit/'.$item->id;
		        $action= " <a class='btn btn-mini btn-default' title='Edit' href='{$edit_url}'><i class='fa fa-edit'></i></a>";
		        $action.="  <a class='btn btn-mini btn-default' href=''><i class='fa fa-trash-o'></i></a>";
		        $row[]=$action;

		        $data[] = $row;
		    }
		}
		$total=$this->roadmap_model->count_all();
		$total_filtered=$this->roadmap_model->count_all($filterStr);
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
	 * get course/roadmap by category
	 * @return void
	 */
	function get_course()
	{
		$category=$this->input->get('category');
		$sel=$this->input->get('sel')?$this->input->get('sel'):'';
		$courses=$this->model_test_model->get_model_test_by_cat($category);

		$str="<option value=''>Select Model Test</option>";
		if($courses)
		{
			foreach($courses as $c)
			{
				$selected=$sel==$c->id?'selected':'';
				$str.="<option {$selected} value='{$c->id}'>{$c->name}</option>";
			}
		}

		echo $str;
	}

	public function details()
	{
		$data['category']=$this->ref_text_model->where(array('group_id|='=>2))->get();
		$data['dtls']=$this->roadmap_details_model->all();
		$data['title']='Manage Crash Course Details';
		$this->load->blade('admin.roadmap.index_details', $data);
	}

	function roadmap_details_dt()
	{
		 $length=$_POST['length'];
		 $term='';
		 $search=$_POST['search']['value'];
		 $filterStr='';
		 if($search){
		     $search_terms=json_decode($search);
		     $searchStr=' where';
		     if(!empty($search_terms->course))
		     {
		         $searchStr.=" roadmap_id={$search_terms->course} and ";
		     }
		     if($searchStr!=' where')
		     {
		         $term.=substr($searchStr,0,strlen($searchStr)-4);
		     }
		     $filterStr=$term;
		 }
		 $term.=" order by id desc";
		 $no = $_POST['start'];
		 $term.=" limit {$no},{$length}";
		$list = $this->roadmap_details_model->get_roadmap($term);
		
		$data = array();
		if($list)
		{
		    foreach($list as $item) 
		    {
		        $no++;
		        $row = array();
		        $row[]=$no;
		        $row[] = roadmap_model::get_text($item->roadmap_id);
		        $row[] = ref_text_model::get_text($item->topics);
		        $details=strip_tags($item->details,'<p><span><strong>');
		        $row[]=word_limiter($details,50);
		        $edit_url=base_url().'admin/roadmap/edit_details/'.$item->id;
		        $delete_details_url=base_url()."admin/roadmap/delete_details/{$item->id}";
		         $action= " <a class='btn btn-mini btn-default' title='Edit' href='{$edit_url}'><i class='fa fa-edit'></i></a>";
		         $action.="  <a onclick='return(confirm(\"Are you sure to delete ??\"))' class='btn btn-mini btn-default' href='{$delete_details_url}'><i class='fa fa-trash-o'></i></a>";
		        $row[]=$action;

		        $data[] = $row;
		    }
		}
		$total=$this->roadmap_details_model->count_all();
		$total_filtered=$this->roadmap_details_model->count_all($filterStr);
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
	 * get roadmap names 
	 * @return void
	 */
	function get_roadmap()
	{
		$category=$this->input->get('category');
		$sel =$this->input->get('sel')?$this->input->get('sel'):'';
		$tests=$this->roadmap_model->all_by('category',$category);
		$str="<option value=''>-Crash Course Name-</option>";

		if($tests)
		{
			foreach($tests as $tst)
			{
				$selected=$sel==$tst->id?'selected':'';
				$str.="<option {$selected} value='{$tst->id}'>{$tst->exam_name}</option>";
			}
		}

		echo $str;
	}

	function create_details()
	{
		$data['category']=$this->ref_text_model->where(array('group_id|='=>2))->get();
		$data['subjects']=$this->ref_text_model->get_ref_text_by_group(3);
		$data['roadmap']=$this->roadmap_model->all_by('category',1155);
		$data['title']='Create Crash Course Details';
		$this->load->blade('admin.roadmap.create_details', $data);
	}

	function get_chapters()
	{
		$subj=$this->input->post('subj');
		$chapters=$this->ref_text_model->get_chapter_by_subject($subj);
		$str='';
		if($chapters)
		{
			$str.="<option value=''>-Select Chapter-<option>";
			foreach($chapters as $row)
			{
				if(!empty($row->name))
				{
					$topics=$this->input->post('sel');
					$sel=$topics==$row->id?'selected':'';
					$str.="<option {$sel} value='{$row->id}'>{$row->name}</option>";
				}
			}
		}
		else{
			$str.="<option value=''>-Select Chapter-<option>";
		}

		echo $str;
	}

	function save_details()
	{
		$roadmap_id=$this->input->post('roadmap');
		$subj_id=$this->input->post('subject');
		$topics=$this->input->post('topics');
		$details=$this->input->post('details');

		$data=['roadmap_id'=>$roadmap_id,
		'subj_id'=>$subj_id,
		'topics'=>$topics,
		'details'=>$details];

		$this->roadmap_details_model->create($data);
		$this->session->set_flashdata('success', 'Successfully inserted !');
		redirect(base_url().'admin/roadmap/details');
	}

	function edit_details()
	{
		$id=$this->uri->segment(4);
		$data['category']=$this->ref_text_model->where(array('group_id|='=>2))->get();
		$data['details']=$this->roadmap_details_model->find($id);
		$data['roadmap']=$this->roadmap_model->find_by('id',$data['details']->roadmap_id);
		$data['subjects']=$this->ref_text_model->get_ref_text_by_group(3);
		$data['title']='Edit Crash Course Details';
		$this->load->blade('admin.roadmap.edit_details', $data);	
	}


	function edit()
	{
		$id=$this->uri->segment(4);
		$data['category']=$this->ref_text_model->where(array('group_id|='=>2))->get();
		$data['roadmap']=$this->roadmap_model->find($id);
		$data['title']='Edit Crash Course';
		$this->load->blade('admin.roadmap.edit', $data);
	}

	function update_details()
	{
		$id=$this->input->post('hdn_id');
		$roadmap_id=$this->input->post('roadmap');
		$subj_id=$this->input->post('subject');
		$topics=$this->input->post('topics');
		$details=$this->input->post('details');

		$data=['roadmap_id'=>$roadmap_id,
		'subj_id'=>$subj_id,
		'topics'=>$topics,
		'details'=>$details];

		$this->roadmap_details_model->update($id,$data);
		$this->session->set_flashdata('success', 'Successfully updated !');
		redirect(base_url().'admin/roadmap/details');
	}

	/**
	 * update roadmap
	 * @return void
	 */
	function update()
	{
		$id=$this->input->post('hdn_id');
		$category=$this->input->post('category');
		$model_test=$this->input->post('model_test');
		$course_name=$this->input->post('course_name');
		$date=date('Y-m-d',strtotime($this->input->post('date')));
		$display=$this->input->post('display');

		if(!empty($category) && !empty($model_test))
		{
			$data=[
				'category'=>$category,
				'exam_name'=>$course_name,
				'test_id'=>$model_test,
				'study'=>$model_test,
				'exam_date'=>$date,
				'display'=>$display
			];

			$this->roadmap_model->update($id,$data);

			$this->session->set_flashdata('success', 'Course updated successfully !');
			redirect(base_url().'admin/roadmap');
		}

		$this->session->set_flashdata('error', 'Unable to updated !');
		redirect(base_url().'admin/roadmap/edit/'.$id);


	}

	function delete_details()
	{
		$id=$this->uri->segment(4);
		$this->roadmap_details_model->delete($id);

		$this->session->set_flashdata('success', 'Course Topics deleted successfully !');
		redirect(base_url().'admin/roadmap/details');
	}

}

/* End of file roadmap.php */
/* Location: ./application/controllers/admin/roadmap.php */