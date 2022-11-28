<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use Carbon\Carbon;

class Permission_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function reset_user($uid)
	{
		$now=Carbon::now()->toDateTimeString();
		$data=array('update_date'=>$now,
			'mem_type'=>2
			);
		$this->db->where('id',$uid);
		$this->db->update('users',$data);

		$data_upgrade=array('status'=>2,
			'mem_type'=>2,
			'req_date'=>$now,
			'approval_date'=>$now
			);
		$this->db->where('user_id',$uid);
		$this->db->update('upgrade_request',$data_upgrade);
	}

	public static function is_authenticate()
	{
		$ci =& get_instance();
		if($ci->session->userdata('userid'))
		{
			$uid=$ci->session->userdata('userid');
			$ci->db->where('id',$uid);
			$ci->db->select('id','mem_type');
			$q=$ci->db->get('users');
			if($q->num_rows()>0)
			{
				return $q->row()->mem_type;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	/**
	 * Get Payment amount according to membership setting
	 * @return [int] [description]
	 */
	function get_amount($mtype)
	{
		$this->db->where('mem_type',$mtype);
		$this->db->where('setting_key','2');
		$qry=$this->db->get('member_setting');
		if($qry->num_rows()>0)
		{
			return $qry->row()->setting_value;
		}
		else
		{
			return 0;
		}
	}

	function check_discount($discode){
		$code = strtolower($discode);
		$time = date('Y-m-d H:i:s', time());
		$this->db->where('LOWER(code)', $code);
		$this->db->where('expired_date >',$time);
		$qry=$this->db->get('discount');
		if($qry->num_rows()>0)
		{
			return $qry->row()->amount;
		}
		else
		{
			return 0;
		}
	}

	/**
	 * Get Membership Duration In Days
	 * @param  [int] $mtype [description]
	 * @return [int]        [description]
	 */
	function get_duration($mtype)
	{
		$this->db->where('mem_type',$mtype);
		$this->db->where('setting_key','1');
		$qry=$this->db->get('member_setting');
		if($qry->num_rows()>0)
		{
			if(!empty($qry->row()->setting_value))
			{
				return $qry->row()->setting_value;
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 0;
		}
	}


	/**
	 * get how many date remains of current membership
	 * @param  integer $user
	 * @return integer      
	 */
	function date_remains($user)
	{
		$this->db->where('user_id',$user);
		$this->db->select(array('id','approval_date','mem_type'));
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$qry=$this->db->get('upgrade_request');
		if($qry->num_rows()>0)
		{
			$row=$qry->row();
			$dt= new Carbon($row->approval_date);
			$duration=$this->get_duration($row->mem_type);
			$exp=$dt->addDays($duration);
			$now=Carbon::now();
			$exp_diff=$exp->diffInDays($now);
			$exptext=0;
            if($exp->isFuture())
            {
                $exptext=$exp_diff;
            }
            return $exptext;
		}
		else
		{
			return 0;
		}
	}

	/**
	 * determine if current membership of a user is expired or not
	 * @param  integer $uid  
	 * @param  interger $mtype
	 * @return boolean      
	 */
	function current_expired($uid,$mtype)
	{
		$this->db->where('user_id',$uid);
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$qry=$this->db->get('upgrade_request');
		if($qry->num_rows()>0)
		{
			$row=$qry->row();
			if(!empty($row->approval_date))
			{
				$duration=$this->get_duration($row->mem_type);
				$dt=new Carbon($row->approval_date);
				$dt->addDays(trim($duration));
				if($dt->isPast())
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		else
		{
			return true;
		}
	}


    function is_expired($uid)
	{
		$this->db->where('user_id',$uid);
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$qry=$this->db->get('upgrade_request');
		if($qry->num_rows()>0)
		{
			$row=$qry->row();
			if(!empty($row->approval_date))
			{
				$duration=$this->get_duration($row->mem_type);
				$dt=new Carbon($row->approval_date);
				$dt->addDays(trim($duration));
				if($dt->isPast())
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		else
		{
			return true;
		}
	}



	function is_approved($uid,$exam_cat)
	{
		$this->db->where('user_id',$uid);
		$this->db->where('exam_cat',$exam_cat);
		$this->db->select('status');
		$qry=$this->db->get('choosen_exam_cat');
		if($qry->num_rows()>0)
		{
			$result=$qry->result();
			foreach($result as $r)
			{
			
			}
		}
		else
		{
			return false;
		}
	}

	/**
	 * Determine basic user is expired
	 * @param  [int] $uid [description]
	 * @return [boolean]      [description]
	 */
	function basic_expired($uid)
	{
		$this->db->where('id',$uid);
		$this->db->select('update_date');
		$qry=$this->db->get('users');
		if($qry->num_rows()>0)
		{
			$duration=$this->get_duration(2);
			$result=$qry->row()->update_date;
			$dt=new Carbon($result);
			$expiry=$dt;
			if(is_numeric(trim($duration)))
			{

				$expiry=$dt->addDays($duration);
			}
			if($expiry->isPast())
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return true;
		}
	}

	/**
	 * Determine whether a exam category is expired
	 * @param  [int] $uid      [description]
	 * @param  [int] $exam_cat [description]
	 * @return [true]           [description]
	 */
	function choose_expired_by_cat($uid,$exam_cat)
	{
		$this->db->where('user_id',$uid);
		$this->db->where('exam_cat',$exam_cat);
		$this->db->select('expiry_date');
		$qry=$this->db->get('choosen_exam_cat');
		if($qry->num_rows()>0)
		{
			$result=$qry->result();
			foreach($result as $r)
			{
				$exp_date=new Carbon($r->expiry_date);
				if($exp_date->isPast())
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		else
		{
			return true;
		}
	}

	function membership_expired($uid)
	{
		$this->db->where('id',$uid);
		$this->db->select('update_date , mem_type');
		$qry=$this->db->get('users');
		if($qry->num_rows()>0)
		{
			$duration=$this->get_duration($qry->row()->mem_type);
			$result=$qry->row()->update_date;
			$dt=new Carbon($result);
			$expiry=$dt;
			if(is_numeric(trim($duration)))
			{
				$expiry=$dt->addDays($duration);
			}
			if($expiry->isPast())
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return true;
		}
	}


}

/* End of file permission_model.php */
/* Location: ./application/models/permission_model.php */