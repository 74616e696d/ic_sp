<div class="cat-layout">
    <div class="row">
        @if($job_company)
        <?php
        $ttl=count($job_company);
        $max_columns=3;
        $lines=ceil($ttl/$max_columns);
        $job_company_chunks=array_chunk($job_company,$lines);
       ?>
        @for($i = 0; $i < $max_columns; $i ++)
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 c_w_job job_option_c">
            <ul class="ul-layout">
              @if(isset($job_company_chunks[$i]))
                  @foreach($job_company_chunks[$i] as $row)
                    <li>
                        <?php $company_slug=$ci->slug->create_slug($row->company_name,1); ?>
                        <a href="{{ $base_url }}job/job_list/details_company/{{ $row->id }}/{{ $company_slug  }}">
                            {{ $row->company_name }} ({{ $row->total  }})
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
