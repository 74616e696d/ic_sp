@extends('front_master.master')

@section('content')

<!-- START HEADER -->
@include('front_master.header')
<!-- END HEADER -->

<!-- START COUNTER -->
@include('front_master.counter')
<!-- END COUNTER -->

<!-- START MODULES -->
@include('front_master.modules')
<!-- END MODULES -->



<!-- START FEATURE   -->
@include('front_master.features')
<!-- END FEATURE   -->


<!-- START MOBILE APPS -->
@include('front_master.mobile_apps')
<!-- END MOBILE APPS -->

<!-- START JOB CIRCULAR -->
@include('front_master.job')
<!-- END JOB CIRCULAR -->

<!-- START TODAYS CLAS -->
@include('front_master.todays_class')
<!-- END TODAYS CLASS -->

<!-- START FEATURED IN -->
@include('front_master.featured_in')
<!-- END FEATURED IN -->
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function() {
  $('.ck_join').click(function(event) {
    window.location.href='{{base_url()}}public/user_reg';
  });

});
</script>
@stop
