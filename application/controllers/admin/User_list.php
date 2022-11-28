<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_list extends Admin_Controller {

	private $skey1=-1;
	private $skey2=-1;
	private $skey3=-1;
	private $skey4=0;

	public function __construct() 
	{ 
		parent::__construct(); 
		$this->load->helper('message');
		$this->load->library('pagination');
		$this->load->model('user_model');
		$this->load->helper('common');
		$this->load->model('login_model');
	}
		
	public function index()
	{
		$data['mem_types']=$this->membership_model->get_members();
		$data['title']='User List';
		$this->load->blade('admin/v_user_list',$data);		
	}

	function search_str($terms)
	{
		$stringToFinalReturn='';
        $stringReturned=' where';
        if($terms->mtype!=-1 && !empty($terms->mtype))
        {
            $stringReturned.=" u.mem_type=".$terms->mtype." and ";
        }
        if($terms->status!='')
        {
            $stringReturned.=" u.is_active=".$terms->status." and ";
        }

        if(!empty($terms->email))
        {
        	$stringReturned.=" u.email='".$terms->email."' and ";
        }
        if($stringReturned!=' where')
        {
            $stringToFinalReturn=substr($stringReturned,0,strlen($stringReturned)-4);
            
        }
        $stringToFinalReturn.=" order by u.id desc";
        return $stringToFinalReturn;
	}

	/**
	 * user list to show in datatables
	 * @return json
	 */
	function user_list_dt()
	{
		 $length=$_POST['length'];
		 $term='';
		 $search=$_POST['search']['value'];
		 $filterStr='';
		 if($search){
		     $search_terms=json_decode($search);
		     $term=$this->search_str($search_terms);
		     $filterStr=$term;
		 }
		 
		 $no = $_POST['start'];
		 //$term.=" limit {$no},{$length}";
		$list = $this->user_model->get_users_list($no,$length,$term);
		// var_dump($list);
		$data = array();
		if($list)
		{
		    foreach($list as $item) 
		    {
		        $no++;
		        $row = array();
		        // $ques=strip_tags($item->question);
		        $row[] = $item->user_name;
		        $row[] = $item->email;
		        $row[]=$item->phone;
		        // $pdt=date_create($item->creation_date);
		        // $pdt_f=date_format($pdt,'d M, Y');
		        $row[] = $item->creation_date;
		        $row[] = $item->last_login;
		        $row[]=$this->role_text($item->mem_type);
		        $cked_active=$item->is_active?'checked':'';
		        $cked_active_text=$item->is_active?'Active':'Not Active';
		        $status="<input class='activate' type='checkbox' {$cked_active} value='{$item->id}'/>&nbsp;<span>{$cked_active_text}</span>";
		        $row[] = $status;
		        $change_url=base_url()."admin/user_list/password_change_view/".$item->id;
		        $edit_url='';
		        $delete_url=base_url().'admin/user_list/delete/'.$item->id;
		        $row[] = "<a class='btn btn-mini btn-info' id='pass_change' role='button' data-toggle='modal' data-target='#pass_dlg' href='{$change_url}'><i class='icon icon-edit icon-white'></i>&nbsp;Change Password</a>
			<a href='{$delete_url}' onclick='return(confirm(\"are you sure to delete?\"));' class='btn btn-mini btn-info'><i class='icon icon-trash icon-white'></i>&nbsp;Delete</a>";

		        $data[] = $row;
		    }
		}
		$total=$this->user_model->get_users_total('');
		$total_filtered=$this->user_model->get_users_total($filterStr);
		$output = array(
		                "draw" => $_POST['draw'],
		                "recordsTotal" =>$total ,
		                "recordsFiltered" => $total_filtered,
		                "data" => $data,
		        );
		//output to json format
		echo json_encode($output);
	}

	function role_text($mem_type)
	{
		$role='';
		if($mem_type=='101')
		{
			$role='Admin';
		}
		else if($mem_type=='102')
		{
			$role='Operator';
		}
		else
		{
			if(!empty($mem_type)||$mem_type!=null)
			{
			$role=membership_model::mem_type_text($mem_type);
			}
		}
		return $role;
	}
	
	function get_user_list($start,$limit,$key)
	{
		$users=$this->user_model->get_users($start,$limit,$key);

		$str='';
		if($users){
		foreach ($users as $u) 
		{
			$cked_online=$u->is_online?'checked':'';
			$cked_online_text=$u->is_online?'Online':'Offline';

			$cked_active=$u->is_active?'checked':'';
			$cked_active_text=$u->is_active?'Active':'Not Active';

			$cked_locked=$u->is_locked?'checked':'';
			$cked_locked_text=$u->is_locked?'Locked':'Not Locked';

			$role='';
			if($u->mem_type=='101')
			{
				$role='Admin';
			}
			else if($u->mem_type=='102')
			{
				$role='Operator';
			}
			else
			{
				if(!empty($u->mem_type)||$u->mem_type!=null)
				{
				$role=membership_model::mem_type_text($u->mem_type);
				}
			}
			$change_url=base_url()."admin/user_list/password_change_view/".$u->id;
			$edit_url='';
			$delete_url=base_url().'admin/user_list/delete/'.$u->id;
			$str.="<tr>";
			$str.="<td>{$u->user_name}</td>";
			$str.="<td>{$u->email}</td>";
			$str.="<td>{$u->creation_date}</td>";
			$str.="<td><input disabled {$cked_online} type='checkbox' value='{$u->is_online}'/>&nbsp;{$cked_online_text}</td>";
			$str.="<td><input disabled {$cked_locked} type='checkbox' value='{$u->is_locked}'/>&nbsp;{$cked_locked_text}</td>";
			$str.="<td>{$u->last_login}</td>";
			$str.="<td>{$role}</td>";
			$str.="<td><input class='activate' type='checkbox' {$cked_active} value='{$u->id}'/>&nbsp;<span>{$cked_active_text}</span></td>";
			$str.="<td><a class='btn btn-mini btn-info' id='pass_change' role='button' data-toggle='modal' data-target='#pass_dlg' href='{$change_url}'><i class='icon icon-edit icon-white'></i>&nbsp;Change Password</a>
			<a href='{$delete_url}' onclick='return(confirm(\"are you sure to delete?\"));' class='btn btn-mini btn-info'><i class='icon icon-trash icon-white'></i>&nbsp;Delete</a></td>";
			$str.="</tr>";
			}
		}

		return $str;
	}

	function search_key()
		{
			if($this->uri->segment(4))
			{
				$this->skey1=$this->uri->segment(4);
			}
			if($this->uri->segment(5))
			{
				$this->skey2=$this->uri->segment(5);
			}
			if($this->uri->segment(6))
			{
				$this->skey1=$this->uri->segment(6);
			}

			if($this->uri->segment(7))
			{
				$this->skey4=$this->uri->segment(7);
			}

			$stringToFinalReturn='';
	        $stringReturned=' where';
	        if($this->skey1!=-1 && !empty($this->skey1))
	        {
	            $stringReturned.=" mem_type=".$this->skey1." and ";
	        }
	        if($this->skey2!=-1)
	        {
	            $stringReturned.=" is_active=".$this->skey2." and ";
	        }
	        if($this->skey3!=-1)
	        {
	            $stringReturned.=" is_online=".$this->skey3." and ";
	        }

	        if($this->skey4!=0)
	        {
	            $stringReturned.=" id=".$this->skey4." and ";
	        }

	        if($stringReturned!=' where')
	        {
	            $stringToFinalReturn=substr($stringReturned,0,strlen($stringReturned)-4);
	            
	        }
	        return $stringToFinalReturn;
		}

	function password_change_view()
	{
		$data['user_id']=$this->uri->segment(4);
		$this->load->view('member/password_change',$data);
	}

	function change()
	{
		$uid=$this->input->post('hdn_user_id');
		$pass=$this->input->post('txt_pass');
		$data=array('password'=>sha1($pass));
		try
		{
			$this->login_model->update_by_id($uid,$data);
			$this->session->set_flashdata('success','successfully password changed of '.user_model::get_user_name($uid));
			redirect(base_url().'admin/user_list');
		}
		catch(Exception $ex)
		{
			$this->session->set_flashdata('error', 'unable to change'.$ex->message);
			redirect(base_url().'admin/user_list');
		}

	}

	function delete()
	{
		$id=$this->uri->segment(4);
		$this->user_model->delete($id);
		$this->session->set_flashdata('success','deleted user successfully');
		redirect(base_url().'admin/user_list');
	}


	function activate_user()
	{
		$status=$this->input->get('st');
		$uid=$this->input->get('usr');
		user_model::activate_user_by_id($uid,$status);
		//$uname=user_model::get_user_name($uid);
		//echo $uname;
		$email=user_model::get_user_email($uid);
		if(!empty($uid))
		{
			if($status==0)
			{
				echo success_message("{$email} deactivated successfully!");
			}
			else
			{
				echo success_message("{$email} activated successfully!");
			}
		}
		else
		{
			echo error_message('Unable to change user status!');
		}
	}

	
}