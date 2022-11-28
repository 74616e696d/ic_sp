<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}	

	function get_old_users($limit)
	{
		$sql="select id from users order by id asc limit {$limit}";
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

	function add_user($data,$details)
	{
		$this->db->trans_start();
		$this->db->insert('users',$data);
		$insert_id = $this->db->insert_id();
		$details['user_id']=$insert_id;
		$this->db->insert('user_details',$details);
        $this->db->trans_complete();
        return $insert_id;
	}
	function add($data)
	{
		$this->db->trans_start();
		$this->db->insert('users',$data);
		$insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
	}

	function exist($field_name,$field_value)
	{
		$this->db->where($field_name,$field_value);
		$qry=$this->db->get('users');
		if($qry->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	function get_reserved_users()
	{
		$this->db->where_in('mem_type',array('101','102'));
		$this->db->select(array('id','user_name'));
		$qry=$this->db->get('users');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function get_user_like($key)
	{
		$this->db->like('email',$key, 'after'); 
		$this->db->select(array('id','email'));
		$qry=$this->db->get('users');
		if($qry->num_rows())
		{
			return $qry->result();
		}
		else
		{
			false;
		}
	}

	function add_details($data)
	{
		$this->db->insert('user_details',$data);
		return;
	}

	function add_reg_member($data1,$data2,$data3)
	{
		$this->db->trans_start();
			$this->db->insert('users',$data1);
			$uid= $this->db->insert_id();
			$data2['user_id']=$uid;
			$data3['user_id']=$uid;
			$this->db->insert('upgrade_request',$data2);
			$this->db->insert('user_details',$data3);

		$this->db->trans_complete();
		return $uid;
	}
	function get_user_details($id)
	{
		$this->db->where('users.id',$id);
		$this->db->select('users.*,user_details.full_name,user_details.address,user_details.phone,user_details.photo');
		$this->db->from('users');
		$this->db->join('user_details','users.id=user_details.user_id');
		$q=$this->db->get();
		if($q->num_rows()>0)
		{
			return $q->row();
		}
		else
		{
			return false;
		}
	}
	function get_total($key=''){
		$sql="select id from users ".$key;
		$query=$this->db->query($sql);
		if($query->num_rows()>0)
		{
			return $query->num_rows();

		}else{
			return false;
		}
	}

	function find_by_email($email)
	{
		$this->db->where('email',$email);
		$qry=$this->db->get('users');
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}

	function find_by_phone($phone)
	{
		$this->db->where('phone',$phone);
		$qry=$this->db->get('users');
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}

	function get_users($start,$limit,$key='')
	{
		$sql="select * from users ".$key.' limit '.$start.','.$limit;
		$query=$this->db->query($sql);
		if($query->num_rows())
		{
			$result=$query->result();
			return $result;
		}
		else
		{
			return false;
		}
	}

	function get_users_list($start,$limit,$key='')
	{
		$sql="select u.*, ud.phone from users u join user_details ud on u.id=ud.user_id ".$key.' limit '.$start.','.$limit;
		$query=$this->db->query($sql);
		if($query->num_rows())
		{
			$result=$query->result();
			return $result;
		}
		else
		{
			return false;
		}
	}


	function get_users_total($terms='')
	{
		$sql="select u.*, ud.phone from users u join user_details ud on u.id=ud.user_id ".$terms;
		$query=$this->db->query($sql);
		return $query->num_rows();
	}

	static function get_user_email($id)
	{
		$ci =& get_instance();
		$ci->db->where('id',$id);
		$ci->db->select(array('email'));
		$qry=$ci->db->get('users');
		if($qry->num_rows()>0)
		{
			return $qry->row()->email;
		}
		else
		{
			return '';
		}

	}

	public static function user_exist($user_name)
	{
		$ci =& get_instance();
		$ci->db->where('user_name',$user_name);
		$ci->db->select('id');
		$q=$ci->db->get('users');
		if($q->num_rows()>0)
		{
			return true;
		}else
		{
			return false;
		}
	}
	public static function get_user_name($uid)
	{
		$ci =& get_instance();
		$ci->db->where('id',$uid);
		$ci->db->select('user_name');
		$q=$ci->db->get('users');
		if($q->num_rows()>0)
		{
			return $q->row()->user_name;
		}else
		{
			return false;
		}
	}
	public static function validate_password($user_id,$password)
	{
		$ci =& get_instance();
		$ci->db->where('id',$user_id);
		$ci->db->select('password');
		$q=$ci->db->get('users');
		if($q->num_rows()>0)
		{
			if($q->row()->password==sha1($password))
			{
				return true;
			}
			else{
				return false;
			}

		}
		else
		{
			return false;
		}
	}

	function find($user)
	{
		$this->db->where('id',$user);
		$qry=$this->db->get('users');
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}

	static function find_user($user)
	{
		$ci =& get_instance();
		$ci->db->where('id',$user);
		$qry=$ci->db->get('users');
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}

	function find_details($uid)
	{
		$this->db->where('user_id',$uid);
		$qry=$this->db->get('user_details');
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}

	function active_users()
	{
		$this->db->where('is_active','1');
		$qry=$this->db->get('users');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function active_user_by_group($group)
	{
		$this->db->where('mem_type',$group);
		$this->db->where('is_active','1');
		$qry=$this->db->get('users');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}
	public static function email_exist($email)
	{
		$ci =& get_instance();
		$ci->db->where('email',$email);
		$ci->db->select('id');
		$q=$ci->db->get('users');
		if($q->num_rows()>0)
		{
			return true;
		}else
		{
			return false;
		}
	}

	public static function activate_user_by_id($uid,$status=0)
	{
		$ci =& get_instance();
		$ci->db->where('id',$uid);
		$ci->db->update('users',array('is_active'=>$status,'update_date'=>date('Y-m-d H:i:s')));
	}

	public static function activate_user($user_name,$status=0)
	{
		$ci =& get_instance();
		$ci->db->where('user_name',$user_name);
		$ci->db->update('users',array('is_active'=>$status,'update_date'=>date('Y-m-d H:i:s')));
	}

	function activate($key,$data)
	{
		$this->db->where('user_key',$key);
		$this->db->update('users',$data);
	}

	function update_user($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('users',$data);
	}

	function reset_user($email,$data)
	{
		$this->db->where('email',$email);
		$this->db->update('users',$data);
	}

	function update_user_details($uid,$data)
	{
		$this->db->where('user_id',$uid);
		$this->db->update('user_details',$data);
	}

	function delete($id)
	{
		$this->db->trans_start();

		$this->db->where('user_id',$id);
		$this->db->delete('user_details');

		$this->db->where('user_id',$id);
		$this->db->delete('mem_point');

		$this->db->where('user_id',$id);
		$this->db->delete('mem_point_history');

		$this->db->where('user_id',$id);
		$this->db->delete('upgrade_request');

		$this->db->where('id',$id);
		$this->db->delete('users');

		$this->db->trans_complete();
	}

}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */