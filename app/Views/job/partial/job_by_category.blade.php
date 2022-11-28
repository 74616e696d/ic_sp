<div class="cat-layout">
  @if(count($jobCategories))
  <div class="row">
    <?php
      $ttl = count($jobCategories);
      $max_columns = 3;
      $lines = ceil($ttl / $max_columns);
      $job_chunks = array_chunk($jobCategories, $lines);
      ?>
    @for($p = 0; $p < $max_columns; $p ++) 
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 c_w_job job_option_c">
      <ul class="ul-layout">
        @if(isset($job_chunks[$p]))
        @foreach($job_chunks[$p] as $row)
        <li>
          <a href="/job/job_list/details/{{ $row->id }}/cat">
            {{ $row->title }} ({{ $row->total  }})
          </a>
        </li>
        @endforeach
        @endif
      </ul>
    </div>
    @endfor
  </div>
  @endif
</div>