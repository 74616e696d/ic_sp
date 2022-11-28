<?php

class Job extends Eloquent {
	protected $table = 'job_list';
	protected $guarded = ['id'];
	public $timestamps=false;
	
}