<?php

class Course extends Eloquent {
	protected $table = 'course';
	protected $guarded = ['id'];
	public $timestamps=false;

}