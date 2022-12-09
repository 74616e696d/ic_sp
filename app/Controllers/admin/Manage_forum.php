<?php

class Manage_forum extends Admin_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper('text');
		$this->load->model('forum/frm_post_model','frm');
		$this->load->model('forum/frm_comment_model','cmnt');
		$this->load->model('user_model');
		$this->load->library('pagination');
		$this->load->helper('common');
		$this->load->helper('text');
	}
	public function index()
	{
		$data['title']='Managee Forum';
		$this->load->blade('admin.forum.index', $data);
	}

	function forum_posts_dt()
	{
		 $length=$_POST['length'];
		 $term='';
		 $search=$_POST['search']['value'];
		 $filterStr='';
		 if($search){
		     $search_terms=json_decode($search);
		     $searchStr=' where';
		     if(!empty($search_terms->id))
		     {
		         $searchStr.=" id=$search_terms->id and ";
		     }
		     if(!empty($search_terms->title))
		     {
		         $searchStr.=" title like '%{$search_terms->title}%' and ";
		     }
		     if($search_terms->status!=3)
		     {
		     	$status=$search_terms->status==1?1:0;
		         $searchStr.=" display={$status} and ";
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
		$list = $this->frm->search_posts($term);
		
		$data = array();
		if($list)
		{
		    foreach($list as $item) 
		    {
		        $no++;
		        $row = array();
		  
		        $row[] = $no;
		        $row[] = $item->title;
		        $dtls=strip_tags($item->details);
		        $dtls=character_limiter($dtls,150,'.....');
		        $row[]=$dtls;
		        $row[] = date('d M, Y',strtotime($item->post_date));
		        $pub=$item->display?'Published':'Not Published';
		        $row[] = "<label class='checkbox'><input type='checkbox' value='{$item->id}' class='permit'/> {$pub}</label>";
		        $edit_url=base_url().'admin/manage_forum/edit/'.$item->id;
		        $action= " <a class='btn btn-small btn-info' title='Edit' href='{$edit_url}'><i class='fa fa-edit'></i></a>
		              <a class='btn btn-small btn-danger' href='javascript:void(0)' title='Delete' onclick='delete_post({$item->id})'><i class='fa fa-trash-o'></i></a>";
		        $row[]=$action;

		        $data[] = $row;
		    }
		}
		$total=$this->frm->count_posts();
		$total_filtered=$this->frm->count_posts($filterStr);
		$output = array(
		                "draw" => $_POST['draw'],
		                "recordsTotal" =>$total ,
		                "recordsFiltered" => $total_filtered,
		                "data" => $data,
		        );
		//output to json format
		echo json_encode($output);
	}


	function comment()
	{

	}

	function edit()
	{
		$id=$this->uri->segment(4);
		$data['post']=$this->frm->find($id);
		$data['title']='Edit Forum Post';
		$this->load->blade('admin.forum.edit', $data);
	}

	function update()
	{
		$id=$this->input->post('hdn_id');
		$title=$this->input->post('post_title');
		$details=$this->input->post('post_details');
		$display=$this->input->post('ck_display');
		if(!empty($title))
		{
			$file_name=$this->input->post('hdn_curr_img');

			if(isset($_FILES['userfile']) && is_uploaded_file($_FILES['userfile']['tmp_name']))
			{
				if(file_exists('asset/upload/forum/'.$file_name))
				{
					unlink('asset/upload/forum/'.$file_name);
				}
				$file_name=$this->upload_feature_image();
			}
			$data=['title'=>$title,'details'=>$details,'feature_image'=>$file_name,'display'=>$display];
			$this->frm->update($id,$data);
			$this->session->set_flashdata('success', 'Successfully updated!!');
			redirect(base_url().'admin/manage_forum');
		}
		else
		{
			$this->session->set_flashdata('error', 'unable to update!!');
			redirect(base_url().'admin/manage_forum/edit.'.$id);
		}
	}

	function upload_feature_image()
	{
		$file_name='';
		$config['upload_path'] = './asset/upload/forum/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size']  = '10000';
		$config['file_name']  = time().'_forum';
		// $config['max_width']  = '1024';
		// $config['max_height']  = '768';
		
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
		}
		else
		{
			$data = $this->upload->data();
			$file_name=$data['file_name'];
		}
		return $file_name;
	}


	function publish()
	{
		$id=$this->input->post('id');
		$stat=$this->input->post('stat');
		$this->frm->update($id,array('display'=>$stat));
		echo 'ok';
	}


	function delete()
	{
		$id=$this->uri->segment(4);
		$this->frm->delete($id);
		$this->cmnt->delete_by('post_id',$id);
		$this->session->set_flashdata('success', 'successfully deleted!!');
		redirect(base_url()."admin/manage_forum");
	}

}

/* End of file manage_forum.php */
/* Location: ./application/controllers/forum/manage_forum.php */