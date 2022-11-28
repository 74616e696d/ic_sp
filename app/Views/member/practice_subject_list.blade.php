@extends('master.layout')

@section('content')
    <div class="row">
        <div class="col-sm-12">
        <div class="bx">
            <div class="bx bx-header">
                <h4 class="bx-title">Read &amp; Practice</h4>
            </div>
            <div class="bx bx-body"> 
              <div class="row row-cat">
                {!! $subject_list !!}
              </div>
            </div>
        </div>
        </div>
    </div> 
@stop

@section('style')
<style>
.box-cat h4 {
    color: #fff !important;
    line-height: 30px;
    border-bottom: 1px solid #fffe00;
}
.box-cat ul li a {
    color: #fff !important;
}
.box-cat
{
  min-height: 400px;
}
.guideline a
{
  font-size: 14px; 
  color:#FE7F28;
}
  @media only screen and (max-width: 800px) 
  {
    #btn_search
    {
      margin-top:5px;
    }

    .total:before
    {
      padding-right:3% !important;
    }
    .test_name:before
    {
      padding-right:3% !important;
    }
    .dt:before
    {
      padding-right:10% !important;
    }

    .start:before  
    {
      padding-right:1% !important;
    }

  }
</style>
@stop