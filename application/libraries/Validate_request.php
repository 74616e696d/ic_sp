<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Validate_request{
	/**
	   * Holds CI instance
	   *
	   * @var CI instance
	   */
	  private $CI;
	 
	  /**
	   * Name used to store token on session
	   *
	   * @var string
	   */
	  private static $token_name = '_token';
	 
	  /**
	   * Stores the token
	   *
	   * @var string
	   */
	  private static $token;
	 
	  public function __construct()
	  {
	    $this->CI =& get_instance();
	  }

	  /**
	   * Generates a CSRF token and stores it on session. Only one token per session is generated.
	   * This must be tied to a post-controller hook, and before the hook
	   * that calls the inject_tokens method().
	   *
	   * @return void
	   * @author Ian Murray
	   */
	  public function generate_token()
	  {
	    $this->CI->load->library('session');
	    // if ($this->CI->session->userdata(self::$token_name) === FALSE)
	    // {
	      self::$token = md5(uniqid() . microtime() . rand());
	      $this->CI->session->set_userdata(self::$token_name, self::$token);
	    // }
	  }

	  function csrf_name()
	  {
	  	return self::$token_name;
	  }

	  function csrf_value()
	  {
	  	return self::$token;
	  }

	  /**
	   * Validates a submitted token when POST request is made.
	   *
	   * @return void
	   * @author Ian Murray
	   */
	  public function validate_tokens()
	  {
	    // Is this a post request?
	    if ($_SERVER['REQUEST_METHOD'] == 'POST')
	    {
	      // Is the token field set and valid?
	      $posted_token = $this->CI->input->post(self::$token_name);
	      if ($posted_token === FALSE || $posted_token != $this->CI->session->userdata(self::$token_name))
	      {
				return false;	        
	      }
      	 $this->CI->session->unset_userdata(self::$token_name);
      	 return true;
	    }
	  }

}