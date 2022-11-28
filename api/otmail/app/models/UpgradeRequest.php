<?php

class UpgradeRequest extends Eloquent {

	protected $table = 'upgrade_request';
	protected $guarded = ['id'];
    public $timestamps=false;

    function user()
    {
    	return $this->hasOne('User');
    }

}
