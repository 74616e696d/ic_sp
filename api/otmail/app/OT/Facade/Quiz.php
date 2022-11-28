<?php namespace OT\Facade;

use Illuminate\Support\Facades\Facade;

class Quiz extends Facade
{
	protected static function getFacadeAccessor() { return 'quiz'; }
}