<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pr extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('message');
		$this->load->model('upgrade_history');
	}

	public function index()
	{
		$data['title']='Iconpreparation Income &amp; Upgrade Stats';
		$this->load->blade('admin.pr', $data);	
	}


	/**
	 * current news list to show in datatables
	 * @return json
	 */
	function history_dt()
	{
		 $length=$_POST['length'];
		 $term='';
		 $search=$_POST['search']['value'];
		 $filterStr='';
		 if($search){
		     $search_terms=json_decode($search);
		     $searchStr=' where';
		     if(!empty($search_terms->start))
		     {
		         $searchStr.=" DATE(created_at)>='{$search_terms->start}' and ";
		     }
		     if(!empty($search_terms->to))
		     {
		         $searchStr.=" DATE(created_at)<='{$search_terms->to}' and ";
		     }

		 
		     if($searchStr!=' where')
		     {
		         $term.=substr($searchStr,0,strlen($searchStr)-4);
		     }
		     $filterStr=$term;
		 }

		 $total_amount=$this->upgrade_history->get_payment_summery($term);

		 $term.=" order by uh.id desc";

		 $term_no_limit=$term;

		$no = $_POST['start'];
		$term.=" limit {$no},{$length}";



		$list = $this->upgrade_history->get_payment_stats($term);

		$data = array();
		if($list)
		{
		    foreach($list as $item) 
		    {
		        $no++;
		        $row = array();
		        
		        $row[] = $no;
		        $pdt=date_create($item->created_at);
		        $pdt_f=date_format($pdt,'d M, Y');
		        $row[] =$pdt_f;

		        $std_info='';

		        $phone=$this->upgrade_history->get_user_phone($item->uid);

		        $std_info.="Id :".$item->uid.'<br/>';

		        if(!empty($item->user_name)){
		       	 $std_info.="Name :".$item->user_name.'<br/>';
		        }
		        $std_info.="Email :".$item->email;

		        if(!empty($phone))
		        {
		        	$std_info.="<br/>Phone :".$phone;
		        }

		        $row[]= $std_info;
		        $row[] = $item->name;
		        $row[] = $item->duration;
		        $row[] = $item->source;
		        $row[] = !empty($item->amount)?$item->amount:'0.00';

		        $data[] = $row;
		    }
		}
		$total=$this->upgrade_history->get_count();
		$total_filtered=$this->upgrade_history->get_count($filterStr);
		// $term_data=$this->upgrade_history->get_payment_stats($term_no_limit);
		// $amount_items=$this->upgrade_history->get_payment_stats_arr($term_no_limit);
		// $amount=array_sum(array_column($amount_items,'amount'));
		$output = array(
		                "draw" => $_POST['draw'],
		                "recordsTotal" =>$total ,
		                "recordsFiltered" => $total_filtered,
		                "data" => $data,
		                'total_amount'=>$total_amount
		        );
		//output to json format
		echo json_encode($output);
	}

}

/* End of file pr.php */
/* Location: ./application/controllers/admin/pr.php */