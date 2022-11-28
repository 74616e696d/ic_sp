<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('membership_model');
		$this->load->library('my_validation');
		$this->load->helper('message');
	}

	public function index()
	{
		$data['members']=$this->membership_model->get_members();
		$data['user']=$this->user_model->get_user_details(1);
		$data['sitemap']=array('Home','Login','Dashboard','Profile');
		$data['main_content']='member/v_profile';
		$this->load->view('layout/master_inner',$data);
	}

	function save()
	{
		$id=$this->input->post('hdn_uid');
		$email=$this->input->post('txt_email');
		$mem_type=$this->input->post('ddl_mem_type');
		$full_name=$this->input->post('txt_full_name');
		$address=$this->input->post('txt_address');
		$phone=$this->input->post('txt_phone');

		$ck_display=$this->input->post('ck_display');


		$photo_old=$this->input->post('hdn_old_img');
		$photo=$this->input->post('hdn_new_img');

		$img_name=$photo_old;
		
		$rules=array('txt_email|email'=>'required|email');
		if($this->my_validation->validate($_POST,$rules))
		{
			if(!empty($photo))
			{
				if(!empty($photo_old))
				{
					if(file_exists('asset/images/upload/'.$photo_old))
					{
						unlink('asset/images/upload/'.$photo_old);
					}
					$img_name=$this->img_upload('fl_image');
				}else
				{
					$img_name=$this->img_upload('fl_image');
				}
			}


			$data_user=array();
			//filling data_user depending on password change
			if($ck_display)
			{
				
				$pass=$this->input->post('txt_pass');
				$con_pass=$this->input->post('txt_con_pass');
				if($pass==$con_pass)
				{
					$data_user=array('email'=>$email,
					'mem_type'=>$mem_type,'password'=>sha1($new_pass));
				}
				else{
					$this->session->set_flashdata('error', 'password and retype password does not match');
					redirect(base_url().'member/profile');

				}
				
			}
			else
			{
				$data_user=array('email'=>$email,
				'mem_type'=>$mem_type);
			}
			//end filling data_user depending on password change
			
			$data_user=array('email'=>$email,
				'mem_type'=>$mem_type);
			$data_user_details=array('full_name'=>$full_name,
				'address'=>$address,
				'phone'=>$phone,
				'photo'=>$img_name);
	
			$this->user_model->update_user($id,$data_user);
			$this->user_model->update_user_details($id,$data_user_details);
			$this->session->set_flashdata('success','successfully saved!');
			redirect(base_url().'member/profile');

		}
		else
		{
			$msg=$this->my_validation->erorrs;
			$this->session->set_flashdata('msg',$msg);
			redirect(base_url().'member/profile');
		}
	}

	function img_upload($control_name)
	{
		$fl_name='';
		$fl_type='';
		$config['upload_path'] = './asset/images/upload/'; 
        $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
        $config['encrypt_name']=TRUE;
         $this->load->library('upload',$config);
          if($this->upload->do_upload($control_name))
          {
            $udata=$this->upload->data();
            $fl_name=$udata['file_name'];
			return $fl_name;
          }
          else
          {
            $error=$this->upload->display_errors();
            echo $error;	
          }		
	}
}

/* End of file profile.php */
/* Location: ./application/controllers/member/profile.php */