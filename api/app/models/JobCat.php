<?php

class JobCat extends Eloquent {
	protected $table = 'job_category';
	protected $guarded = ['id'];
	public $timestamps=false;
	
}