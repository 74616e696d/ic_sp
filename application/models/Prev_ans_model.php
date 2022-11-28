<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
/**
     * Author : Shamim
     * Last Update : 17-01-2013
     * Description : small Description
     * Total Functions : 10
     */
class Prev_ans_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
   	function insert_prev_ans($data)
	{
		$this->db->insert('prev_ans',$data);
		return;
	}
    function prev_ans_all()
	{
		$sql='select *from prev_ans';
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
    