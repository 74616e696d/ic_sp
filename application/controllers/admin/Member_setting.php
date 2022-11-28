<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_setting extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
  
        //$this->load->model('membership_model');
        $this->load->model('member_setting_model');
        $this->load->helper('message');
    }
	public function index()
	{
        $data['mem_types']=$this->membership_model->get_members();
		$data['title']='Member Setting';
		//$data['main_content']='admin/v_member_setting';
		//$this->load->view('layout_admin/admin_layout',$data);
    $this->load->blade('admin.v_member_setting', $data);
	}

    public function mem_meta()
    {
        $mem_type_id=$this->input->get('mem_type');
        $metas=array();
       if($this->member_setting_model->get_meta_by_type($mem_type_id))
       {
           $mts=$this->member_setting_model->get_meta_by_type($mem_type_id);
           foreach($mts as $m)
           {
               array_push($metas,array('mkey_id'=>$m->setting_key,
                   'mkey'=>member_setting_model::meta_text($m->setting_key),
                   'mvalue'=>$m->setting_value
               ));
           }

           //Getting Newly Added Setting Meta Key
           $new_mts=$this->member_setting_model->get_new_member_setting_meta($mem_type_id);
           if($new_mts)
           {
               foreach($new_mts as $m)
               {
                   array_push($metas,array('mkey_id'=>$m->id,
                       'mkey'=>$m->meta_name,
                       'mvalue'=>''
                   ));
               }
           }//End Getting Newly Added Setting Meta Key


       }
        else
        {
            $mts=$this->member_setting_model->get_meta();
            if($mts)
            {
              foreach($mts as $m)
              {
                 array_push($metas,array('mkey_id'=>$m->id,
                      'mkey'=>member_setting_model::meta_text($m->id),
                      'mvalue'=>''
                  ));
              }
            }
        }

        $str='';
        $str.="<ul class='list-group'>";
        for($i=0;$i<count($metas);$i++)
        {
            $key_id=$metas[$i]['mkey_id'];
            $key_text=$metas[$i]['mkey'];
            $key_value=$metas[$i]['mvalue'];
            //$str.="<label>Setting Key:</label>";
            $str.="<li class='list-group-item'>";
            $str.="<div class='form-inline'>";
            $str.="<input type='hidden' name='hdn_key[]' value='{$key_id}'/>";
            $str.="<input type='text' disabled name='txt_key[]' value='{$key_text}'/>&nbsp;&nbsp;";
            //$str.="<label>Setting Value:</label>";
            $str.="<input type='text' name='txt_value[]' value='{$key_value}'/>";
            $str.="</div>";
            $str.="</li>";
        }
        $str.="</ul>";
        $str.=  "<button type='submit' id='btn_save' class='btn btn-info' name='btnSave'><i class='fa fa-save'></i>&nbsp;Save</button>";
        echo $str;
    }

   public function save()
   {
        $mem_type=$this->input->post('ddl_mem_type');
        $skey=$this->input->post('hdn_key');
        $svalue=$this->input->post('txt_value');
       try {
       for($i=0;$i<count($skey);$i++){
            $key=$skey[$i];
            $val=$svalue[$i];

         $data=array('mem_type'=>$mem_type,
                    'setting_key'=>$key,
                    'setting_value'=>$val);


               if ($this->member_setting_model->HasMemberSetting($mem_type, $key)) {
                   $this->member_setting_model->update($mem_type, $key, $data);
               } else {
                   $this->member_setting_model->insert($data);
               }
           }
           $this->session->set_flashdata('success','successfully saved!!');
           redirect(base_url().'admin/member_setting');
       }
   catch (Exception $e) {

       $this->session->set_flashdata('error',$e->getMessage());
       redirect(base_url().'admin/member_setting');
   }
   }
}

