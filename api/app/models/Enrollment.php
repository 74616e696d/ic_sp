<?php

class Enrollment extends Eloquent {
	protected $table = 'enrollment';
	protected $guarded = ['id'];
	public $timestamps=false;
}