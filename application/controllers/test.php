<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use Intervention\Image\ImageManagerStatic as Image;
class Test extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('extra_model');
		$this->load->model('fix_model');
		$this->load->helper('path');
		// $this->load->library('Elfinder_lib');
	}
	public function index()
	{
//echo phpinfo();
		$sql= <<< EOT
select * from cv_template
		
EOT;
$qry=$this->db->query($sql);
var_dump($qry);
var_dump($qry->result());
		//$data['title']='Testing Things';
		//$this->load->blade('testing', $data);
	}

	function elfinder_init()
	{
	  
	  $opts = array(
	    'debug' => true, 
	    'roots' => array(
	      array( 
	        'driver' => 'LocalFileSystem', 
	        'path'   => set_realpath('asset/media'), 
	        'URL'    => site_url('asset/media') . '/'
	        // more elFinder options here
	      ) 
	    )
	  );
	  $this->load->library('elfinder_lib', $opts);
	}

	function img_test()
	{
		$img = Image::make('http://iconpreparation.com/asset/news/sp_5637597930c6c.jpg');
		$img->fit(300, 300,'crop');
		echo $img->response();
	}

	function change()
	{
		// $this->db->where('chapter',391);
		// $rows=$this->db->update('question_bank',['subject'=>333]);
		// echo 'success  '.$rows;
	}

    
	function alterTable()
	{
		$sql= <<< EOT
CREATE TABLE cv_desc (
  id int(11) NOT NULL AUTO_INCREMENT,
  description text COLLATE utf8_unicode_ci,
  video_link varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
		
EOT;

		$result=$this->db->query($sql);
		if($result)
		{
			echo "successfully created!!";
		}
		else
		{
			echo "Unable to create";
		}
	}

	function fx_user()
	{
		echo "starting fixing....<br/>";
		//$this->fix_model->fix_user();
		echo "fixed";
	}

	/**
	 * manually create model test
	 */
	function add()
	{
		$cat=1242;
		

		$chapter_group=[
		//Bangla

		1437=>3,

		1438=>3,
		1439=>3,

		1440=>2,

		1441=>2,

		1442=>3,

		1443=>3,

		1444=>2,

		1445=>2,

		1446=>2,


		//Math

		1463=>2,


		1464=>2,





		1466=>2,


		1467=>2,


		1468=>3,


		1469=>2,



		1471=>2,


		1472=>2,


		1473=>2,


		1474=>2,


		1475=>2,




		1477=>2,




		//English


		1449=>3,
		1450=>3,
		1451=>3,
		1452=>3,
		1453=>4,
		1456=>3,
		1457=>3,
		1459=>3,

		//GK 

		1483=>1,
		1484=>1,
		1485=>1,
		1486=>1,
		1487=>1,
		1488=>1,  
		/*1489=>1,  
		1490=>1,  
		1491=>1,*/ 
		1492=>1, 
		1493=>1, 
		1494=>1, 
		1495=>1, 
		1496=>1, 
		1497=>1,  
		1498=>1,  
		1499=>1,  
		1501=>1, 
		1503=>1,  
		1504=>1,  
		1507=>1, 
		1508=>1,  
		1509=>1, 
		1510=>1,  
		1511=>1,
		1512=>1,  
		1513=>1,  
		1514=>1,
    

		];


		$ttl=$this->ttl_ques($chapter_group);

		$model_test=array('category'=>$cat,
			'name'=>'NTRCA School Test1',
			'marks_carry'=>1,
			'total_ques'=>100,
			'time'=>60,
			'display'=>0,
			'is_paid'=>0);

		$tid=$this->extra_model->create_model_test($model_test);
		echo "Model Test created....<br/><br/>";
		$test_id=$tid;

		$data_batch=[];
		foreach ($chapter_group as $key => $value) {
			$qid=$this->extra_model->get_rand_ques($key,$value);
			// var_dump($qid);
			if($qid)
			{
				
				foreach ($qid as $q) {

					$data=array('test_id'=>$test_id,
						'qid'=>$q->id);
					array_push($data_batch,$data);

					echo "inserting.......<br/>";

				}
			}
		}
		// var_dump($data_batch);
		// $this->extra_model->add($data);
		$this->extra_model->batch_add($data_batch);
		echo "{$ttl} question insert completed ...";
	}


	function ttl_ques($data)
	{
		$ttl=0;
		foreach ($data as $key => $value) {
			$ttl+=(int)$value;
		}
		return $ttl;
	}

	/**
	 * Transfer question from one category to another
	 */
	function transfer_ques()
	{
		if($this->uri->segment(3) && $this->uri->segment(4))
		{
			$id=$this->uri->segment(3);
			$des=$this->uri->segment(4);

			//get all questions by chapters
			$this->db->where('chapter',$id);
			$qry=$this->db->get('question_bank');
			$questions=false;
			$total= $qry->num_rows();
			if($qry->num_rows()>0){
				$questions=$qry->result();
			}
			//get all questions by chapters
			
			if($questions)
			{
				$ques=[];
				foreach($questions as $q)
				{
					$data['subject']=$q->subject;
					$data['chapter_group']=$q->chapter_group;
					$data['chapter']=$des;
					$data['question']=$q->question;
					$data['hints']=$q->hints;
					$data['display']=1;
					$data['is_prev']=$q->is_prev;
					$data['options']=$q->options;
					$data['has_paragraph']=$q->has_paragraph;
					$data['question_grade']=$q->question_grade;
					$data['question_source']=$q->question_source;
					$data['tags']=$q->tags;
					$data['period']=$q->period;
					$data['is_changeable']=$q->is_changeable;
					$data['created_at']=date('Y-m-d H:i:s');
					array_push($ques, $data);
					echo "<br/>inserting...";
				}

				//$this->db->insert_batch('question_bank',$ques);
				echo "<br/>INSERTED  SUCCESSFULLY FROM CHAPTER-{$id} TO CHAPTER-{$des} <br/> TOTAL AFFECTED:{$total}";
			}
			else{
				echo "NO QUESTIONS FOUND !!";
			}
		}
	}
	
	function delete_extra()
	{
		$this->db->where('chapter',433);
		$date=date('Y-m-d');
		$this->db->where('DATE(created_at)',$date);
		$qry=$this->db->get('question_bank');
		echo $qry->num_rows();
		//$this->db->delete("question_bank");
		echo "Successfully deleted";
	}

	
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */

