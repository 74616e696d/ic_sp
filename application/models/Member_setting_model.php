<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User: MD. SHAMSUDDOHA MAJUMDER(SHAMIM)
 * Date: 1/15/14
 * Time: 11:32 AM
 */
class Member_setting_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert($data)
    {
        $this->db->insert('member_setting',$data);
        return;
    }
    public  function HasMemberSetting($mid,$skey)
    {
        $this->db->where('mem_type',$mid);
        $this->db->where('setting_key',$skey);
        $query= $this->db->get('member_setting');
        if($query->num_rows()>0)
        {
            return true;
        }
        else
        {
            return false;
        }

    }
   public  function get_meta_by_type($mid)
   {
       $this->db->where('mem_type',$mid);
       $query=$this->db->get('member_setting');
       if($query->num_rows()>0)
       {
           $result=$query->result();
           return $result;
       }else{
           return false;
       }
   }

    public  static  function meta_text($id)
    {
        $ci =& get_instance();
        $ci->db->where('id',$id);
        $ci->db->select('meta_name');
        $query=$ci->db->get('member_setting_meta');
        if($query->num_rows()>0){
            $result=$query->row()->meta_name;
            return $result;
        }
        else
        {
            return false;
        }

    }
    public function get_meta()
    {
        $query=$this->db->get('member_setting_meta');
        if($query->num_rows()>0)
        {
            $result=$query->result();
            return $result;
        }else{
            return false;
        }
    }

    public function update($mid,$key,$data)
    {
        $this->db->where('mem_type',$mid);
        $this->db->where('setting_key',$key);
        $this->db->update('member_setting',$data);
    }

    public function get_new_member_setting_meta($mid)
    {
       $sql='select *from member_setting_meta where member_setting_meta.id not in(select setting_key from member_setting where mem_type='.$mid.')';
        $query=$this->db->query($sql);
        if($query->num_rows()>0)
        {
            $result=$query->result();
            return $result;

        }
        else{
            return false;
        }
    }

}
