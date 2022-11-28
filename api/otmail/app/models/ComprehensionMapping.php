<?php

class ComprehensionMapping extends Eloquent {
	protected $table = 'comprehension_ques';
	protected $guarded = ['id'];
	public $timestamps=false;

	function Comprehension()
	{
		return $this->hasOne('Comprehension','id','comp_id');
	}

}