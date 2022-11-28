<?php
class Question extends Eloquent {
	protected $table = 'question_bank';
	protected $guarded = ['id'];
	public $timestamps=false;

	function ExamName()
	{
		return $this->hasOne('Reftext','id','exam_name');
	}

	function Subject()
	{
		return $this->hasOne('Reftext','id','subject');
	}

	function Chapter()
	{
		return $this->hasOne('Reftext','id','chapter');
	}

	function Comp_Id()
	{
		return $this->hasOne('ComprehensionMapping','comp_id','id');
	}
}