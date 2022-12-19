<?php
use Intervention\Image\ImageManagerStatic as Image;
class Current_news extends Admin_Controller {

	function __construct()
	{
		parent::__construct(['101','102']);
		$this->load->helper('common');
		$this->load->model('current_news_category_model','category');
		$this->load->model('current_news_model','news');
	}
	public function index()
	{
		$data['category']=$this->category->all();
		$data['current_news']=$this->news->all();
		$data['title']='Current News';
		$this->load->blade('admin.current_news.index', $data);
	}

	/**
	 * current news list to show in datatables
	 * @return json
	 */
	function current_news_list_dt()
	{
		 $length=20;
		 $term='';
		 $search=$_POST['search']['value'];
		 $filterStr='';
		 if($search){
		     $search_terms=json_decode($search);
		     $searchStr=' where';
		     if(!empty($search_terms->cat))
		     {
		         $searchStr.=" category_id={$search_terms->cat} and ";
		     }
		     if(!empty($search_terms->pdate))
		     {
		         $searchStr.=" DATE_FORMAT(post_date,'%Y-%m-%d')='{$search_terms->pdate}' and ";
		     }

		     if(!empty($search_terms->title))
		     {
		         $searchStr.=" title LIKE '%{$search_terms->title}%' and ";
		     }

		     if($search_terms->status=='0' || $search_terms->status=='1')
		     {
		         $searchStr.=" cn.display={$search_terms->status} and ";
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
		$list = $this->news->get_current_news_list($term);
		
		$data = array();
		if($list)
		{
		    foreach($list as $item) 
		    {
		        $no++;
		        $row = array();
		        // $ques=strip_tags($item->question);
		        $row[] = $item->name;
		        $row[] = $item->title;
		        $pdt=date_create($item->post_date);
		        $pdt_f=date_format($pdt,'d M, Y');
		        $row[] = $pdt_f;
		        $display=$item->display?'Published':'Not Published';
		        $row[] = $display;
		        $action="<a data-peak='{$item->is_weekly_peak}' data-id='{$item->id}' href='' class='btn btn-default btn-weekly-peak'><i class='fa fa-plus'></i></a>";
		         $action.= " <a class='btn btn-small btn-primary' title='Edit' href='javascript:void(0)' onclick='edit_news({$item->id})'><i class='fa fa-edit'></i></a>
		              <a class='btn btn-small btn-danger' href='javascript:void(0)' title='Delete' onclick='delete_news({$item->id})'><i class='fa fa-trash-o'></i></a>";
		        $row[]=$action;

		        $data[] = $row;
		    }
		}
		$total=$this->news->count_all();
		$total_filtered=$this->news->count_all($filterStr);
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
		$data['category']=$this->category->all_by('display',1);
		$data['title']='New Current News';
		$this->load->blade('admin.current_news.create', $data);
	}

	function store()
	{
		$category_id=$this->input->post('ddlCategory');
		$tags=$this->input->post('txtTags');
		$tags_en=$this->input->post('txtTagsEn');
		$title=$this->input->post('txtTitle');
		$title_en=$this->input->post('txtTitleEn');
		$short_desc=$this->input->post('txtShortDetails');
		$short_desc_en=$this->input->post('txtShortDetails');
		$details=$this->input->post('txtDetails');
		$details_en=$this->input->post('txtDetails');
		$display=$this->input->post('display');
		// $post_date=date('Y-m-d H:i:s');
		$post_date=get_date_picker('pulished_date');
		$is_featured=$this->input->post('is_featured');
		$feature_img=do_upload('userfile','asset/news/');
		$post_by=$this->userid;
		$meta_desc=$this->input->post('txt_meta_desc');
		$meta_keyword=$this->input->post('txt_meta_tags');
		
		$data=[
		'category_id'=>$category_id,
		'tags'=>$tags,
		'title'=>$title,
		'short_desc'=>$short_desc,
		'details'=>$details,
		'post_date'=>$post_date,
		'post_by'=>$post_by,
		'is_featured'=>$is_featured,
		'feature_img'=>$feature_img,
		'display'=>$display,
		'meta_desc'=>$meta_desc,
		'meta_keyword'=>$meta_keyword
		];
		
		if(!empty($title) && !empty($category_id))
		{
			$this->news->create($data);
			$this->session->set_flashdata('success', 'Successfully saved !!');
			redirect(base_url().'admin/current_news');
		}
		else
		{
			$this->session->set_flashdata('error', 'Unable to save !!');
			redirect(base_url().'admin/current_news/create');
		}
	}

	function edit()
	{
		$id=$this->uri->segment(4);
		$data['news']=$this->news->find($id);
		$data['category']=$this->category->all_by('display',1);
		$data['title']='Edit Current News';
		$this->load->blade('admin.current_news.edit', $data);
	}
	function update()
	{
		$id=$this->input->post('hdn_id');
		$category_id=$this->input->post('ddlCategory');
		$tags=$this->input->post('txtTags');
		$title=$this->input->post('txtTitle');
		$short_desc=$this->input->post('txtShortDetails');
		$details=$this->input->post('txtDetails');
		$display=$this->input->post('display');
		// $post_date=date('Y-m-d H:i:s');
		$post_date=get_date_picker('pulished_date');
		$is_featured=$this->input->post('is_featured');

		$feature_img=$this->input->post('hdn_current_img');
		$new_img=$this->input->post('hdn_img');
		if(!empty($new_img))
		{
			if(file_exists('asset/news/'.$feature_img))
			{
				unlink('asset/news/'.$feature_img);
			}
			if(file_exists('asset/news/small/'.$feature_img)){
				unlink('asset/news/small/'.$feature_img);
			}
			if(file_exists('asset/news/square/'.$feature_img)){
				unlink('asset/news/square/'.$feature_img);
			}
			$feature_img=do_upload('userfile','asset/news/');
			news_thumb($feature_img);
			news_thumb_square($feature_img);
		}
		$post_by=$this->userid;
		$meta_desc=$this->input->post('txt_meta_desc');
		$meta_keyword=$this->input->post('txt_meta_tags');
		$data=[
		'category_id'=>$category_id,
		'tags'=>$tags,
		'title'=>$title,
		'short_desc'=>$short_desc,
		'details'=>$details,
		'post_date'=>$post_date,
		'post_by'=>$post_by,
		'is_featured'=>$is_featured,
		'feature_img'=>$feature_img,
		'display'=>$display,
		'meta_desc'=>$meta_desc,
		'meta_keyword'=>$meta_keyword];
		
		if(!empty($title) && !empty($category_id))
		{
			$this->news->update($id,$data);
			$this->session->set_flashdata('success', 'Successfully updated !!');
			redirect(base_url().'admin/current_news');
		}
		else
		{
			$this->session->set_flashdata('error', 'Unable to update !!');
			redirect(base_url().'admin/current_news/edit/'.$id);
		}
	}

	function delete()
	{
		$id=$this->input->get('id');
		$this->news->delete($id);
		echo json_encode(array("status" => TRUE));
	}

	function add_as_weekly_peak()
	{	
		$id=$this->input->post('id');
		$stat=$this->input->post('stat');
		$this->news->update($id,['is_weekly_peak'=>$stat]);
		echo 1;
	}
}

/* End of file current_news.php */
/* Location: ./application/controllers/admin/current_news.php */