<?php

class RefDetails extends Eloquent {
	protected $table = 'ref_details';
	protected $guarded = ['id'];
	public $timestamps=false;


	function reftext()
	{
		return $this->belongsTo('Reftext','ref_id');
	}

}