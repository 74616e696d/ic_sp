<?php

class ChapterLockMapping extends Eloquent {

	protected $table = 'chapter_lock_mapping';
	protected $guarded = ['chapter_id'];
	public $timestamps=false;

}