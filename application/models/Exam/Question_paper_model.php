<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Author : Shamim
 * Description : small Description
 * Total Functions :
 */
class Question_paper_model extends CI_Model 
{
public function __construct() 
	{ 
		parent::__construct(); 
	}
		
function get_questionPaper($exam_name)
{
		$sql="select *from question_bank where exam_name='".$exam_name."'";
        $query=$this->db->query($sql);
        if($query->num_rows()>0)
        {
            $result=$query->result();
            return $result;
        }else{
            return false;
        }
}

}
?>