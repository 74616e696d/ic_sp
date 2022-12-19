<?php

class Manage_cache extends Admin_Controller {
	public function __construct()
	{
		parent::__construct(['101','102']);
		$this->load->helper('directory');
		$this->load->helper('file');
	}
	public function index()
	{
		$dirs= directory_map('./application/cachedb/', 1);
		$data['dirs']=$dirs;
		$data['title']='Manage Database Cache';
		$this->load->blade('admin.manage_cache', $data);
	}

	function remove()
	{
		$name=$this->uri->segment(4);
		$cntrl=$this->uri->segment(5);
		// dd($cntrl.'   '.$name);
		$this->db->cache_delete($name,$cntrl);
		redirect(base_url()."admin/manage_cache");
	}
	function clear_all()
	{
		$this->db->cache_delete_all();
		redirect(base_url()."admin/manage_cache");
	}
}

/* End of file manage_cache.php */
/* Location: ./application/controllers/admin/manage_cache.php */