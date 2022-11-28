<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Author : Nazrul
 * Description : small Description
 * Total Functions :
 */
class User_management extends Admin_Controller
{
	
function __construct()
{
        parent::__construct();
     
		$this->load->model('User_management_model');
}
public function index()
{
	$data['title']='User Management Area';	
	$data['test']=$this->get_user_setting_info();
	$data['main_content']='admin/v_user_management';	
	$data['user_list']=$this->User_management_model->get_tb_user_management();
	$this->load->view('layout_admin/admin_layout',$data);
	
}
function get_user_setting_info()
{
$table="";
$data=$this->User_management_model->getAllreference_text();
foreach($data as $item)
{
if($item->parent_id==0){
	$table.="<table>";
	$table.="<tr>";
	$table.="<td><input type='checkbox' name='chk[]' value='{$item->name}'></td>";
	$table.="<td>{$item->name}</td>";
	$table.="<td><a href=''><i class='icon icon-edit'></i>Change Password</a>
			<a href=''><i class='icon icon-trash'></i>Delete</a></td>";
	$table.="</tr>";
	$table.="</table>";
}
}
return $table;
}

public function insert_user_setting()
{
$item=$this->input->post('chk');
$selected="";
	foreach($item as $value)
	{
		$selected.=$value.",";
	}
$type=$this->input->post('txttype');
$amount=$this->input->post('txtamount');
$test=$this->input->post('txttest');
$data=array
(
	'u_type'=>$type,
	'u_amount'=>$amount,
	'exam_list'=>$selected,
	'max_num_exam'=>$test
);
$this->User_management_model->add_users_setting($data);
redirect(base_url()."admin/user_management#tab1");
}
}
?>