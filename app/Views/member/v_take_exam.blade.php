@extends('master.layout')

@section('content')
    <div class="row">
        <div class="col-sm-12">
        <div class="bx">
            <div class="bx bx-header">
                <h4 class="bx-title">Previous Exam List</h4>
            </div>
            <div class="bx bx-body"> 
            <div class="row row-cat">
              <!-- <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> -->
              {!! $cats_str !!}
              <!-- </div> -->
            </div>   
            <br/>
            <div class="tbl-responsive">
                {!! $exam_list !!}
            </div>       
            </div>
        </div>
        </div>
    </div> 
@stop

@section('style')
<link rel="stylesheet" href="{{$base_url}}/asset/member/css/table.css">
<link rel="stylesheet" href="{{$base_url}}/asset/css/loader.css">
<style>
    .box-cat h4 {
        color: #ffffff !important;
    }
   .tbl-responsive tr th:nth-child(1),.tbl-responsive tr td:nth-child(1)
    {
      width:50%; 
    }
   .tbl-responsive tr th:nth-child(2),.tbl-responsive tr td:nth-child(2)
    {
      width:20%; 
    }
  @media only screen and (max-width: 800px) 
  {
    #btn_search
    {
      margin-top:5px;
    }
    .tbl-responsive tr th:nth-child(1),.tbl-responsive tr td:nth-child(1)
     {
       width:100%; 
     }
    .tbl-responsive tr th:nth-child(2),.tbl-responsive tr td:nth-child(2)
    {
      width:100%; 
    }

    .tbl-responsive tr th:nth-child(3),.tbl-responsive tr td:nth-child(3)
    {
      width:100%; 
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

@section('script')
<script type="text/javascript" src="{{$base_url}}/asset/js/jquery.isloading.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('.btn-cat').click(function(){
    var cat=$(this).data('cat');
     go_to_table();
    $('.tbl-responsive').isLoading({
          text: "Loading",
          position: "overlay"
          });
      $.ajax({
        url: '{{ $base_url }}member/take_exam/get_exam_list',
        type: 'POST',
        data: {cat:cat},
      })
      .done(function(data) {
        $('.tbl-responsive').html(data);
        $( ".tbl-responsive" ).isLoading( "hide" );
      });
  });

});

function go_to_table()
{
  $('html, body').animate({
        'scrollTop' : $(".tbl-responsive").position().top
    });
}
</script>

@stop