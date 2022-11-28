<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fix_seperator extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('fix_model');
	}
	public function index()
	{
		// $str="<p>indulgent//////@@intolerant//////merciful///compassionate</p>";
		// $new=str_replace('//////', '///',$str);
		// echo $new;
		$data['title']='Fix Extra Seperator';
		$this->load->blade('fix_seperator', $data);
	}

	function fix()
	{
		$ques=$this->fix_model->all(array('id','options'));
		if($ques)
		{
			foreach ($ques as $q) 
			{
				$option=$q->options;
				if(strpos($option,'//////'))
				{
					$new_option=str_replace('//////','///',$option);
					$data=array('options'=>$new_option);
					$this->fix_model->update($q->id,$data);
				}
			}

			echo "Success fully fixed!";
		
		}
	}

}

/* End of file fix_seperator.php */
/* Location: ./application/controllers/fix_seperator.php */