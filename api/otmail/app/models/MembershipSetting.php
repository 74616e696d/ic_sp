<?php

class MembershipSetting extends Eloquent {

	protected $table = 'member_setting';
	protected $guarded = ['id'];
    public $timestamps=false;


    function membership()
    {
    	return $this->belongsTo('Membership','mem_type');
    }

    function meta()
    {
    	return $this->belongsTo('MembershipSettingMeta','setting_key');
    }
}


class MembershipSettingMeta extends Eloquent{

	protected $table="member_setting_meta";
	protected $guarded=['id'];
	public $timestamps=false;
    
}