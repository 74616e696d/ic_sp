<?php

class Today extends Eloquent {
	protected $table = 'what_happened_today';
	protected $guarded = ['id'];
	public $timestamps=false;
}