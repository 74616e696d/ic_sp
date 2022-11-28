<?php

class Batch extends Eloquent {
	protected $table = 'batch';
	protected $guarded = ['batch_id'];
	public $timestamps=false;
	
}