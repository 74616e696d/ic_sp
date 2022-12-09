<?php

class Job extends Admin_Controller 
{
	function __construct()
	{
		parent::__construct(['101','102']);
		$this->load->model('job/job_model','job_model');
		$this->load->model('job_category_model','category');
		$this->load->model('company_model');
		$this->load->helper('common');
		$this->load->library('table');
	}
	public function index()
	{
		
		$data['company']=$this->company_model->get_company();
		$data['categories']=$this->category->all();
		$district_json=file_get_contents(base_url().'asset/district.json');
		$data['district']=json_decode($district_json);
		$data['title']='Create Job';
		$this->load->blade('admin.job.new', $data);
	}



	function job_list()
	{
		$data['category']=$this->category->all();
		$data['title']='Manage Job';
		$this->load->blade('admin.job.job_list', $data);
	}

	/**
	 * job list for datatables
	 * @return json
	 */
	function job_list_dt()
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

           if(!empty($search_terms->title))
           {
               $searchStr.=" title like '%{$search_terms->title}%' and ";
           }
       
           if($searchStr!=' where')
           {
               $term.=substr($searchStr,0,strlen($searchStr)-4);
           }
           $filterStr=$term;
       }

       $no = $_POST['start'];
       $term.=" order by id desc limit {$no},{$length}";
      $list = $this->job_model->get_job_list($term);
      
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
              $view_lnk=base_url().'job/job_list/single/'.$item->id;
              $row[] = "<a target='_blank' class='btn btn-small btn-info' title='View' href='{$view_lnk}'><i class='fa fa-eye'></i></a>&nbsp;<a class='btn btn-small btn-primary' title='Edit' href='javascript:void(0)' onclick='edit_job({$item->id})'><i class='fa fa-edit'></i></a>
                    <a class='btn btn-small btn-danger' href='javascript:void(0)' title='Delete' onclick='delete_job({$item->id})'><i class='fa fa-trash-o'></i></a>";

              $data[] = $row;
          }
      }
      $total=$this->job_model->get_total();
      $total_filtered=$this->job_model->get_total($filterStr);
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
		$job_cat=$this->input->post('job_category');
		$title=$this->input->post('txt_title');
		$post_name=$this->input->post('post_name');
		$education=$this->input->post('txt_education');
		$experience=$this->input->post('txt_exp');
		$deadline=$this->date_from_jquery($this->input->post('deadline'));
		$logo_img=$this->input->post('logo');
		$vacancy_no=$this->input->post('txt_vacancy');
		$job_responsibility=$this->input->post('txt_job_details');
		$job_requirements=$this->input->post('txt_job_requirement');
		$job_nature=$this->input->post('ddl_job_nature');
		$experience_requirement_details=$this->input->post('txt_exp_details');
		$aditional_job_requirement=$this->input->post('txt_additional_req');
		$job_location=$this->input->post('location');
		$salary_range=$this->input->post('txt_salary_range');
		$salary_negotiable='';
		$other_benefits='';
		$job_source='';
		$age='';
		$publish_date=$this->date_from_jquery($this->input->post('txt_pub_date'));
		$com_info=$this->input->post('ddl_company');
		$details=$this->input->post('short_desc');
		$create_date=date('Y-m-d H:i:s');
		$is_published=$this->input->post('ck_display');
		$link=$this->input->post('link');
		$link_text=$this->input->post('link_text');
		$location=$this->input->post('location');
		$tags=$this->input->post('tags');
		$is_featured=$this->input->post('is_featured');
		$gender_requirement=$this->input->post('ddl_gender');
		$apply_instructions=$this->input->post('txt_apply_instructions');

		$data=array(
			'user_id'=>$this->userid,
			'job_cat'=>$job_cat,
			'title'=>$title,
			'post_name'=>$post_name,
			'education'=>$education,
			'experience'=>$experience,
			'deadline'=>$deadline,
			'logo_img'=>$logo_img,
			'vacancy_no'=>$vacancy_no,
			'job_responsibility'=>$job_responsibility,
			'job_requirements'=>$job_requirements,
			'job_nature'=>$job_nature,
			'experience_requirement_details'=>$experience_requirement_details,
			'aditional_job_requirement'=>$aditional_job_requirement,
			'job_location'=>$job_location,
			'salary_range'=>$salary_range,
			'salary_negotiable'=>$salary_negotiable,
			'other_benefits'=>$other_benefits,
			'job_source'=>$job_source,
			'age'=>$age,
			'publish_date'=>$publish_date,
			'com_info'=>$com_info,
			'details'=>$details,
			'create_date'=>$create_date,
			'is_published'=>$is_published,
			'link'=>$link,
			'link_text'=>$link_text,
			'location'=>$location,
			'tags'=>$tags,
			'is_featured'=>$is_featured,
			'gender_requirement'=>$gender_requirement,
			'apply_instructions'=>$apply_instructions
			);

		if(!empty($com_info) && !empty($title) && !empty($job_cat) && !empty($post_name))
		{
			$this->job_model->create($data);
			$this->session->set_flashdata('success', 'Job created successfully!');
			redirect(base_url()."admin/job/job_list");
		}
		else
		{
			$this->session->set_flashdata('error', 'Unable to insert!!');
			redirect(base_url()."admin/job");
		}
	}


	function edit()
	{
		$id=$this->uri->segment(4);
		$data['company']=$this->company_model->all();
		$data['categories']=$this->category->all();
		$district_json=file_get_contents(base_url().'asset/district.json');
		$data['district']=json_decode($district_json);
		$data['job']=$this->job_model->find($id);
		$data['title']='Edit Job';
		$this->load->blade('admin.job.edit_job', $data);
	}

	function update()
	{
		$id=$this->input->post('hdn_id');
		$job_cat=$this->input->post('job_category');
		$title=$this->input->post('txt_title');
		$post_name=$this->input->post('post_name');
		$education=$this->input->post('txt_education');
		$experience=$this->input->post('txt_exp');
		$deadline=$this->date_from_jquery($this->input->post('deadline'));
		$logo_img=$this->input->post('logo');
		$vacancy_no=$this->input->post('txt_vacancy');
		$job_responsibility=$this->input->post('txt_job_details');
		$job_requirements=$this->input->post('txt_job_requirement');
		$job_nature=$this->input->post('ddl_job_nature');
		$experience_requirement_details=$this->input->post('txt_exp_details');
		$aditional_job_requirement=$this->input->post('txt_additional_req');
		$job_location=$this->input->post('location');
		$salary_range=$this->input->post('txt_salary_range');
		$salary_negotiable='';
		$other_benefits='';
		$job_source='';
		$age='';
		$publish_date=$this->date_from_jquery($this->input->post('txt_pub_date'));
		$com_info=$this->input->post('ddl_company');
		$details=$this->input->post('short_desc');
		$create_date=date('Y-m-d H:i:s');
		$is_published=$this->input->post('ck_display');
		$link=$this->input->post('link');
		$link_text=$this->input->post('link_text');
		$location=$this->input->post('location');
		$tags=$this->input->post('tags');
		$is_featured=$this->input->post('is_featured');
		$gender_requirement=$this->input->post('ddl_gender');
		$apply_instructions=$this->input->post('txt_apply_instructions');

		$data=array(
			'user_id'=>$this->userid,
			'job_cat'=>$job_cat,
			'title'=>$title,
			'post_name'=>$post_name,
			'education'=>$education,
			'experience'=>$experience,
			'deadline'=>$deadline,
			'logo_img'=>$logo_img,
			'vacancy_no'=>$vacancy_no,
			'job_responsibility'=>$job_responsibility,
			'job_requirements'=>$job_requirements,
			'job_nature'=>$job_nature,
			'experience_requirement_details'=>$experience_requirement_details,
			'aditional_job_requirement'=>$aditional_job_requirement,
			'job_location'=>$job_location,
			'salary_range'=>$salary_range,
			'salary_negotiable'=>$salary_negotiable,
			'other_benefits'=>$other_benefits,
			'job_source'=>$job_source,
			'age'=>$age,
			'publish_date'=>$publish_date,
			'com_info'=>$com_info,
			'details'=>$details,
			'create_date'=>$create_date,
			'is_published'=>$is_published,
			'link'=>$link,
			'link_text'=>$link_text,
			'location'=>$location,
			'tags'=>$tags,
			'is_featured'=>$is_featured,
			'gender_requirement'=>$gender_requirement,
			'apply_instructions'=>$apply_instructions
			);


		if(!empty($com_info) && !empty($title) && !empty($job_cat) && !empty($post_name))
		{
			$this->job_model->update($id,$data);
			$this->session->set_flashdata('success', 'Job updated successfully!');
			redirect(base_url()."admin/job/job_list");
		}
		else
		{
			$this->session->set_flashdata('error', 'Unable to update!!');
			redirect(base_url()."admin/job/edit/".$id);
		}
	}

	function remove()
	{
		$id=$this->input->get('id');
		$this->job_model->delete($id);
		echo json_encode(array("status" => TRUE));
	}

	function pick_files()
	{
		$data['title']='';
		$data['files']=get_filenames('asset/job/');
		$this->load->blade('admin.get_files', $data);
	}

	function load_image()
	{
		$ds= DIRECTORY_SEPARATOR;
		$storeFolder = 'asset/job/';
		if (!empty($_FILES)) {

		    $tempFile = $_FILES['file']['tmp_name'];
		     $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		    $targetFile = $storeFolder.time().'.'.$ext;
		    move_uploaded_file($tempFile,$targetFile);
		}
	}

	function reload_files()
	{
		$files==get_filenames('asset/job/');
		$str='';
		if($files)
		{
			$str.='<ul class="thumbnails">';
			foreach ($files as $file) {
			   $str.="<li class='span4'>";
			   $str.="<a href='' data-img='{$file}' class='thumbnail'>";
			   $src=base_url().'asset/job/'.$file;
			   $str.="<img src='{$src}' alt='Not Found'>";
			   $str.="</a>";
			   $str.="</li>";
			}
			$str.='</ul>';
		}

		echo $str;
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
			redirect(base_url().'admin/job/category');
		}
		$this->session->set_flashdata('error', 'Title must be given !!');
		redirect(base_url().'admin/job/edit_category/'.$id);
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

	function date_from_jquery($dt)
	{
		$str='';
		if(!empty($dt))
		{
			$strArr=explode('-',$dt);
			if(strlen($strArr[0])==2)
			{
				$str=$strArr[2].'-'.$strArr[1].'-'.$strArr[0];
			}else{
				$str=$dt;
			}
		}
		return $str;
	}

}

/* End of file news.php */
/* Location: ./application/controllers/admin/news.php */
