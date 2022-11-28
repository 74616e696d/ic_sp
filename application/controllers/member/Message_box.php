<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message_box extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_message_model');
		$this->load->model('message_model');
		$this->load->model('user_model');
	}
	public function index()
	{
		$data['message']=$this->get_message();
		$data['title']='Message Box';
		$this->load->blade('member.message_box', $data);
	}


	function get_message()
	{
		$term=" where um.user_id={$this->userid}";
		$message=$this->message_model->get_message($term);
		$str='';
		if($message)
		{
			foreach ($message as $m) {
				if($m->is_read==0)
				{
					$dt=date_create($m->publish_date);
					$dtf=date_format($dt,'d F,Y H:i');
					$read_url=base_url()."member/message_box/show/{$m->mid}";
					$username=$this->user_model->get_user_name($m->user_id);
					 $str.="<tr class='unread'>";
					 $str.="<td class='small-col'><input type='checkbox' /></td>";
					 $str.="<td class='name'><a href='{$read_url}'>{$username}</a></td>";
					 $str.="<td class='subject'><a href='{$read_url}'>{$m->title}</a></td>";
					 $str.="<td class='time'>{$dtf}</td>";
					 $str.="</tr>";
				}
				else
				{
					$str.="<tr>";
					$str.="<td class='small-col'><input type='checkbox' /></td>";
					$str.="<td class='name'><a href='{$read_url}'>{$username}</a></td>";
					$str.="<td class='subject'><a href='{$read_url}'>{$m->title}</a></td>";
					$str.="<td class='time'>{$dtf}</td>";
					$str.="</tr>";
				}
			}

		}
		else
			{
				$str.="<tr>";
				$str.="<td colspan='4'>You have no message</td>";
				$str.="</tr>";
			}
		return $str;

	}

	function show()
	{
		$id=$this->uri->segment(4);
		$msg=$this->message_model->find($id);
		$this->user_message_model->update($id,array('is_read'=>1));
		$data['title']='Message';
		$data['msg']=$msg;
		$this->load->blade('member/message_details', $data);
	}

}

/* End of file message_box.php */
/* Location: ./application/controllers/member/message_box.php */