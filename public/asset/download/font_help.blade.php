@extends('front_layout.layout')

@section('content')

<div class='wrapper'>
	<h3>Problem with Bengali Font?</h3>
	<div>
		<p>
			If you are using Windows Vista or later version, the contents of this site are compatible with the system fonts you already have in you computer.
		</p>
		<p>
			For Windows XP or earlier version you have to install a Unicode font which supports Bengali. It's a matter of few seconds to install the font by following the given instructions.
		</p>
		<p>
			For Mac version <a target="_blank" href="{{$base_url}}asset/download/ek-osx-font.dmg.zip">Download</a> the font and configure it according to Mac OS.
		</p>
		<p>
			1. For Windows XP or earlier version download any font you like from bellow	<br>
			<a target="_blank" href="{{$base_url}}asset/download/arialuni.zip">Download Arial Unicode</a>
		</p>
	</div>
</div>

@stop

@section('style')
<style>
	.wrapper
	{
		min-height:400px;
		padding-left:20px;
	}
</style>
@stop