<?php

class RoadmapDetails extends Eloquent {
	protected $table = 'roadmap_details';
	protected $guarded = ['id'];
	public $timestamps=false;
	
	public function topic_name()
	{

		return $this->belongsTo('Reftext','topics','id');
	}
}