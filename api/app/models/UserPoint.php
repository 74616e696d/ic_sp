<?php

class UserPoint extends Eloquent {

	protected $table = 'user_point';
	protected $guarded = ['user_point_id'];
    public $timestamps=false;
}
