<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}
use Carbon\Carbon;

class Upgrade_request extends Admin_Controller {

	var $sel_mtype    = -1;
	var $sel_status   = -1;
	var $sel_req_date = 'na';
	var $sel_exp_date = 'na';
	var $sel_uid=0;
	function __construct() {
		parent::__construct();
		$this->load->model('member/upgrade_model', 'upgrade');
		$this->load->model('user_model');
		$this->load->library('pagination');
		$this->load->helper('common');
		$this->load->model('permission_model');
		$this->load->model('membership_model');
		$this->load->model('user_detail_model');
		//$this->output->enable_profiler(true);
	}

	public function index() {
		$start    = 0;
		$limit    = 20;
		$uri_seg  = 9;
		$numlinks = 5;
		$perpage  = 20;
		if ($this->uri->segment(9)) {
			$start = $this->uri->segment(9);
		}
		$base_url        = base_url() . "admin/upgrade_request/index/{$this->sel_mtype}/{$this->sel_status}/{$this->sel_req_date}/{$this->sel_exp_date}/{$this->sel_uid}";
		$term            = $this->terms();
		$ttl             = $this->upgrade->total_request($term);
		$data['request'] = $this->request_list($start, $limit, $term);
		$data['pagi']    = create_pagination($base_url, $ttl, $uri_seg, $numlinks, $perpage);

		$data['membership'] = $this->membership_model->get_members();

		$data['sel_mem']      = $this->sel_mtype == -1 ? '' : $this->sel_mtype;
		$data['sel_stat']     = $this->sel_status == -1 ? '' : $this->sel_status;
		$data['sel_req_date'] = $this->sel_req_date == 'na' ? '' : $this->sel_req_date;
		$data['sel_exp_date'] = $this->sel_exp_date == 'na' ? '' : $this->sel_exp_date;
		$data['sel_uid']=$this->sel_uid;
		$data['title']        = 'Manage Membership Upgrade Request';
		$this->load->blade('admin.upgrade_request', $data);
	}


	function terms() {
		if ($this->uri->segment(4)) {
			$this->sel_mtype = $this->uri->segment(4);
		}
		if ($this->uri->segment(5)) {
			$this->sel_status = $this->uri->segment(5);
		}
		if ($this->uri->segment(6)) {
			$this->sel_req_date = $this->uri->segment(6);
		}
		if ($this->uri->segment(7)) {
			$this->sel_exp_date = $this->uri->segment(7);
		}
		if($this->uri->segment(8))
		{
			$this->sel_uid=$this->uri->segment(8);
		}
		$stringToFinalReturn = '';
		$stringReturned      = ' where';
		if ($this->sel_mtype != -1) {
			$stringReturned .= " ur.mem_type={$this->sel_mtype} and ";
		}

		if ($this->sel_status != -1) {
			$stringReturned .= " ur.status={$this->sel_status} and ";
		}
		if ($this->sel_req_date != 'na' && $this->sel_req_date != 'NaN') {
			$stringReturned .= " DATE_FORMAT(ur.req_date,'%d-%m-%Y')='{$this->sel_req_date}' and ";
		}
		if ($this->sel_exp_date != 'na' && $this->sel_exp_date != 'NaN') {
			$stringReturned .= " DATE_FORMAT(ur.exp_date,'%d-%m-%Y')='{$this->sel_exp_date}' and ";
		}

		if ($this->sel_uid!=0) {
			$stringReturned .= " user_id={$this->sel_uid} and ";
		}

		if ($stringReturned != ' where') {
			$stringToFinalReturn = substr($stringReturned, 0, strlen($stringReturned) - 4);
		}

		return $stringToFinalReturn;
	}

	function request_list($start, $limit, $key = '') {
		$requests = $this->upgrade->all_request($start, $limit, $key);
		$str      = '';
		if ($requests) {
			foreach ($requests as $req) {
				$statustext = 'Not Requested';
				$cked= '';
				if ($req->status == 1) {
					$cked       = '';
					$statustext = "<span style='color:#FFAA00;'>Pending</span>";
				} else if ($req->status == 2) {
					$cked       = 'checked';
					$statustext = "<span style='color:#009000;'>Approved</span>";

				}
				$mtext  = Upgrade_model::get_mtext($req->mem_type);
				$reqdt  = date_create($req->req_date);
				$reqdtf = date_format($reqdt, 'd F,Y H:i A');

				$expdt  = date_create($req->exp_date);
				$expdtf = date_format($expdt, 'd F,Y H:i A');

				$user = $this->user_model->find($req->user_id);
				$details=$this->user_detail_model->find_by('user_id',$req->user_id);
				$user_phone=$details?$details->phone:'';

				$url = base_url() . "admin/upgrade_request/edit/{$req->user_id}/{$req->mem_type}";
				$str .= "<tr>";
				$str .= "<td>{$user->user_name}</td>";
				$str .= "<td>{$user->email}</td>";
				$str .= "<td>{$user_phone}</td>";
				$str .= "<td>{$mtext}</td>";
				$str .= "<td>{$reqdtf}</td>";
				$str .= "<td>{$expdtf}</td>";
				$str .= "<td><label class='ck-label'>";
				$str.="<input type='checkbox' id='ck_approve' data-user='{$req->user_id}' data-utype='{$req->mem_type}' class='ck_upgrade' {$cked}  value='{$req->id}'/>";
				$str.="{$statustext}</label></td>";
				$str .= "</tr>";
			}
		}
		return $str;
	}

	function edit() {
		$data['user']  = $this->uri->segment(4);
		$data['mtype'] = $this->uri->segment(5);
		$data['title'] = 'Edit Request';
		$this->load->blade('admin.edit_request', $data);
	}

	function update() {
		$user   = $this->input->post('hdn_user');
		$mtype  = $this->input->post('hdn_mtype');
		$status = $this->input->post('ddl_status');
		//die(var_dump($status));
		if ($status == 2) {
			$data      = array('status' => $status);
			$data_user = array('mem_type' => $mtype);
			$this->upgrade->update($user, $data);
			$this->user_model->update_user($user, $data_user);
			$this->session->set_flashdata('success', 'Membership status changed successfully');
			redirect(base_url() . "admin/upgrade_request");
		}
		redirect(base_url() . "admin/upgrade_request");

	}

	function approve_req() {
		$upid = $this->input->get('upid');
		$stat = $this->input->get('stat');
		$utype=$this->input->get('utype');
		$user=$this->input->get('user');
		$duration=$this->permission_model->get_duration($utype);
		$now=Carbon::now();
		$exp=$now->addDays($duration);
		$this->upgrade->update_by_id($upid,array('status'=>$stat,
			'approval_date'=>date('Y-m-d H:i:s'),
			'exp_date'=>$exp->toDateTimeString())
		);
		$data_user=array('mem_type'=>$utype,
			'update_date'=>date('Y-m-d H:i:s'));
		$this->membership_model->update_utype($user,$data_user);
		echo  "sucess";
	}

	function user_list()
	{
		//$this->output->enable_profiler(true);
		$key=$this->input->get('term');
		$users=$this->user_model->get_user_like($key);
		header('Content-Type: application/json');
		echo json_encode($users);
	}


}

/* End of file manage_upgrade_request.php */
/* Location: ./application/controllers/admin/manage_upgrade_request.php */