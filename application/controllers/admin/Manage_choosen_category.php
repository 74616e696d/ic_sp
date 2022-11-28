<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use Carbon\Carbon;
class Manage_choosen_category extends Admin_Controller {

	var $selected_status=-1;
	var $selected_req_date='na';
	var $selected_exp_date='na';
	var $selected_email='na';

	function __construct()
	{
		parent::__construct();
		$this->load->model('Exam/choosen_category_model','choosen');
		$this->load->model('ref_text_model');
		$this->load->model('user_model');
		$this->load->library('pagination');
		$this->load->helper('common');
	}
	public function index()
	{
		$start=0;
		$limit=3;
		$uri_seg=8;
		$numlinks=5;
		$perpage=3;
		if($this->uri->segment(8))
		{
			$start=$this->uri->segment(8);
		}
		$base_url=base_url()."admin/manage_choosen_category/index/{$this->selected_status}/{$this->selected_req_date}/{$this->selected_exp_date}/{$this->selected_email}/";
		$term=$this->terms();
		$ttl=$this->choosen->choosen_count_key($term);
		$data['pagi']=create_pagination($base_url,$ttl,$uri_seg,$numlinks,$perpage);
		$data['sel_stat']=$this->selected_status==-1?'':$this->selected_status;
		$data['sel_req_date']=$this->selected_req_date=='na'?'':$this->selected_req_date;
		$data['sel_exp_date']=$this->selected_exp_date=='na'?'':$this->selected_exp_date;
		$data['sel_email']=$this->selected_email=='na'?'':$this->selected_email;
		$data['choosen_list']=$this->choosen_list($start,$limit,$term);
		$data['title']='Manage Choosen Category';
		$this->load->blade('admin.choosen_category', $data);
	}

	function terms()
	{
		if($this->uri->segment(4))
		{
			$this->selected_status=$this->uri->segment(4);
		}
		if($this->uri->segment(5))
		{
			$this->selected_req_date=$this->uri->segment(5);
		}
		if($this->uri->segment(6))
		{
			$this->selected_exp_date=$this->uri->segment(6);
		}
		if($this->uri->segment(7))
		{
			$this->selected_email=$this->uri->segment(7);
		}
		$stringToFinalReturn='';
        $stringReturned=' where';
        if($this->selected_status!=-1)
        {
        	$stringReturned.=" status={$this->selected_status} and ";
        }
        if($this->selected_req_date!='na' && $this->selected_req_date!='NaN')
        {
        	$stringReturned.=" DATE_FORMAT(request_date,'%d-%m-%Y')='{$this->selected_req_date}' and ";
        }
        if($this->selected_exp_date!='na' && $this->selected_exp_date!='NaN')
        {
        	$stringReturned.=" DATE_FORMAT(expiry_date,'%d-%m-%Y')='{$this->selected_exp_date}' and ";
        }
        if($this->selected_email!='na')
        {
        	//$eml=htmlentities(base64_decode(str_replace('%','',$this->selected_email)));
        	$user=$this->user_model->find_by_email($this->email);
        	if($user)
        	{
        		$stringReturned.=" user_id={$user->id} and ";
        	}
        }
        if($stringReturned!=' where')
        {
            $stringToFinalReturn=substr($stringReturned,0,strlen($stringReturned)-4);
        }

        return $stringToFinalReturn;
	}

	function choosen_list($start,$limit,$key='')
	{

		$choosen_cat=$this->choosen->get_choosen_cat_by_key($start,$limit,$key);
		$str='';
		if($choosen_cat)
		{
			foreach ($choosen_cat as $c) {
				$cat_text=ref_text_model::get_text($c->exam_cat);
				$user=$this->user_model->get_user_details($c->user_id);

				$status='';
				if($c->status==0)
				{
					$status="<span style='color:#ccc;'>Not Requested</span>";
				}
				else if($c->status==1)
				{
					$status="<span style='color:#FFAA00;'>Pending</span>";
				}
				else
				{
					$status="<span style='color:#009000;'>Approved</span>";
				}
	

				$dt_req=date_create($c->request_date);
				$dt_req_f=date_format($dt_req,'d F,Y');
				$dt_exp=date_create($c->expiry_date);
				$dt_exp_f=date_format($dt_exp,'d F,Y');
				$edit_url=base_url()."admin/manage_choosen_category/edit_status/{$c->user_id}/{$c->exam_cat}";
				$str.="<tr>";
				$str.="<td>{$user->email}</td>";
				$str.="<td>{$user->phone}</td>";
				$str.="<td>{$cat_text}</td>";
				$str.="<td>{$status}</td>";
				$str.="<td>{$dt_req_f}</td>";
				$str.="<td>{$dt_exp_f}</td>";
				$str.="<td><a class='btn' role='button' data-toggle='modal' data-target='#edit_dlg' href='{$edit_url}'><i class='fa fa-edit'></i>&nbsp;Edit Status</a></td>";
				$str.="</tr>";
			}
		}
		return $str;
	}

	function edit_status()
	{
		$user=$this->uri->segment(4);
		$cat=$this->uri->segment(5);
		$data['user']=$user;
		$data['cat']=$cat;
		$data['title']='';
		$this->load->blade('admin.edit_status', $data);
	}
	function update_status()
	{
		$user=$this->input->post('hdn_user');
		$cat=$this->input->post('hdn_cat');
		$status=$this->input->post('ddl_status');
		$app_date=Carbon::now()->toDateTimeString();
		$exp_date=Carbon::now()->addMonths(3)->toDateTimeString();
		$data=array('status'=>$status,'approval_date'=>$app_date,'expiry_date'=>$exp_date);
		//die(var_dump($cat));
		try
		{
			$this->choosen->update($user,$cat,$data);
			$this->session->set_flashdata('success', 'status successfully updated!');
			redirect(base_url().'admin/manage_choosen_category');
		}
		catch(Exception $ex)
		{
			$this->session->flashdata('error',$ex->message());
			redirect(base_url().'admin/manage_choosen_category');
		}
		
	}

}

/* End of file manage_choosen_category.php */
/* Location: ./application/controllers/admin/manage_choosen_category.php */