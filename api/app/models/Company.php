<?php

class Company extends Eloquent {
	protected $table = 'company_info';
	protected $guarded = ['id'];
	public $timestamps=false;
}