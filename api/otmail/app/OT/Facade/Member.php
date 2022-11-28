<?php namespace OT\Facade;

use Illuminate\Support\Facades\Facade;

class Member extends Facade
{
	protected static function getFacadeAccessor() { return 'member'; }
}