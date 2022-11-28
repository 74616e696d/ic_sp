<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Author : Shamim
 * Description : small Description
 * Total Functions :
 */
class Home_model extends CI_Model 
{
public function __construct() 
	{ 
		parent::__construct(); 
	}
		
function show_ref_text()
{
 $sql="select *from ref_text where parent_id='0'";
        $query=$this->db->query($sql);
        if($query->num_rows()>0)
        {
            $result=$query->result();
            return $result;
        }else{
            return false;
        }
}
function show_parent_text($p){
 $sql="select *from ref_text where parent_id='".$p."'";
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