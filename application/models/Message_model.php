<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table="message";
	}


	function get_message($term)
	{
		$sql="select m.id as mid,m.create_date,m.title,m.details,m.publish_date,m.published,
		um.id as uid,um.user_id,um.is_read from message m inner join user_message um on m.assign_to=um.user_id {$term}";

		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function add($data)
	{
		$this->db->trans_start();
		$this->db->insert('message',$data);
		$insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
	}
	
	

}

/* End of file message_model.php */
/* Location: ./application/models/message_model.php */