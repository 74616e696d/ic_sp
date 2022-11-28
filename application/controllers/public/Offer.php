<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offer extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('common');
		$this->load->helper('message');
		$this->load->model('roadmap_model');
		$this->load->model('roadmap_details_model');
		$this->load->model('ref_text_model');
	}
	public function index()
	{
		$data['roadmap']=$this->roadmap_model->get_shcedule(1155,3);
		$data['title']='';
		$this->load->blade('public.offer.index', $data);
	}

	public function ateo()
	{
		$data['title']='';
		$this->load->blade('public.offer.index', $data);
	}

	public function bcs()
	{
		$data['title']='';
		$this->load->blade('public.offer.bcs', $data);
	}

	public function ntrca(){

		$data['title']='';
		$this->load->blade('public.offer.ntrca', $data);
	}

}

/* End of file offer.php */
/* Location: ./application/controllers/public/offer.php */