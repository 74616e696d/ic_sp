<?php 
namespace App\Controllers\Member;
use Illuminate\View\Factory as View;
use App\Controllers\MemberController;

use App\Models\Ref_text_model;
use App\Models\Quiz_summery_model;

class ChapterProgressController extends MemberController {

	function __construct()
	{
		//parent::__construct();
		//$this->load->model('ref_text_model');
		//$this->load->model('quiz_summery_model');
            
            $this->quiz_summery_model = new Quiz_summery_model();
            
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
	}
	public function index()
	{
		$data['quiz']=$this->quiz_summery_model->find_user_quiz($this->userid);
		$data['title']='Chapter Progress';
                
                $data['creationdate'] = $this->creationDate;
                $data['username'] = $this->username;
                
                return $this->render('member.chapter_progress', $data);
		//$this->load->blade('member.chapter_progress', $data);
	}

}

/* End of file chapter_progress.php */
/* Location: ./application/controllers/member/chapter_progress.php */