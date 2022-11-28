<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once  APPPATH.'libraries/facebook.php';
class FBConnect extends facebook
{
	public $user = NULL;
    public $user_id = FALSE;
	function __construct()
	{
		$config=array('appId'=>'340664209421681',
			'secret'=>'d7c490e67d661227e98611f710a503c4');
		parent::__construct($config);
		$this->user_id=$this->getUser();
		if($this->user_id)
		{
			try
			{
				$me=$this->api('/me');
				$this->user=$me;
			}
			catch (FacebookApiException $e)
			{
				return $e;
			}
		}
	}
}