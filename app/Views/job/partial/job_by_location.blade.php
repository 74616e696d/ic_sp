<div class="cat-layout">
    <div class="row">
    @if(isset($job_location) && $job_location)
    <?php
    $ttl=count($job_location);
    $max_columns=3;
    $lines=ceil($ttl/$max_columns);
    $job_location_chunks=array_chunk($job_location,$lines);
   ?>
        @for($i = 0; $i < $max_columns; $i++)
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 c_w_job job_option_c">
            <ul class="ul-layout">
              @if(isset($job_location_chunks[$i]))
              @foreach($job_location_chunks[$i] as $row)
                <li>
                    <a href="{{ $base_url }}job/job_list/details_location/{{ $row->location }}">
                        {{ $row->location }} ({{ $row->total  }})
                    </a>
                </li>
              @endforeach
              @endif
            </ul>
        </div>
        @endfor
        @endif
    </div>
</div>
