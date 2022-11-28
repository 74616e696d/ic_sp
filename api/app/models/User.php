<?php

class User extends Eloquent {

	protected $table = 'users';
	protected $guarded = ['id'];
    public $timestamps=false;

    public function details()
    {
    	return $this->hasOne('UserDetails');
    }

    function membership()
    {
    	return $this->belongsTo('Membership','mem_type');
    }

    function upgrade()
    {
        return $this->hasOne('UpgradeRequest','user_id');
    }
}
