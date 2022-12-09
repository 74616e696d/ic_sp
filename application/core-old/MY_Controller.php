<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public $menu_data='';
	function __construct()
	{
		parent::__construct();
		//$this->load->library('session');
		$this->load->helper('message');
		$this->load->helper('common');

		if($this->session->userdata('userid'))
		{
			$this->menu_data=array('usergroup');
		}
		else
		{
			 redirect(base_url().'login');
		}
	}


	public function view($view, $vars = array(), $return = FALSE)
	{
		return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
	}

	public function blade($view, $vars = array(), $return = false)
	{
		$CI = & get_instance();
		if (!isset($CI->laravel_views))
		{
			$CI->load->library('Laravel_views');
		}
		$user=false;
		$creation_date=false;
		$img='';
		if($CI->session->userdata('userid'))
		{
			$user=$CI->session->userdata('username');
			$cd=$CI->session->userdata('creation_date');
			if(!empty($cd))
			{
				$creation_date=$cd;
			}
			$uid=$CI->session->userdata('userid');
			$CI->load->model('user_model');
			$user_details=$CI->user_model->find_details($uid);
			$photo=$user_details->photo;
			if(file_exists('asset/images/upload/'.$photo))
			{
				$img=base_url().'asset/images/upload/'.$photo;
			}
			else
			{
				$img=base_url().'asset/images/upload/avatar3.png';
			}

		}
		$vars['user_img']=$img;
		$vars['creationdate']=$creation_date;
		$vars['username']=$user;
		$vars['base_url']=$CI->config->item('base_url');

		if (count($vars)>0)
		{
			$CI->load->vars($vars);
		}

		if ($return===false)
		{
			$CI->output->append_output($CI->laravel_views->make($view)->with($CI->load->get_vars()));
			//$CI->output->append_output($CI->laravel_views->make($view));		
		}
		else
		{
			return $CI->laravel_views->make($view)->with($CI->load->get_vars());
		}
	}
	function get_vars()
	{
		//die(var_dump($this->_ci_cached_vars));
		return $this->_ci_cached_vars;
	}
	
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */