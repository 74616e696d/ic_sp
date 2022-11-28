<?php

class CourseEnrollment extends Eloquent {
	protected $table = 'course_enrollment_request
';
	protected $guarded = ['id'];
	public $timestamps=false;
	
}