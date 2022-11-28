<?php

class CurrentNewsModel extends Eloquent{

	protected $table = 'current_news';
	protected $guarded = ['id'];
	public $timestamps = false;

	 public function fetchcatagory()
	{
    	return $this->belongsTo('CurrentNewsCatagoryModel', 'category_id');
	}


	public function getTitleAttribute($value)
	{
		$value=Quiz::sanitizeString(['&nbsp;','\n','<sub>','<sup>','&acute','&gt;','&lsquo;','&rsquo;','&mdash;','&#39;','&ndash;','&rdquo;','&hellip;','&ldquo;','&quot;','<u>','</u>','&amp;','</sub>','</sup>','&zwnj;','&times;','&radic;'],$value);
		return $value;
	}

	public function getShortDescAttribute($value)
	{
		$value=Quiz::sanitizeString(['&nbsp;','\n','<sub>','<sup>','&acute','&gt;','&lsquo;','&rsquo;','&mdash;','&#39;','&ndash;','&rdquo;','&hellip;','&ldquo;','&quot;','<u>','</u>','&amp;','</sub>','</sup>','&zwnj;','&times;','&radic;'],$value);
		return $value;
	}

	public function getDetailsAttribute($value)
	{
		$value=Quiz::sanitizeString(['&nbsp;','\n','<sub>','<sup>','&acute','&gt;','&lsquo;','&rsquo;','&mdash;','&#39;','&ndash;','&rdquo;','&hellip;','&ldquo;','&quot;','<u>','</u>','&amp;','</sub>','</sup>','&zwnj;','&times;','&radic;'],$value);
		return $value;
	}
}