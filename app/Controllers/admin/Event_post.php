<?php

class Event_post extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('events_model');
		$this->load->model('event_post_model');
		$this->load->helper('text');
	}

	public function index()
	{
		$data['events']=$this->events_model->all();
		// $data['posts']=$this->event_post_model->all_post();
		$data['title']='Event Posts';
		$this->load->blade('admin.event_post.index', $data);
	}


	function event_post_list_dt()
	{
		 $length=20;
		 $term='';
		 $search=$_POST['search']['value'];
		 $filterStr='';
		 if($search){
		     $search_terms=json_decode($search);
		     $searchStr=' where';
		     if(!empty($search_terms->cat))
		     {
		         $searchStr.=" event_id={$search_terms->cat} and ";
		     }

		     if(!empty($search_terms->title))
		     {
		         $searchStr.=" post_title LIKE '%{$search_terms->title}%' and ";
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
		$list = $this->event_post_model->all_post($term);
		
		$data = array();
		if($list)
		{
		    foreach($list as $item) 
		    {
		        $no++;
		        $row = array();
		        // $ques=strip_tags($item->question);
		        $row[] = $item->name;
		        $row[] = $item->post_title;
		        $dtls=word_limiter($item->post_details,20);
		        $row[] = $dtls;
		        $display=$item->display?'Published':'Not Published';
		        $row[] = $display;
		        $edit_url=base_url().'admin/event_post/edit/'.$item->id;
		        $delete_url=base_url().'admin/event_post/delete/'.$item->id;
		        $row[] = "<a class='btn btn-small btn-primary' title='Edit' href='{$edit_url}'><i class='fa fa-edit'></i></a>
		              <a onclick='return(confirm(\"are you sure to delete?\"))' class='btn btn-small btn-danger' href='{$delete_url}' title='Delete'><i class='fa fa-trash-o'></i></a>";

		        $data[] = $row;
		    }
		}
		$total=$this->event_post_model->count_all();
		$total_filtered=$this->event_post_model->count_all($filterStr);
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
		$data['events']=$this->events_model->all();
		$data['title']='New Event Post';
		$this->load->blade('admin.event_post.create', $data);
	}

	function store()
	{
		$event_id=$this->input->post('event_id');
		$post_title=$this->input->post('post_title');
		$post_details=$this->input->post('details');
		$post_date=date('Y-m-d H:i:s');
		$user_id=$this->userid;
		$display=$this->input->post('ck_display');

		if(!empty($event_id))
		{
			$data=['event_id'=>$event_id,
			'post_title'=>$post_title,
			'post_details'=>$post_details,
			'post_date'=>$post_date,
			'user_id'=>$user_id,
			'display'=>$display];
			$this->event_post_model->create($data);
			$this->session->set_flashdata('success', 'successfully inserted !!');
			redirect(base_url()."admin/event_post");
		}
		else{
			set_old_value($data);
			$this->session->set_flashdata('error', 'You must select an event !!');
			redirect(base_url()."admin/event_post/create");
		}
	}

	function edit()
	{
		$id=$this->uri->segment(4);
		$data['event']=$this->event_post_model->find($id);
		$data['events']=$this->events_model->all();
		$data['title']='Edit Event Post';
		$this->load->blade('admin.event_post.edit', $data);
	}

	function update()
	{
		$id=$this->input->post('hdn_id');
		$event_id=$this->input->post('event_id');
		$post_title=$this->input->post('post_title');
		$post_details=$this->input->post('details');
		$post_date=date('Y-m-d H:i:s');
		$user_id=$this->userid;
		$display=$this->input->post('ck_display');

		if(!empty($event_id))
		{
			$data=['event_id'=>$event_id,
			'post_title'=>$post_title,
			'post_details'=>$post_details,
			'post_date'=>$post_date,
			'user_id'=>$user_id,
			'display'=>$display];
			$this->event_post_model->update($id,$data);
			$this->session->set_flashdata('success', 'successfully updated !!');
			redirect(base_url()."admin/event_post");
		}
		else{
			set_old_value($data);
			$this->session->set_flashdata('error', 'You must select an event !!');
			redirect(base_url()."admin/event_post/create");
		}
	}

	function delete()
	{
		$id=$this->uri->segment(4);
		$this->event_post_model->delete($id);
		$this->session->set_flashdata('success', 'successfully deleted !!');
		redirect(base_url()."admin/event_post");
	}

}

/* End of file event_post.php */
/* Location: ./application/controllers/admin/event_post.php */