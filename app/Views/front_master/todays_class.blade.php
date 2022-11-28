@if($todays_class)
<h2 class="ribbon">
TODAY'S CLASS
<div class="ribbon-icon"></div>
</h2>
<div class="container todays-class">
<?php $cnt=count($todays_class); ?>
@foreach($todays_class as $row)
    @if($cnt==4)
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
    @else
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
    @endif
        <h3>{{$row->name}}</h3>
        <?php
        $tm=date_create($row->event_time);
        $tmf=date_format($tm,'d M, Y');
        ?>
        <label class="checkbox">
            <input type="checkbox" name="ck_join" class="ck_join"> Check In Now
        </label>
    </div>
@endforeach
</div>
@endif
