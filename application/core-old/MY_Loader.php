<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."third_party/MX/Loader.php";


class MY_Loader extends MX_Loader {


	// public function view($view, $vars = array(), $return = FALSE)
	// {
	// 	return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
	// }

	public function blade($view, $vars = array(), $return = false)
	{
	    
		list($path, $_view) = Modules::find($view, $this->_module, 'views/');
		if ($path != FALSE)
		{
			$this->_ci_view_paths = array($path => TRUE) + $this->_ci_view_paths;
			$view = $_view;
		}


		$CI = & get_instance();
		if (!isset($CI->laravel_views))
		{
			$l_view_path=APPPATH.'views/';

			if($this->_module!=null)
			{
				$l_view_path=APPPATH.'modules/'.$this->_module.'/views/';
			}
			$CI->load->library('Laravel_views',['l_view'=>$l_view_path]);
		}
		$user=false;
		$creation_date=false;
		$img='';
		$authenticated=false;
		$utype='';
		$email='';
		if($CI->session->userdata('userid'))
		{
		$authenticated=true;
			$user=$CI->session->userdata('username');
			$email=$CI->session->userdata('email');
			$cd=$CI->session->userdata('creation_date');
			$utype=$CI->session->userdata('utype');
			if(!empty($cd))
			{
				$creation_date=$cd;
			}

			$uid=$CI->session->userdata('userid');
			$CI->load->model('user_model');
			$user_details=$CI->user_model->find_details($uid);
			//$photo=$user_details->photo;
			if($user_details)
			{
				if(!empty($user_details->photo))
				{
					if(file_exists(FCPATH.'asset/images/upload/'.$user_details->photo))
					{
						$img=base_url().'asset/images/upload/'.$user_details->photo;
					}
					else
					{
						$img=base_url().'asset/img/no-image.jpg';
					}
				}
				else
				{
					$img=base_url().'asset/img/no-image.jpg';
				}
			}
			else
			{
				$img=base_url().'asset/img/no-image.jpg';
			}

			$CI->load->model('member/mistake_model','mistake');
			$CI->load->model('member/review_model','review');
			$total_mistake=$CI->mistake->total($uid);
			$total_review=$CI->review->total($uid);
			$vars["user_total_mistake"]=$total_mistake;
			$vars["user_total_review"]=$total_review;
		}
		$vars['is_member']=in_array($utype,['2','3','4','5','6','7','8'])?true:false;
		$vars['is_admin']=in_array($utype,['101'])?true:false;
		$vars['is_auth']=$authenticated;
		$vars['is_expert']=$utype=='expert'?true:false;
		$vars['user_img']=$img;
		$vars['creationdate']=$creation_date;
		$vars['username']=$user;
		$vars['email']=$email;
		$vars['base_url']=$CI->config->item('base_url');
		$vars['ci']=$CI;
	

		if (count($vars)>0)
		{
			$CI->load->vars($vars);
		}

		if ($return===false)
		{
			//$CI->output->append_output($CI->laravel_views->make($view)->with($CI->load->get_vars()));
			$CI->output->append_output($CI->laravel_views->make($view));		
		}
		else
		{
			return $CI->laravel_views->make($view)->with($CI->load->get_vars());
		}
	}

	function get_vars()
	{
		return $this->_ci_cached_vars;
	}

}