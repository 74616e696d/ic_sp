<?php

class Manage_notification extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('message_model');
		$this->load->model('user_message_model');
		$this->load->model('user_model');
		$this->load->helper('message');
		$this->load->model('membership_model');
	}
	public function index()
	{
		$data['messages']=$this->message_model->all();
		$data['title']='Manage Message &amp; Notifications';
		$this->load->blade('admin.manage_notification', $data);
	}

	public function create()
	{
		$data['members']=$this->membership_model->get_members();
		$data['title']='Add Notification';
		$this->load->blade('admin.add_notification', $data);
	}

	function store()
	{
		$type=$this->input->post('ddl_type');
		$title=$this->input->post('txt_title');
		$details=$this->input->post('txt_details');
		$assign_type=$this->input->post('ddl_assign_type');
		$date=$this->input->post('txt_date');
		$dt=date_create($date);
		$dtf=date_format($dt,'Y-m-d H:i:s');
		$published=$this->input->post('ck_published');
		if(!empty($title))
		{
			$data=array('create_date'=>date('Y-m-d H:i:s'),
				'title'=>$title,
				'details'=>$details,
				'publish_date'=>$dtf,
				'published'=>$published,
				'type'=>$type,
				'assign_to'=>$assign_type);

			$this->message_model->create($data);
			$this->session->set_flashdata('success', 'successfully saved!');
			redirect(base_url().'admin/manage_notification');
		}
		else
		{
			$this->session->set_flashdata('error', ' title must be given!');
			redirect(base_url().'admin/manage_notification/create');
		}
	}

	function edit()
	{
		$id=$this->uri->segment(4);
		$data['message']=$this->message_model->find($id);
		$data['members']=$this->membership_model->get_members();
		$data['title']='Edit Notification';
		$this->load->blade('admin.edit_notification', $data);
	}

	function update()
	{
		$id=$this->input->post('hdn_id');
		$type=$this->input->post('ddl_type');
		$title=$this->input->post('txt_title');
		$details=$this->input->post('txt_details');
		$assign_type=$this->input->post('ddl_assign_type');
		$date=$this->input->post('txt_date');
		$dt=date_create($date);
		$dtf=date_format($dt,'Y-m-d H:i:s');
		$published=$this->input->post('ck_published');
		if(!empty($title))
		{
			$data=array('title'=>$title,
				'details'=>$details,
				'publish_date'=>$dtf,
				'published'=>$published,
				'type'=>$type,
				'assign_to'=>$assign_type);

			$this->message_model->update($id,$data);
			$this->session->set_flashdata('success', 'successfully updated!');
			redirect(base_url().'admin/manage_notification');
		}
		else
		{
			$this->session->set_flashdata('error', ' title must be given!');
			redirect(base_url()."admin/manage_notification/edit/{$id}");
		}
	}

	function assign_view()
	{
		$data['users']=$this->user_model->active_users();

		$data['msg_id']=$this->uri->segment(4);
		$data['title']='Assign Message To Users';
		$this->load->blade('admin/message_assign_view', $data);
	}

	function assign()
	{
		$msg_id=$this->input->post('hdn_id');
		$users=$this->input->post('ck_assign');
		$published=$this->input->post('ck_published');
		if($users)
		{
			$i=0;
			foreach ($users as $usr) 
			{
				$data=array('user_id'=>$usr,
					'message_id'=>$msg_id,
					'published'=>$published[$i]);
				if($this->user_message_model->exists($usr,$msg_id))
				{
					$this->user_message_model->update_by_user($usr,$msg_id,array('published'=>$published[$i]));
				}
				else
				{
					$this->user_message_model->create($data);
				}
				$i++;
			}
		}

	}

	function group_assign()
	{
		$id=$this->input->post('id');
		$message=$this->message_model->find($id);
		if($message->assign_to !='1' && $message->assign_to!='5')
		{
			$users=$this->user_model->active_user_by_group($message->assign_to);
			if($users)
			{
				foreach ($users as $usr) {
					$data=array('user_id'=>$usr->id,
						'message_id'=>$id,
						'published'=>'1');
					if(!$this->user_message_model->exists($usr->id,$id))
					{
						$this->user_message_model->create($data);
					}
				}
				echo "Successfully assigned";
			}

		}
		
	
	}
	function delete()
	{
		$id=$this->uri->segment(4);
		$this->message_model->delete($id);
		$this->session->set_flashdata('success', 'successfully updated!');
		redirect(base_url().'admin/manage_notification');
	}

}

/* End of file manage_notification.php */
/* Location: ./application/controllers/admin/manage_notification.php */