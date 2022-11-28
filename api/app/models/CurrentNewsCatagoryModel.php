<?php

class CurrentNewsCatagoryModel extends Eloquent{

	protected $table = 'current_news_category';
	protected $guarded = ['id'];
	public $timestamps = false;


	public function getNameAttribute($value)
	{
		$sanitize=[
		"&"=>'and'
		];

		foreach ($sanitize as $key => $v) {
			$value=str_replace($key,$v,$value);
		}

	    return $value;
	}

	
}