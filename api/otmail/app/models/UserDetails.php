<?php

class UserDetails extends Eloquent {

	protected $table = 'user_details';
	protected $guarded = ['id'];
    public $timestamps=false;

    function user()
    {
    	return $this->belongsTo('User');
    }


}
