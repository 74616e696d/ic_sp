<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends Admin_Controller {
	function __construct()
	{
		parent::__construct(['101','102']);
		$this->load->model('news_model');
		$this->load->model('job_category_model','category');
		$this->load->helper('common');
		$this->load->library('table');
	}
	public function index()
	{
		$data['categories']=$this->category->all();
		$district_json=file_get_contents(base_url().'asset/district.json');
		$data['district']=json_decode($district_json);
		$data['title']='Create News';
		$this->load->blade('admin.news', $data);
	}

	function news_list()
	{
		$data['category']=$this->category->all();
		$data['title']='Manage News';
		$this->load->blade('admin.news_list', $data);
	}

	/**
	 * job list for datatables
	 * @return json
	 */
	function news_list_dt()
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
               $searchStr.=" job_cat={$search_terms->cat} and ";
           }
           if(!empty($search_terms->pdate))
           {
               $searchStr.=" DATE_FORMAT(publish_date,'%Y-%m-%d')='{$search_terms->pdate}' and ";
           }

           if(!empty($search_terms->deadline))
           {
               $searchStr.=" DATE_FORMAT(deadline,'%Y-%m-%d')='{$search_terms->deadline}' and ";
           }

           if($search_terms->status=='0' || $search_terms->status=='1')
           {
               $searchStr.=" is_published={$search_terms->status} and ";
           }
       
           if($searchStr!=' where')
           {
               $term.=substr($searchStr,0,strlen($searchStr)-4);
           }
           $filterStr=$term;
       }

       $no = $_POST['start'];
       $term.=" limit {$no},{$length}";
      $list = $this->news_model->job_list($term);
      
      $data = array();
      if($list)
      {
          foreach($list as $item) 
          {
              $no++;
              $row = array();
              // $ques=strip_tags($item->question);
              $row[] = $item->title;
              $row[] = $item->post_name;
              $pdt=date_create($item->publish_date);
              $pdt_f=date_format($pdt,'d M, Y');
              $row[] = $pdt_f;
              $dln=date_create($item->deadline);
              $dln_f=date_format($dln,'d M, Y');
              $row[] = $dln_f;
              $status=$item->is_published?'Published':'Not Published';
              $row[] = $status;
              $row[] = "<a class='btn btn-small btn-primary' title='Edit' href='javascript:void(0)' onclick='edit_job({$item->id})'><i class='fa fa-edit'></i></a>
                    <a class='btn btn-small btn-danger' href='javascript:void(0)' title='Delete' onclick='delete_job({$item->id})'><i class='fa fa-trash-o'></i></a>";

              $data[] = $row;
          }
      }
      $total=$this->news_model->total();
      $total_filtered=$this->news_model->total($filterStr);
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
		$title=$this->input->post('txt_title');
		$details=$this->input->post('txt_details');
		$creation_date=date('Y-m-d H:i:s');
		$pdate=date('Y-m-d H:i:s');
		$link=$this->input->post('link');
		$link_text=$this->input->post('link_text');
		$logo_img=$this->input->post('logo');
		$post_name=$this->input->post('post_name');
		$deadline=$this->input->post('deadline');
		$pdate=$this->input->post('txt_pub_date');
		$job_cat=$this->input->post('job_category');
		$location=$this->input->post('location');
		$tags=$this->input->post('tags');
		$pdtf=$this->process_date($pdate);
		$is_featured=$this->input->post('is_featured');
		$deadline=$this->process_date($deadline);

		$display=$this->input->post('ck_display');

		$data=array('title'=>$title,
			'details'=>$details,
			'create_date'=>$creation_date,
			'publish_date'=>$pdtf,
			'is_published'=>$display,
			'link'=>$link,
			'logo_img'=>$logo_img,
			'post_name'=>$post_name,
			'deadline'=>$deadline,
			'link_text'=>$link_text,
			'job_cat'=>$job_cat,
			'location'=>$location,
			'tags'=>$tags,
			'is_featured'=>$is_featured
			);
		//var_dump($data);
		// if(!empty($title) && !empty($job_cat))
		if(!empty($title))
		{
			$this->news_model->create($data);
			$this->session->set_flashdata('success', 'news created successfully!');
			redirect(base_url()."admin/news/news_list");
		}
		else
		{
			$this->session->set_flashdata('error', 'Please give title of news!!');
			redirect(base_url()."admin/news");
		}
	}


	function edit()
	{
		$id=$this->uri->segment(4);
		$data['categories']=$this->category->all();
		$district_json=file_get_contents(base_url().'asset/district.json');
		$data['district']=json_decode($district_json);
		$data['news']=$this->news_model->find($id);
		$data['title']='Edit News';
		$this->load->blade('admin.edit_news', $data);
	}

	function update()
	{
		$id=$this->input->post('hdn_id');
		$title=$this->input->post('txt_title');
		$details=$this->input->post('txt_details');
		$creation_date=date('Y-m-d H:i:s');
		$pdate=date('Y-m-d H:i:s');
		$link=$this->input->post('link');
		$link_text=$this->input->post('link_text');
		$post_name=$this->input->post('post_name');
		$job_cat=$this->input->post('job_category');
		$location=$this->input->post('location');
		$is_featured=$this->input->post('is_featured');
		$tags=$this->input->post('tags');
		$deadline=$this->input->post('deadline');
		$logo_img=$this->input->post('logo');

		$pdate=$this->input->post('txt_pub_date');
		$pdtf=$this->process_date($pdate);
		$deadline=$this->process_date($deadline);

		$display=$this->input->post('ck_display');

		$data=array('title'=>$title,
			'details'=>$details,
			'create_date'=>$creation_date,
			'publish_date'=>$pdtf,
			'is_published'=>$display,
			'link'=>$link,
			'logo_img'=>$logo_img,
			'post_name'=>$post_name,
			'deadline'=>$deadline,
			'link_text'=>$link_text,
			'job_cat'=>$job_cat,
			'location'=>$location,
			'is_featured'=>$is_featured,
			'link_text'=>$link_text);
		// if(!empty($title) && !empty($job_cat))
		if(!empty($title))
		{
			$this->news_model->update($id,$data);
			$this->session->set_flashdata('success', 'news created successfully!');
			redirect(base_url()."admin/news/news_list");
		}
		else
		{
			$this->session->set_flashdata('error', 'Please give title of news!!');
			redirect(base_url()."admin/news/edit/{$id}");
		}
	}

	function remove()
	{
		$id=$this->input->get('id');
		$this->news_model->delete($id);
		echo json_encode(array("status" => TRUE));
	}

	function pick_files()
	{
		$data['title']='';
		$data['files']=$this->scan_dir();
		$this->load->blade('admin.get_files', $data);
	}

	/**
	 * upload new file by dropzone js
	 * @return void
	 */
	function load_image()
	{
		$ds= DIRECTORY_SEPARATOR;
		$storeFolder = 'asset/job/';
		if (!empty($_FILES)) 
		{
		    $tempFile = $_FILES['file']['tmp_name'];
		    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		    $fileName=pathinfo($_FILES['file']['name'], PATHINFO_BASENAME);
		    $fileName=rtrim($fileName,'.'.$ext);
		    $targetFile = $storeFolder.$fileName.'-'.time().'.'.$ext;
		    move_uploaded_file($tempFile,$targetFile);
		}
	}

	/**
	 * reload scan_dir on ajax call after new file uploaded
	 * @return void
	 */
	function reload_files()
	{
		$str=$this->scan_dir();
		echo $str;
	}

	/**
	 * scan directory to get files
	 * @return string
	 */
	function scan_dir()
	{
		$ignored=['.','.htaccess','.git'];
		// $files=get_filenames('asset/job/');
		$files=$this->sort_file_file_last_modi('asset/job/');
		$str='';
		if($files)
		{
			$str.='<ul class="thumbnails">';
			$indx=0;
			foreach ($files as $file) 
			{
				$fl=isset($file['file'])?$file['file']:'';
				if(file_exists('asset/job/'.$fl))
				{
					if (in_array($fl, $ignored)) continue;
				   $str.="<li class='span4'>";
				   $str.="<a href='' data-img='{$fl}' class='thumbnail'>";
				   $src=base_url().'asset/job/'.$fl;
				   $str.="<img width='100px' src='{$src}' alt='Not Found'>";
				   $str.="</a>";
				   $str.="</li>";
			   }
			   $indx++;
			}
			$str.='</ul>';
		}
		return $str;
	}

	function process_date($str_dt)
	{
		$pdtf='';
		if(!empty($str_dt))
		{
			// $publish_date=$str_dt;
			// $tm=date('H:i:s');
			// $pdate=$publish_date.' '.$tm;

			$pdt=date_create($str_dt);
			$pdtf=date_format($pdt,'Y-m-d H:i:s');
		}
		else
		{
			$pdf=date('Y-m-d H:i:s');
		}
		return $pdtf;
	}

	function category()
	{
		$data['categories']=$this->category->all();
		$data['title']='Job Category';
		$this->load->blade('admin.job.category', $data);
	}

	function create_category()
	{
		$data['title']='New Job Category';
		$this->load->blade('admin.job.create_category', $data);
	}

	function store_category()
	{
		$title=$this->input->post('title');
		$display=$this->input->post('display');
		if(!empty($title))
		{
			$data=array('title'=>$title,'display'=>$display);
			$this->category->create($data);
			$this->session->set_flashdata('success', 'Successfully saved');
			redirect(base_url().'admin/news/category');
		}
		$this->session->set_flashdata('error', 'Title must be given !!');
		redirect(base_url().'admin/news/create_category');
	}

	function edit_category()
	{
		$id=$this->uri->segment(4);
		$data['cat']=$this->category->find($id);
		$data['title']='Edit Job Category';
		$this->load->blade('admin.job.edit_category', $data);
	}	

	function update_category()
	{
		$id=$this->input->post('hdn_id');
		$title=$this->input->post('title');
		$display=$this->input->post('display');
		if(!empty($title))
		{
			$data=array('title'=>$title,'display'=>$display);
			$this->category->update($id,$data);
			$this->session->set_flashdata('success', 'Successfully saved');
			redirect(base_url().'admin/news/category');
		}
		$this->session->set_flashdata('error', 'Title must be given !!');
		redirect(base_url().'admin/news/edit_category/'.$id);
	}

	function  delete_category()
	{
		$id=$this->uri->segment(4);
		$this->category->delete($id);
		$this->session->set_flashdata('success', 'Successfully deleted');
		redirect(base_url().'admin/news/category');
	}

	function get_edit_delete_buttons($id)
	{
		$str="";
		$lnk_edit=base_url()."admin/news/edit/{$id}";
		$str.="<a title='Edit' class='btn btn-info btn-small' href='{$lnk_edit}'>";
		$str.="<i class='btn btn-edit'></i>";
		$str.="</a>";

		$lnk_delete=base_url()."admin/news/remove/{$id}";
		$str.="<a onclick='return(confirm(\"Are you sure to delete ??\"))' title='Delete' class='btn btn-danger btn-small' href='{$lnk_delete}'>";
		$str.="<i class='btn btn-danger btn-small'></i>";
		$str.="</a>";
		return $str;
	}

	/**
	 * sort files of directory according to last modified date
	 * @param  string $dir        
	 * @param  string $sort_type  
	 * @param  string $date_format
	 * @return array            
	 */
	function sort_file_file_last_modi($dir, $sort_type = 'descending', $date_format = "F d Y H:i:s.")
	{
		$files = scandir($dir);
		$array = array();
		foreach($files as $file)
		{
		    if($file != '.' && $file != '..')
		    {
		        $now = time();
		        $last_modified = filemtime($dir.$file);
		        $time_passed_array = array();
		        $diff = $now - $last_modified;
		        $days = floor($diff / (3600 * 24));
		        if($days)
		        {
		        	$time_passed_array['days'] = $days;
		        }

		        $diff = $diff - ($days * 3600 * 24);
		        $hours = floor($diff / 3600);

		        if($hours)
		        {
		        	$time_passed_array['hours'] = $hours;
		        }
		 
		        $diff = $diff - (3600 * $hours);
		        $minutes = floor($diff / 60);
		 
		        if($minutes)
		        {
		        	$time_passed_array['minutes'] = $minutes;
		        }
		 
		        $seconds = $diff - ($minutes * 60);
		        $time_passed_array['seconds'] = $seconds;
		    	$array[] = array('file'     => $file,
		                     'timestamp'    => $last_modified,
		                     'date'         => date ($date_format, $last_modified),
		                     'time_passed'  => $time_passed_array);
		    }
		}
	 
		usort($array, create_function('$a, $b', 'return strcmp($a["timestamp"], $b["timestamp"]);'));
		 
		if($sort_type == 'descending')
		{
			krsort($array);
		}
		return array_values($array);
	}

}

/* End of file news.php */
/* Location: ./application/controllers/admin/news.php */
