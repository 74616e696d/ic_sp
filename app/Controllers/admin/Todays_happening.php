<?php

class Todays_happening extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('common');
		$this->load->model('todays_heppening_model','event');
	}

	public function index()
	{
		$data['events']=$this->event->all();
		$data['title']="Today's happening";
		$this->load->blade('admin.todays_happening.index', $data);
	}

	function get_happenings_dt()
	{
		 $length=20;
		 $term='';
		 $search=$_POST['search']['value'];
		 $filterStr='';
		 if($search){

		     $search_terms=json_decode($search);

		     $searchStr=' where';
		     if(!empty($search_terms->title))
		     {
		         $searchStr.=" title like '%{$search_terms->title}%' and ";
		     }
		     if(!empty($search_terms->from) && !empty($search_terms->to))
		     {
		         $searchStr.=" (date(happening_date)>='{$search_terms->from}' and date(happening_date)<='{$search_terms->to}') and ";
		     }
		 
		     if($searchStr!=' where')
		     {
		         $term.=substr($searchStr,0,strlen($searchStr)-4);
		     }
		     $filterStr=$term;
		 }
		 $term.=" order by id desc";
		 $no = $_POST['start'];
		 $term.=" limit {$no},{$length}";
		$list = $this->event->get_happenings($term);
		
		$data = array();
		if($list)
		{
		    foreach($list as $item) 
		    {
		        $no++;
		        $row = array();
		        $row[] = $item->title;
		        $row[] = $item->details;
		        $row[] = date('d M, Y',strtotime($item->happening_date));
		        $display=$item->display?'Published':'Not Published';
		        $row[] = $display;

		        $edit_url=base_url().'admin/todays_happening/edit/'.$item->id;
		        $delete_url=base_url().'admin/todays_happening/delete/'.$item->id;

		       $action="<a href='{$edit_url}' class='btn btn-info btn-small'><i class='fa fa-edit'></i></a>";

				$action.="	<a onclick='return(confirm(\"Are you sure to delete??\"))' href='{$delete_url}' class='btn btn-danger btn-small'><i class='fa fa-trash-o'></i></a>";
		        $row[]=$action;

		        $data[] = $row;
		    }
		}
		$total=$this->event->count();
		$total_filtered=$this->event->count($filterStr);
		$output = array(
		                "draw" => $_POST['draw'],
		                "recordsTotal" =>$total ,
		                "recordsFiltered" => $total_filtered,
		                "data" => $data,
		        );
		//output to json format
		echo json_encode($output);
	}

	function create()
	{
		$data['title']="Today's happening | Create";
		$this->load->blade('admin.todays_happening.create', $data);
	}

	function store()
	{
		$title=$this->input->post('title');
		$details=$this->input->post('details');
		$happening_date=get_date_picker('happening_date');
		$photo=do_upload('userfile','asset/news/');
		$display=$this->input->post('display');
		$data=['title'=>$title,
			'details'=>$details,
			'happening_date'=>$happening_date,
			'photo'=>$photo,
			'display'=>$display
			];
		$this->event->create($data);
		$this->session->set_flashdata('success', 'Sucessfully saved!!');
		redirect(base_url().'admin/todays_happening');
	}

	function edit()
	{
		$id=$this->uri->segment(4);
		$data['event']=$this->event->find($id);
		$data['title']="Today's happening";
		$this->load->blade('admin.todays_happening.edit', $data);
	}


	function update()
	{
		$id=$this->input->post('hdn_id');
		$title=$this->input->post('title');
		$details=$this->input->post('details');
		$happening_date=get_date_picker('happening_date');
		$photo=$this->input->post('hdn_current');
		$new_photo=$this->input->post('hdn_new');
		if(!empty($new_photo))
		{
			if(file_exists('asset/news/'.$photo))
			{
				unlink('asset/news/'.$photo);
			}
			$photo=do_upload('userfile','asset/news/');
		}
		$display=$this->input->post('display');
		$data=['title'=>$title,
			'details'=>$details,
			'happening_date'=>$happening_date,
			'photo'=>$photo,
			'display'=>$display
			];
		$this->event->update($id,$data);
		$this->session->set_flashdata('success', 'Sucessfully updated!!');
		redirect(base_url().'admin/todays_happening');
	}

	function delete()
	{
		$id=$this->uri->segment(4);
		$this->event->delete($id);
		$this->session->set_flashdata('success', 'Successfully deleted !!');
		redirect(base_url().'admin/todays_happening');
	}

}

/* End of file todays_happening.php */
/* Location: ./application/controllers/admin/todays_happening.php */