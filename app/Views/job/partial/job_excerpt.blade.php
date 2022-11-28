@if($jobs)
@foreach($jobs as $row)
<div class="item-media">
    <div class="col-md-12 col-sm-12 xs-12">
        <div class="layout-box">
        	<?php 
        		$com_id=!empty($row->com_info)?$row->com_info:0;
        		$company=Company_model::get_company_info($com_id);
                $logo=$company?$company->logo:'';
        	?>
            <a class='job_excerpt' href="{{ $base_url }}job/job_list/single/{{ $row->id }}">
                @if(!empty($logo) && is_file_exist($logo))
                <div class="thumb-box">
                    <img width="56" src="{{ $logo }}" alt=''/>
                </div>
                @else
                <div class="thumb-box">
                    <img width="56" src="{{ $base_url }}asset/frontend/img/blank_logo.png" alt=''/>
                </div>
                @endif
                <h4>
                    {{ $row->post_name  }}
                </h4>
                <h2>
                    {{ $company?$company->company_name:'' }}
                </h2>
                <p>
                    Education: {{  $row->education }}. Experience: {{  $row->experience  }}
                </p>
                <div class="date">
                    Deadline: {{  date('M  d,  Y', strtotime($row->deadline))  }}
                </div>
            </a>
        </div>
    </div>
</div>
@endforeach
@endif