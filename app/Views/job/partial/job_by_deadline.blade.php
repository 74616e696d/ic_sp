<div class="cat-layout">
    <div class="row">
        @if(isset($job_deadline) && $job_deadline)
        <?php
        $ttl=count($job_deadline);
        $max_columns=3;
        $lines=ceil($ttl/$max_columns);
        $job_deadline_chunks=array_chunk($job_deadline,$lines);
       ?>
        @for($i = 0; $i < $ttl; $i ++)
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 c_w_job job_option_c">
            <ul class="ul-layout">
              @if(isset($job_deadline_chunks[$i]))
                @foreach($job_deadline_chunks[$i] as $row)
                  <li>
                      <a href="{{ $base_url }}job/job_list/single/{{ $row->id }}">
                          {{ $row->title }}
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