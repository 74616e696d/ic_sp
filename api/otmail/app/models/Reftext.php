<?php

class Reftext extends Eloquent {
	protected $table = 'ref_text';
	protected $guarded = ['id'];
	public $timestamps=false;
	

	function children()
	{
		return $this->hasMany('Reftext','parent_id');
	}

	function parent()
	{
		return $this->belongsTo('Reftext','parent_id');
	}
}