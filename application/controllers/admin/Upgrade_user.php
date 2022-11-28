<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use Carbon\Carbon;
class Upgrade_user extends Admin_Controller {

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
		$this->load->model('membership_model');
		$this->load->model('member/upgrade_model','upgrade');
		$this->load->model('upgrade_history');
	}
		
	public function index()
	{
		$data['mem_types']=$this->membership_model->get_members();
		$key=$this->search_key();
		$start=0;
		$limit=30;
		$ppg=30;
		if($this->uri->segment(8))
		{
			$start=$this->uri->segment(8);
		}
		$total=$this->user_model->get_total($key);
		
		$data['users']=$this->get_user_list($start,$limit,$key);
		$urisegment=8;
		$baseurl=base_url().'admin/upgrade_user/index/'.$this->skey1.'/'.$this->skey2.'/'.$this->skey3.'/'.$this->skey4.'/';
		$data['page']=create_pagination($baseurl,$total,$urisegment,3,$ppg);
		$data['title']='User List';
		$this->load->blade('admin.upgrade_user',$data);		
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
			$change_url=base_url()."admin/upgrade_user/password_change_view/".$u->id;
			$edit_mem_url=base_url()."admin/upgrade_user/edit_membership/".$u->id;
			$edit_url='';
			$delete_url=base_url().'admin/upgrade_user/delete/'.$u->id;
			$str.="<tr>";
			$str.="<td>{$u->user_name}</td>";
			$str.="<td>{$u->email}</td>";
			$str.="<td>{$u->creation_date}</td>";
			$str.="<td><input disabled {$cked_online} type='checkbox' value='{$u->is_online}'/>&nbsp;{$cked_online_text}</td>";
			$str.="<td><input disabled {$cked_locked} type='checkbox' value='{$u->is_locked}'/>&nbsp;{$cked_locked_text}</td>";
			$str.="<td>{$u->last_login}</td>";
			$str.="<td>{$role}</td>";
			$str.="<td><input class='activate' type='checkbox' {$cked_active} value='{$u->id}'/>&nbsp;<span>{$cked_active_text}</span></td>";
			$str.="<td><a class='btn btn-mini btn-info' role='button' data-toggle='modal' data-target='#edit_mem_dlg' href='{$edit_mem_url}'><i class='icon icon-edit icon-white'></i>&nbsp;Edit Membership</a>
			<a class='btn btn-mini btn-info' id='pass_change' role='button' data-toggle='modal' data-target='#pass_dlg' href='{$change_url}'><i class='icon icon-edit icon-white'></i>&nbsp;Change Password</a>
			<a href='{$delete_url}' onclick='return(confirm(\"are you sure to delete?\"));' class='btn btn-mini btn-info'><i class='icon icon-trash icon-white'></i>&nbsp;Delete</a></td>";
			$str.="</tr>";
			}
		}

		return $str;
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
			redirect(base_url().'admin/upgrade_user');
		}
		catch(Exception $ex)
		{
			$this->session->set_flashdata('error', 'unable to change'.$ex->message);
			redirect(base_url().'admin/upgrade_user');
		}

	}

	function delete()
	{
		$id=$this->uri->segment(4);
		$this->user_model->delete($id);
		$this->session->set_flashdata('success','deleted user successfully');
		redirect(base_url().'admin/upgrade_user');
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

	function edit_membership()
	{
		$uid=$this->uri->segment(4);
		$current_mid=$this->user_model->find($uid);
		if($current_mid->mem_type==2)
		{
			$data['current_membership']='Trial';
		}
		else
		{
			$data['current_membership']='Premium';
		}
		$data['memberhsip']=$this->membership_model->get_members();
		$data['uid']=$uid;
		$data['title']='';
		$this->load->blade('admin.upgrade', $data);
	}

	function update_membership()
	{
		$mtype=$this->membership_model->premium_member_id;
		$uid=$this->input->post('hdn_uid');
		$day=$this->input->post('ddl_day');
		$start=$this->input->post('start_date');
		$start_d=date_create($start);
		$start_df=date_format($start_d,'Y-m-d H:i:s');
		$end=$this->input->post('end_date');
		$end_d=date_create($end);
		$end_df=date_format($end_d,'Y-m-d H:i:s');
		$today=date('Y-m-d H:i:s');

		$m_id=9;
		if($day==30){
			$m_id=3;
		}elseif ($day==60) {
			$m_id=8;
		}elseif ($day==90) {
			$m_id=4;
		}elseif ($day==180) {
			$m_id=5;
		}elseif ($day==360) {
			$m_id=6;
		}

		$exp_date=null;
		if($day!=10)
		{
			$exp_date=$this->membership_model->expire_date($day,$start_df);
		}
		else
		{
			$exp_date=$end_df;
		}
	

		$data_user=array(
			'mem_type'=>$mtype,
			'update_date'=>$today
			);

		$data_upgrade=[
			'mem_type'=>$mtype,
			'req_date'=>$today,
			'approval_date'=>$start_df,
			'exp_date'=>(string)$exp_date];

		$this->user_model->update_user($uid,$data_user);
		$udtl=$this->upgrade->exists($uid);
		if(!$udtl)
		{
			$data_new_upgrade=array(
				'user_id'=>$uid,
				'status'=>2,
				'mem_type'=>$mtype,
				'req_date'=>$start_df,
				'approval_date'=>$start_df,
				'exp_date'=>(string)$exp_date);
			$this->upgrade->add($data_new_upgrade);

		}
		else
		{
			$this->upgrade->update($uid,$data_upgrade);
		}


		//add upgrade history
		$amount=Membership_model::get_payable_amount($m_id);
		$total_days=$this->get_total_days($start,$exp_date);
		$source=$this->input->post('ref_no');
		$data_upgrade_history=array(
			'user_id'=>$uid,
			'member_type'=>$mtype,
			'amount'=>$amount,
			'duration'=>$total_days,
			'source'=>$source,
			'created_at'=>date('Y-m-d H:i:s'),
			'updated_at'=>date('Y-m-d H:i:s')
			);
		$this->upgrade_history->create($data_upgrade_history);
		//end add upgrade history

		$this->session->set_flashdata('success', 'Selected user membership changed!!');
		redirect(base_url()."admin/upgrade_user");

	}

	function get_total_days($start,$end)
	{
		$start_date = strtotime($start);
		$end_date = strtotime($end);
		$datediff = $end_date - $start_date;

		$days= floor($datediff / (60 * 60 * 24));
		return $days;
	}

	
}