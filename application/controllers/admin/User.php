<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Admin_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('user_model');
		$this->load->library('phpass');
		$this->load->helper('message');
		$this->load->helper('common');

	}
	public function index()
	{
		$data['title']='Create New User';
		$data['main_content']='admin/v_user';
		$this->load->view('layout_admin/admin_layout', $data);
	}
	function add()
	{
		$mem_type=$this->input->post('rd_role');
		$user_name=$this->input->post('txt_user_name');
		$email=$this->input->post('txt_email');
		$password=$this->input->post('txt_password');
		$pass_retype=$this->input->post('txt_con_pass');
		$creation_date=date('Y-m-d H:i:s');
		$last_login=date('Y-m-d H:i:s');
		$is_online=0;
		$is_active=1;
		$is_locked=0;
		$key = md5(microtime().rand());

		$data=array(
			'user_name'=>$user_name,
			'email'=>$email,
			'password'=>sha1($password),
			'creation_date'=>$creation_date,
			'last_login'=>$last_login,
			'is_online'=>$is_online,
			'is_active'=>$is_active,
			'is_locked'=>$is_locked,
			'mem_type'=>$mem_type,
			'user_key'=>$key
			);
		$data_details=array('user_id'=>'');

		if(!empty($mem_type))
		{
			if(!empty($user_name)){
				if($password==$pass_retype)
				{
					if(!user_model::user_exist($user_name))
					{
						if(!user_model::email_exist($email))
						{
						$user_id=$this->user_model->add_user($data,$data_details);
						$this->session->set_flashdata('success', 'user created successfully!');
						redirect(base_url().'admin/user_list');
						}
						else
						{
							$this->session->set_flashdata('warning', 'email already exists!!');
							redirect(base_url().'admin/user');
						}
					}
					else
					{
						$this->session->set_flashdata('warning', 'this user already exists!!');
						redirect(base_url().'admin/user');
					}
				}
				else{
					$this->session->set_flashdata('warning', 'password and confirm password does not match!!');
					redirect(base_url().'admin/user');
				}

			}
			else{
				$this->session->set_flashdata('warning', 'user name must be given!');
				redirect(base_url().'admin/user');
			}
		}
		else
		{
			$this->session->set_flashdata('warning', 'member type must be selected!');
			redirect(base_url().'admin/user');
		}
	}

	function check_user()
	{

	}

}

/* End of file user.php */
/* Location: ./application/controllers/admin/user.php */