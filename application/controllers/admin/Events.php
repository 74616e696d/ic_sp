<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('events_model');
		$this->load->model('check_in_model');
		$this->load->model('user_model');
		$this->load->helper('text');
	}

	public function index()
	{

		$data['events']=$this->events_model->all();
		
		$data['title']='Upcoming Events';
		$this->load->blade('admin.events.index', $data);	
	}

	/**
	 * create new upcoming events
	 * @return void
	 */
	function create()
	{
		$data['title']='Create New Events';
		$this->load->blade('admin.events.create', $data);
	}


	/**
	 * Save upcoming events to database
	 * @return void
	 */
	function store()
	{
		$name=$this->input->post('ename');
		$details=$this->input->post('details');
		$attachment=$this->input->post('attachment');
		$event_time=$this->input->post('event_time');
		$expire_time=$this->input->post('expire_time');
		$featured_image=$this->input->post('featured_image');
		$display=$this->input->post('display');
		$slide=$this->input->post('slide');

		$data=array('name'=>$name,
			'details'=>$details,
			'attachment'=>$attachment,
			'event_time'=>$event_time,
			'featured_image'=>$featured_image,
			'display'=>$display,
			'expitre_time'=>$expire_time,
			'slide'=>$slide);


		if(!empty($name))
		{
			$eid=$this->events_model->create($data);
			$this->add_default_check_in($eid);
			$this->session->set_flashdata('success', 'Successfully inserted!!');
			redirect(base_url()."admin/events");
		}
		else
		{
			set_old_value($data);
			$this->session->set_flashdata('error', 'Name must be given !!');
			redirect(base_url()."admin/events/create");
		}
	}

	/**
	 * add default check in when creating an event
	 */
	function add_default_check_in($event_id)
	{
		$users=$this->user_model->get_old_users(500);
		if($event_id!=0 && !empty($event_id))
		{
			if($users)
			{
				$check_in_data=[];
				foreach ($users as $user) {
					$data['event_id']=$event_id;
					$data['user_id']=$user->id;
					array_push($check_in_data, $data);
				}
				$this->db->insert_batch('event_check_in',$check_in_data);
			}
		}
		
	}

	/**
	 * show upcoming event edit page
	 * @return void
	 */
	function edit()
	{
		$id=$this->uri->segment(4);
		$data['event']=$this->events_model->find($id);
		
		$data['title']='Edit Upcoming Events';
		$this->load->blade('admin.events.edit', $data);
	}


	/**
	 * update upcoming event
	 * @return void
	 */
	function update()
	{
		$id=$this->input->post('hdn_id');
		$name=$this->input->post('ename');
		$details=$this->input->post('details');
		$attachment=$this->input->post('attachment');
		$event_time=$this->input->post('event_time');
		$expire_time=$this->input->post('expire_time');
		$featured_image=$this->input->post('featured_image');
		$display=$this->input->post('display');
		$slide=$this->input->post('slide');
		

		$data=array('name'=>$name,
			'details'=>$details,
			'attachment'=>$attachment,
			'event_time'=>$event_time,
			'featured_image'=>$featured_image,
			'display'=>$display,
			'expitre_time'=>$expire_time,
			'slide'=>$slide);
		


		if(!empty($name))
		{
			$this->events_model->update($id,$data);
			$this->session->set_flashdata('success', 'Successfully inserted!!');
			redirect(base_url()."admin/events");
		}
		else
		{
			set_old_value($data);
			$this->session->set_flashdata('error', 'Name must be given !!');
			redirect(base_url()."admin/events/edit/".$id);
		}
	}

	/**
	 * delete upcoming event from database
	 * @return void
	 */
	function delete()
	{
		$id=$this->uri->segment(4);
		$this->events_model->delete($id);
		$this->session->set_flashdata('success', 'successfully deleted!!');
		redirect(base_url()."admin/events");
	}

}

/* End of file events.php */
/* Location: ./application/controllers/admin/events.php */