@extends('front_layout/layout')

@section('content')
  <div class="row">
    <div id="result" class="col-sm-4 col-sm-offset-4">
      
    </div>
  </div>
@stop

@section('style')
<style>
  .list-group-item
  {
    padding:6px;
  }
  .list-group-item span:first-child
  {
    /*float:left;*/
  }

  .list-group-item span:last-child
  {
    /*float: right;*/
  }
  #result
  {
    /*background:#fff;*/
    padding:25px 10px;
    min-height:400px;

  }
</style>
@stop

@section('script')
<script type="text/javascript" src="{{$base_url}}asset/js/jstorage.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    var ttnm ='',
     timeTaken ={{ $time }},
     ttl=20;

     var obj=new Array(),
       loopCount=parseInt(ttl);
       obj.push({'test_name':ttnm,'timeTaken':timeTaken});
     for(var i=1;i<loopCount+1; i++)
     {
       var itemStr=$.jStorage.get('ans'+i);
       if(itemStr!=null)
       {
         var item=JSON.parse(itemStr);
         obj.push(item);
       }
     }

      $.ajax({
        url:'{{ $base_url }}sample_exam/display_result',
        type: 'POST',
        data:{'obj':JSON.stringify(obj)}
      })
     .success(function(data) 
     {
          $('#result').html(data);
      });

  });
</script>
@stop