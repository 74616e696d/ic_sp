<?php
class Vocabulary extends Eloquent {
	protected $table = 'vocabulary';
	protected $guarded = ['id'];
	public $timestamps=false;
}