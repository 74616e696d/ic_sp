<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Author : Shamim
 * Description : small Description
 * Total Functions :
 */
class User_management_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
function get_tb_user_management()
{
 $sql='select *from tb_user_setting';
        $query=$this->db->query($sql);
        if($query->num_rows()>0)
        {
            $result=$query->result();
            return $result;
        }else{
            return false;
        }
}
function getAllreference_text()
{
 $sql='select *from ref_text';
        $query=$this->db->query($sql);
        if($query->num_rows()>0)
        {
            $result=$query->result();
            return $result;
        }else{
            return false;
        }
}
    function add_users_setting($data)
    {
        $this->db->insert('tb_user_setting',$data);
        return;
    }
    function question_get_all($start=0,$limit=10,$key='')
    {
        $sql='select *from question_bank '.$key.' limit '.$start.','.$limit;
        $query=$this->db->query($sql);
        if($query->num_rows()>0)
        {
            $result=$query->result();
            return $result;
        }else{
            return false;
        }
    }
    function question_update($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('question_bank',$data);
    }
    function question_delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('question_bank');
		return"succss";
    }
}	