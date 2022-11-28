@extends('master.layout')

@section('content')
<div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 col-tabs"> <!-- required for floating -->
  <!-- Nav tabs -->
  <ul class="nav nav-tabs tabs-left"><!-- 'tabs-right' for right tabs -->
    <li class="active"><a href="#home" data-toggle="tab">কিভাবে আবেদন করবেন <i class="fa fa-chevron-right pull-right"></i></a></li>
    <li><a href="#profile" data-toggle="tab">সিলেবাস  <i class="fa fa-chevron-right pull-right"></i></a></li>
    <li><a href="#messages" data-toggle="tab">কিভাবে প্রস্তুতি নিবেন <i class="fa fa-chevron-right pull-right"></i></a></li>
  </ul>
</div>
<div class="col-lg-9 col-md-9 col-xs-12 col-sm-12 col-tab-content">
    <!-- Tab panes -->
    <div class="tab-content">
     <div class="tab-pane active" id="home">
      	
      </div> <!-- end apply instructions -->
      <div class="tab-pane" id="profile">
     
      </div>
      <div class="tab-pane" id="messages">
      	
      </div>
    </div>
</div>
@stop

@section('style')
<link rel="stylesheet" href="{{$base_url}}asset/member/css/bootstrap.vertical-tabs.min.css">
<style>
.nav-tabs>li>a:hover
{
	/*display: inline-block;*/
}
.nav-tabs>li.active,.nav-tabs>li.active>a
{
	background: #0177BF;
	color: #fff;
}
/*.nav-tabs>li.active>a
{
	color: color
}*/
.col-tabs
{
	padding-right: 0;
	padding-left: 0;
	/*min-height: 550px;*/
	background: #e2e2e2;
}
.tabs-left > li, .tabs-right > li
{
	margin-bottom: 0;
}
.col-tab-content
{
	padding-left: 0;
      padding-right: 0;
}
.tabs-left, .tabs-right
{
	padding-top: 0;
}
.tab-content
{
	min-height: 550px;
	background: #fff;
	padding-top: 10px;
	padding-left: 15px;
	padding-right: 15px;
	line-height:20px;
}
.tabs-left li
{
	border-bottom: 1px solid #f6f6f6;
}

.tabs-left > li > a
{
	font-size: 18px;
	text-align: center;
	border-radius: 0;
}

.tabs-left > li > a>i
{
	display: none;
	line-height: 1.5;
}

.list-main
{

}
.list-main>li
{
	padding-top:5px;
	padding-bottom: 5px;
}

.list-main>li>p
{
	font-size: 16px;
	background: #e2e2e2;
	padding:5px;
}

.list-inner li
{
	padding-bottom:7px;
	padding-left: 10px;
}
</style>
@stop