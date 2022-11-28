<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_detail_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='user_details';
	}	

	static function get_img($uid)
	{
		$ci =& get_instance();
		$ci->db->where('user_id',$uid);
		$qry=$ci->db->get('user_details');
		$img='';
		if($qry->num_rows>0)
		{
			if(!empty($qry->row()->photo))
			{
				$photo=$qry->row()->photo;
				if(file_exists(FCPATH.'asset/images/upload/'.$photo))
				{
					$img=base_url().'asset/images/upload/'.$photo;
				}
				else
				{
					$img=base_url().'asset/img/no-image.jpg';
				}
			}
			else
			{
				$img=base_url().'asset/img/no-image.jpg';
			}
			
		}
		else
		{
			$img=base_url().'asset/img/no-image.jpg';
		}
		return $img;
	}

}

/* End of file user_detail_model.php */
/* Location: ./application/models/user_detail_model.php */