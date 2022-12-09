<?php 

namespace App\Controllers\Member;
use App\Controllers\BaseController;
use Illuminate\View\Factory as View;

use App\Models\Dashboard_model;
use App\Libraries\Paginator;

class CurrentWorldController extends BaseController {
	function __construct()
	{
		//parent::__construct();
                
                $this->session = \Config\Services::session();
                $this->session->start();

                $this->creationDate = $this->session->get('creation_date');
                $this->username = $this->session->get('username');
                $this->userid = $this->session->get('userid');
                if(!$this->userid)
                {
                    return redirect()->to(base_url());
                    exit;
                }
            
                
                $this->dashboard_model = new Dashboard_model();
                helper('common_helper');
                helper('pagination');
                
                //$this->pagination = new Paginator();
		//$this->load->model('dashboard_model');
		//$this->load->helper('common');
		//$this->load->library('pagination');
	}
	public function index()
	{
		$pp=10;
                $start = 1;
		//$start=$this->uri->segment(4);
		$config['total_rows'] = $this->dashboard_model->total_current_world();
		$config['base_url']=base_url()."member/current_world/index";
		$config['uri_segment']    = 4;
		$config['num_links']      = 5;
		$config['full_tag_open']="<ul class='pagination'>";
		$config['full_tag_close']="</ul>";
		$config['num_tag_open']='<li>';
		$config['num_tag_close']='</li>';
		$config['cur_tag_open']="<li class='cur'><a>";
		$config['cur_tag_close']="</a></li>";
		$config['prev_tag_open']  = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['prev_link']='Prev';
		$config['next_link']      = 'Next';

		$config['next_tag_open']   = '<li>';
		$config['next_tag_close']  = '</li>';
		$config['first_tag_open']  = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open']   = '<li>';
		$config['last_tag_close']  = '</li>';
		$config['per_page'] =$pp;

		//$this->pagination->init($config); 
		//$links=$this->pagination->create_links();

		//$data['links']=$links;
		$data['current_world']=$this->current_worl_list($start,$pp);
		$data['title']='Current World';
                
                $data['creationdate'] = $this->creationDate;
                $data['username'] = $this->username;
                
                return $this->render('member.current_world', $data);
		//$this->load->blade('member.current_world', $data);
	}

	function current_worl_list($start=0,$limit=10)
	{
		$result=$this->dashboard_model->get_current_world($start,$limit);
		//var_dump($result);
		$str='';
		if($result)
		{
		    foreach ($result as $r) {
		        $qtext=strip_tags($r->question,'<img>');
		        $ans=strip_tags($r->options);
		        $ans_arry=explode('///',$ans);
		        $correct='';
		        foreach ($ans_arry as $a) 
		        {
		            if(substr(trim(strip_tags($a,'<img>')),0,2)=="@@")
		            {

		                $correct=str_replace("@@",'',trim(strip_tags($a,'<img>')));
		            }
		        }
		        $hints=!empty($r->hints)?'Hints:'.strip_tags($r->hints,"<p><b><u><i><sub><sup><img>"):'';
		       $str.="<li class='list-group-item'><span style='font-size:15px;'>
		       <i class='fa fa-hand-o-right'></i>&nbsp;{$qtext}<br/><span><span style='font-size:13px;'>Ans:&nbsp;&nbsp;{$correct}</span>
				<div class='hnt'>{$hints}</div>
		       </li>";
		    }
		}
		return $str;
	}

}

/* End of file current_world.php */
/* Location: ./application/controllers/member/current_world.php */