<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use Carbon\Carbon;
class Conf_payment extends CI_Controller {
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
    	$this->load->helper('notify');
    	$this->load->helper('message');
    	$this->load->model('member/upgrade_model','upgrade');
    	$this->load->model('permission_model');
		$this->load->model('membership_model');
		$this->load->model('message_model');
		$this->load->model('user_model');
    	$this->load->model('user_message_model');
    	$this->config->load('mail_setting');
    	$this->load->model('trans_history_model');
    	$this->load->model('upgrade_history');

	}

	public function index()
	{
		$member=['One Month'=>3,
			'Two Month'=>8,
			'Three Month'=>4,
			'Six Months'=>5,
			'One Year'=>6];
		$requested_for=$this->uri->segment(4);//requested package typ
		$mem_text=str_replace('_', ' ', $requested_for);
		//$day=$this->uri->segment(5);//Requested days for membership
		$day=$this->membership_model->mem_type[$mem_text];
		$rate=$this->membership_model->rate();
		$amount=$this->permission_model->get_amount($member[$mem_text]);
		$upgrade=$this->upgrade->find_by_user($this->userid);
		$current_mem_type=$upgrade?$upgrade->mem_type:2;
		$expire_date=$this->membership_model->expire_date($day);
		$tm=time();
		$data['trans_id']=$tm."{$this->userid}";

		$data['expire']=$expire_date;
		$data['requested_for']=$mem_text;
		$data['requested_mem_text']=membership_model::get_text($requested_for);
		$allowed=range(3,8);
		$gross_amount=0;

		// $amount=round($amount-((trim($amount)*70)/100));
		//$amount=500;
		$gross_amount=$amount;

		$discode = $this->uri->segment(6);
		$discount = 0;
		$discount_amount = 0;
		$total_ammount = $amount;
		if($discode != '' || $discode != 'n0n3'){
			$discount = $this->permission_model->check_discount($discode);
			if($discount != 0){
				$discount_amount = ($amount * $discount) / 100 ;
				$amount =$amount - $discount_amount;
			}
		}

		$data['day']=$day;
		$data['total']=$total_ammount;
		$data['discount']=$discount_amount;
		$data['amount']=$amount;
		$data['current_membership']=$current_mem_type;
		$data['current_membership_text']=membership_model::get_text($current_mem_type);

		$data['title']='Confirm Your Payment';
		$this->load->blade('public.conf_payment', $data);
	}

	public function index_back()
	{
		$requested_for=$this->uri->segment(4);
		$day=$this->uri->segment(5);
		$amount=$this->permission_model->get_amount($requested_for);
		$upgrade=$this->upgrade->find_by_user($this->userid);
		$current_mem_type=$upgrade?$upgrade->mem_type:2;
		$duration=$this->permission_model->get_duration($requested_for);
		$expire_date=Carbon::now()->addDays(trim($duration));
		$tm=time();
		$data['trans_id']=$tm."{$this->userid}";

		$data['expire']=$expire_date;
		$data['requested_for']=$requested_for;
		$data['requested_mem_text']=membership_model::get_text($requested_for);
		$allowed=range(3,8);
		$gross_amount=0;

		$discount=round($amount-((trim($amount)*40)/100));
		$gross_amount=$discount;

		$data['amount']=$amount;
		$data['current_membership']=$current_mem_type;
		$data['current_membership_text']=membership_model::get_text($current_mem_type);

		$data['title']='Confirm Your Payment';
		$this->load->blade('public.conf_payment', $data);
	}

	/**
	 * perform success action
	 */
	function success()
	{
		if($_POST['val_id'])
		{
			$val_id = $_POST['val_id'];

			try
			{
				$c = new SoapClient('https://www.sslcommerz.com.bd/validator/validationserver.php?wsdl');
			}
			catch (Exception $e)
			{
				echo 'Caught exception: ', $e->getMessage(), "\n";
			}
			$amount=$this->uri->segment(4);
			$day=$this->uri->segment(5);
			$store_id=$this->uri->segment(6);
			$res = $c->checkValidation($val_id,$store_id,$amount); // here $res will get ‘VALID’ if the transaction is a valid one
			$msg='';
			// if(0==0)
			if (strcmp($res, "VALID") == 0)
			{
				$tran_id=$_POST['tran_id'];
				//$tran_id='0199818181';
				// $amount=$this->uri->segment(4);
				// $day=$this->uri->segment(5);
				$mtype=$this->membership_model->premium_member_id;
				$this->process_member($tran_id,$amount,$mtype,$day);
				$msg= "successfully paid";
			}
			else
			{
				$msg= "Incomplete Payment";
			}

			$data['success_msg']=$msg;
			$data['title']='';

			$this->load->blade('public.success_payment', $data);
		}
		else
		{
			redirect(base_url().'member/dashboard');
		}
	}

	function fail_payment()
	{
		$data['title']='';
		$this->load->blade('public.fail_payment', $data);
	}

	function process_member($tid,$amount,$mtype,$day)
	{
		$data=array(
			'trans_id'=>$tid,
			'amount'=>$amount
			);


		if(!$this->trans_history_model->exist('trans_id',$tid))
		{
			$this->trans_history_model->create($data);
		}
		$this->user_model->update_user($this->userid,array('mem_type'=>$mtype));

		$now=Carbon::now()->toDateTimeString();
		$expiry=$this->membership_model->expire_date($day);
		$update_data=array('mem_type'=>$mtype,
			'status'=>'2',
			'req_date'=>$now,
			'exp_date'=>$expiry->toDateTimeString(),
			'approval_date'=>$now
			);
		$add_date=array(
			'user_id'=>$this->userid,
			'mem_type'=>$mtype,
			'status'=>'2',
			'req_date'=>$now,
			'exp_date'=>$expiry->toDateTimeString(),
			'approval_date'=>$now
			);

		if(!$this->upgrade->exists($this->userid))
		{
			$req_id=$this->upgrade->add($data);
		}
		else
		{
			$req_id=$this->upgrade->update($this->userid,$update_data);
		}


		//add upgrade history
		$total_days=$this->get_total_days(date('Y-m-d H:i:s'),$expiry);
		$source='online';
		$data_upgrade_history=array(
			'user_id'=>$this->userid,
			'member_type'=>$mtype,
			'amount'=>$amount,
			'duration'=>$total_days,
			'source'=>$source,
			'created_at'=>date('Y-m-d H:i:s'),
			'updated_at'=>date('Y-m-d H:i:s')
			);
		$this->upgrade_history->create($data_upgrade_history);
		//end add upgrade history
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

/* End of file conf_payment.php */
/* Location: ./application/controllers/public/conf_payment.php */
