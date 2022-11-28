<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use Carbon\Carbon;
class Upgrade extends CI_Controller {

	var $userid=0;
	var $utype=0;
	var $email='';
	var $username='';
	var $msg='';
	function __construct()
	{
		parent::__construct();
		$this->load->model('permission_model');
		if($this->session->userdata('userid'))
    	{
    		$this->userid=$this->session->userdata('userid');
    		$this->utype=$this->session->userdata('utype');
    		$this->email=$this->session->userdata('email');
    		$this->username=$this->session->userdata('username');

    	}
		$this->load->model('member/upgrade_model','upgrade');
		$this->load->model('membership_model');
		$this->load->helper('notify');
		$this->load->helper('message');
		$this->load->model('message_model');
    	$this->load->model('user_message_model');
    	$this->config->load('mail_setting');
	}

	public function index()
	{
		$message='';
		//$mem_arr=array(2,3,4,5,6);
		$expired=$this->permission_model->is_expired($this->userid);
		$upgrade=$this->upgrade->find_by_user($this->userid);
		$mtype=$upgrade?$upgrade->mem_type:0;
		$status=$upgrade?$upgrade->status:0;
		$pending=false;
		if($upgrade)
		{
			if($upgrade->status==1)
			{
				$pending=true;
			}
		}
		$date_remains=$this->permission_model->date_remains($this->userid);


		//$data['pending']=$this->upgrade->pending_count($this->userid);
		$data['message']=$this->member_message($mtype,$status,$date_remains);
		$data['expired']=$expired;
		$data['membership']=$this->membership_plan($mtype,$status,$discount);
		$data['utype']=$this->utype;
		$data['title']='Choose a package';
		$data['pending']=$pending;
		$this->load->blade('public.upgrade', $data);		
	}



	function member_message($mem_type,$status,$date_remains)
	 {
	     $roles=array('101','102','105');

	     $str='';
	     if(!in_array($mem_type,$roles))
	     {
	         $member_type=membership_model::get_text($mem_type);
	         $amount=$this->permission_model->get_amount($mem_type);
	         if($mem_type==2)
	         {
	             if($status==2)
	             {
	                 if($date_remains<=0)
	                 {
	                     $str.="<li>Your {$member_type} has been expired !";
	                     $str.=" Please upgrade to continue</li>";
	                 }
	                 else
	                 {
	                     $str.="<li>Your are enjoying  <span>{$member_type}</span> membership!";
	                     $str.=" Your membership will expire in {$date_remains} days</li>";
	                 }
	             }
	             else
	             {

	             }                
	            
	         }
	         else
	         {
	             if($status==2)
	             {
	                 if($date_remains<=0)
	                 {
	                     $str.="<li>Your {$member_type} has been expired !";
	                     $str.=" Please upgrade to continue</li>";
	                 }
	                 else
	                 {
	                     $str.="<li>Your are enjoying  {$member_type} membership!";
	                     $str.=" Your membership will expire in {$date_remains} days</li>";
	                 }
	             }
	             elseif($status==1)
	             {
	                 $str.="<li>Your {$member_type} membership request is under process!";
	                 $str.=" Please send Tk.{$amount} to <span class='bkash_1'>b</span><span class='bkash_2'>Kash</span> number  <span style='color:red;'>01917777021</span> to activate you membership</li>";
	             }
	             else
	             {
	             	  $str.="<li>Your {$member_type} has been expired !";
	                  $str.=" Please upgrade to continue</li>";
	             }
	         }
	       
	     }
	     else
	     {
	         $str.="<li>Admin does not need any membership plan</li>";
	     }
	     return $str;
	 }


	function remove_pending()
	{
		$this->upgrade->reset_pending($this->userid);
		$this->session->set_flashdata('success', 'Your pending request successfully reset!!');
		redirect(base_url().'public/upgrade');
	}

	function membership_plan($mtype,$status,$discount)
	{
		$premium_id=$this->membership_model->premium_member_id;
		$membership=$this->membership_model->membership();
		$str='';
		if(count($membership)>0){
			$pending=$this->upgrade->has_pending($this->userid);
			$expired=$this->permission_model->is_expired($this->userid);
			$disbaled=$pending?'disabled':'';
			$str.="<div class='row'>";
			$str.="<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
			$str.="<h4>Choose a package</h4>";
			$str.="</div>";
			$str.="<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 price-list'>";

			// Start Notice
			// $str.="<div class='alert alert-danger'>";
			// $str.="<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
			// $str.="<strong><i class='fa fa-exclamation-circle'></i></strong> Get Six Month access for everything @BDT 500 only.<br/> <span>This Offer is Valid Till 8th August 2016. Save 700 Tk. Now!</span>";
			// $str.="</div>";
			// End Notice

			$str.="";
			$allowed=range(3,8);


			$member=[
			//'One Month'=>3,
			//'Two Month'=>8,
			//'Three Month'=>4,
			'Six Months'=>5,
			'One Year'=>6];


			foreach ($member as $key=>$value)
			{
				// if($key=='Six Month'){
				$amount=$this->permission_model->get_amount($member[$key]);
				
				// $amount=$this->membership_model->get_amount($value);
				$cked='';
				if(!$expired)
				{
					if($status!=0)
					{
						$cked='checked';
					}
				}


				$original=$amount;
				
				// $amount=round($amount-((trim($amount)*70)/100));
				//$amount=500;

				$str.="<div class='col-lg-3 col-md-3 col-sm-12 col-xs-12 pk text-center'>";

				$str.="<input type='radio' style='display:none' name='rd_grade' value='{$premium_id}'/>";
				// $str.="<p><h4>{$key}</h4><span><del>Tk. {$original}</del></span><br/>";
				$str.="<p><h4>{$key}</h4><br/>";
				$str.="<p>Tk. {$amount}</span><br/>";
				$str.="<div class='row' style='margin: 10px 0px 0px;'><div class='col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right' style='padding: 8px 0px;'>Discount Code</div><div class='col-lg-8 col-md-8 col-sm-8 col-xs-8'><input type='text' name='code_{$key}' value='' style='width: 100%;margin-top:4px;background: #e9eaee;border: 1px solid #0177bf;padding: 5px;border-radius: 4px;color: #848484;' /></div></div>";
				$hidden_name=str_replace(' ','_',$key);
				$str.="<input type='hidden' name='hdn_day_{$key}' value='{$value}'>";
				$str.="<button type='submit' class='btn btn-mini btn-primary' name='btn_send' value='{$hidden_name}'>Send Request</button></p>";
				
				$str.="</div>";
				// } //end if twelve month package
				
			}
			$str.="</div>";
			$str.="</div>";
			//$str.="<button {$disbaled} class='btn btn-primary' type='submit'><i class='fa fa-save'></i>&nbsp;Send Request</button>";
			
		}
		return $str;
	}

	function send()
	{
		$mtype=$this->input->post('btn_send');
		$day=$this->input->post('hdn_day_'.$mtype);
		$code = $this->input->post('code_'.$mtype);
		if($code == null || $code == ''){
			$code = 'n0n3';
		}
		$upgrade=$this->upgrade->find_by_user($this->userid);
		$current_mem_type=$upgrade?$upgrade->mem_type:2;
		if($this->utype!='101' && $this->utype!='102')
		{
			$str_url=base_url()."public/conf_payment/index/{$mtype}/{$day}/{$code}/";
			redirect($str_url);
		}
		else
		{
			$this->session->set_flashdata('error', 'Admin or operator need not send any upgrade request!');
			redirect($this->index());	
		}

	}


	function message_details($m)
	{
		$msg_details='';
		$msg_details.="<p>";
		$mtxt=membership_model::get_text($m);
		$lnk=base_url()."public/upgrade_confirmation/index/{$m}";
		$msg_details.="<h4 style=''>Thank you for sending {$mtxt} membership upgrade request </h4>";
		$msg_details.="Please pay by bkash and send your bkash code .Send bkash code  <a href='{$lnk}'>here</a>";
		$msg_details.="</p>";
		return $msg_details;
	}

	function upgrade_mail($from,$mem_type,$amount)
	{
		$mtext=membership_model::get_text($mem_type);
		$url=base_url()."public/upgrade_confirmation/index/{$mem_type}";
		$company="Iconpreparation";
		$msg='';
		$msg.="<div>";
		$msg.="<h2>Thank you for requesting for  {$mtext} membership in studypress.com<h2>";
		$msg.="<p><strong>Please send Tk. {$amount} bt Bkash and active your account by sending bkash code in the following link</p>";
		

		$msg.="</div>";
		$msg.="<div style='width:100%;margin:0 auto;padding:13px 9px;font-weight:bold;height:40px;background:#2791D1;font-size:16px;'>";
		$msg.="Please <a href='$url' target='_blank'>Click here</a> to send bkash code or send it";
		$msg.="</div>";

		$config = Array(
		  'protocol' => $this->config->item('protocal'),
		  'smtp_host' => $this->config->item('smtp_host'),
		  'smtp_port' => $this->config->item('port'),
		  'smtp_user' => $this->config->item('smtp_user'),
		  'smtp_pass' => $this->config->item('smtp_pass'),
		  'mailtype' => 'html',
		  'charset' => 'utf-8',
		  'wordwrap' => TRUE
		);

	      $this->load->library('email', $config);
	      $this->email->set_newline("\r\n");
	      $this->email->from($this->config->item('smtp_user')); 
	      $this->email->to($from);
	      $this->email->subject("Membership upgrade request in studypress");
	      $this->email->message($msg);
	      if($this->email->send())
	     {
	      	return 'Your upgrade request mail has been sent successfully.';
	     }
	     else
	     {
	     	return $this->email->print_debugger();
	     }
		
	}

}

/* End of file upgrade.php */
/* Location: ./application/controllers/public/upgrade.php */