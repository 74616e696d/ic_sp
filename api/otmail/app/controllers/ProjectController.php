<?php

class ProjectController extends BaseController {

	function index()
	{
		$list=Project::all();
		return $list;
	}

	function find_project($id)
	{
		return Project::find($id);
	}

	function store()
	{
		$data=array('name'=>Input::get('name'),
			'details'=>Input::get('detail'),
			'display'=>Input::get('display'));
		Project::create($data);
		$msg='ok';
		return ['msg'=>$msg];
	}

}