<?php 

namespace App\Models\member;
use CodeIgniter\Model;

class Upgrade_model extends Model {

	function __construct() {
		parent::__construct();
	}

	function add($data) {
		$this->db->insert('upgrade_request', $data);
		return $this->db->insert_id();
	}

	function add_amount($data) {
		$this->db->insert('users_payment', $data);
		return;
	}

	function pending_count($user)
	{
		$this->db->where('user_id',$user);
		$this->db->where('status','1');
		$qry=$this->db->get('upgrade_request');
		if($qry->num_rows()>0)
		{
			return $qry->num_rows();
		}
		else
		{
			return false;
		}
	}

	function reset_pending($user)
	{
		$this->db->where('user_id',$user);
		$this->db->where('status','1');
		$this->db->update('upgrade_request',array('status'=>'0','req_date'=>'0000-00-00 00:00:00','approval_date'=>'0000-00-00 00:00:00'));
	}

	function get_top_user_pending($user,$mtype)
	{
		$this->db->where('user_id',$user);
		$this->db->where('mem_type',$mtype);
		$this->db->select('ur.*,up.id as pid,up.req_id,up.amount,up.payment_date,up.payment_code,up.payment_status');
		$this->db->from('upgrade_request ur');
		$this->db->join('users_payment up','ur.id=up.req_id');
		$qry=$this->db->get();
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}

	}

	function exists($user_id)
	{
		$this->db->where('user_id',$user_id);
		$qry=$this->db->get('upgrade_request');
		if($qry->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function has_pending($user) {
		$this->db->where('user_id', $user);
		$this->db->where('status', '1');
		$qry = $this->db->get('upgrade_request');
		if ($qry->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	function find1($id) {
		$this->db->where('id', $id);
		$qry = $this->db->get('upgrade_request');
		if ($qry->num_rows() > 0) {
			return $qry->row();
		} else {
			return false;
		}
	}

	function all() {
		$qry = $this->db->get('upgrade_request');
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	function total($key) {
		$sql = "select *from upgrade_request {$key}";
		$qry = $this->db->query($sql);
		if ($qry->num_rows() > 0) {
			return $qry->num_rows();
		} else {
			return 0;
		}
	}

	function total_request($key) {
		$sql = "select ur.id from upgrade_request ur {$key} order by req_date";
		$qry = $this->db->query($sql);
		if ($qry->num_rows() > 0) {
			return $qry->num_rows();
		} else {
			return 0;
		}
	}

	function all_request($start, $limit, $key) {
		$sql = "select ur.* from upgrade_request ur {$key} order by req_date limit {$start},{$limit}";

		$qry = $this->db->query($sql);
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	function all_by_key($start, $limit, $key) {
		$sql = "select *from upgrade_request {$key} order by req_date limit {$start},{$limit}";
		$qry = $this->db->query($sql);
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	function find_by_user($user) {
		return $this->db->table('upgrade_request')->where('user_id', $user)->orderBy('id','desc')->limit(1)->get()->getRow();
		/*if ($qry->num_rows() > 0) {
			return $qry->row();
		} else {
			return false;
		}*/
	}
	static function get_mtext($id) {
		$ci = &get_instance();
		$ci->db->where('id', $id);
		$ci->db->select('name');
		$qry = $ci->db->get('membership');
		if ($qry->num_rows() > 0) {
			return $qry->row()->name;
		} else {
			return '';
		}
	}
	function update1($user, $data) {
		$this->db->where('user_id', $user);
		$this->db->update('upgrade_request', $data);
		$this->db->where('user_id',$user);
		$req_id=$this->db->get('upgrade_request')->row()->id; 
		return $req_id;
	}

	function update_bkash_code($id,$req_id,$data)
	{
		$this->db->where('id',$id);
		$this->db->where('req_id',$req_id);
		$this->db->update('users_payment',$data);
	}

	function update_by_id($id, $data) {
		$this->db->where('id', $id);
		$this->db->update('upgrade_request', $data);
	}

}

/* End of file upgrade_model.php */
/* Location: ./application/models/member/upgrade_model.php */