<?php
namespace App\Controllers;
use Illuminate\View\Factory as View;

use App\Models\Ref_text_model;
use App\Models\Exam_model;
use Choosen_category_model;

class MemberPracticeSubjectList extends BaseController {

	function __construct()
	{
            
             $this->session = \Config\Services::session();
            $this->session->start();
            
            
            $this->creationDate = $this->session->get('creation_date');
            $this->utype = $this->session->get('utype');
            $this->username = $this->session->get('username');
            $this->userid = $this->session->get('userid');
            if(!$this->userid || $this->userid == '' || !is_numeric($this->userid))
            {
                return redirect()->to(base_url());
                exit;
            }
        
		$this->ref_text_model = new Ref_text_model();
                $this->exam_model = new Exam_model();
		//$this->load->model('ref_text_model');
		//$this->load->model('exam_model');
		//$this->load->model('Exam/choosen_category_model','choosen');
	}

	public function index()
	{
		$data['subject_list']=$this->get_subjects();
		$data['title']='Read & Practice';
                $data['creationdate'] = $this->creationDate;
                $data['username'] = $this->username;
                
                return $this->render('member.practice_subject_list', $data);
		//$this->load->blade('member.practice_subject_list', $data);
	}

	function get_subjects()
	{
		$user=$this->userid;
		//get exam names
		$exam=[];
		$order_cat=['7','318','833','713','680','642','1052'];
		$exams=$this->ref_text_model->search_ref_text(' where group_id=2 ',$order_cat);


		if($exams)
		{
			foreach ($exams as $exm) 
			{
				$data['id']=$exm->id;
				$data['name']=$exm->name;
				array_push($exam, $data);
			}
		}
		//end get exam names
		
		//construct exam wise subject list
		$str="";
		if(count($exam)>0)
		{
			foreach ($exam as $e) 
			{
				$exam_id=$e['id'];

				if($exam_id==713 && ($this->utype<100)){
					continue;
				}
				$subjects=$this->ref_text_model->get_subject_of_exam_cat($exam_id);
				$str.="<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>";
				$str.="<div class='box-cat'>";
				$str.="<h4>{$e['name']}</h4>";

				if($subjects)
				{
					$url='';
					if($e['id']==7){$url=base_url().'member/syllabus/bcs';}
					if($e['id']==642){$url=base_url().'member/syllabus/bcs_written';}
					if($e['id']==318){$url=base_url().'member/syllabus/bank';}
					if($e['id']==680){$url=base_url().'member/syllabus/mba';}
					if($e['id']==713){$url=base_url().'member/syllabus/nibondhon';}

					$str.="<h5 class='guideline'><a href='{$url}'>Exam Guideline</a></h5>";
					$str.="<ul class='list-unstyled'>";
					foreach ($subjects as $subj) {
						$locked=false;
						if($this->utype=='2')
						{
						//$locked=$this->exam_lock_model->is_locked($exm->id);
						}
						elseif($this->utype=='105')
						{
						//$locked=$this->exam_lock_model->is_locked($exm->id);
						}
						$lnk=$locked?base_url()."public/upgrade":base_url()."member/practice/index/{$exam_id}/{$subj->id}";
						$str.="<li><a href='{$lnk}'><i class='fa fa-check'></i> {$subj->name}</a></li>";
					}
					$str.="</ul>";
				}

				$str.="</div>";//end .box-cat
				$str.="</div>";//end start div
				
			}
			
		}
		//end construct exam wise subject list

		return $str;

	}

}

/* End of file practice_subject_list.php */
/* Location: ./application/controllers/member/practice_subject_list.php */