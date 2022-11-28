@if(isset($student_jobs) && $student_jobs)
<div class="row">
    <?php
      $ttl=count($student_jobs);
      $max_columns=4;
      $lines=ceil($ttl/$max_columns);
    ?>
    @for($i = 0; $i < $ttl; $i ++)
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="hot-box">
            <?php 
                $com_id=!empty($student_jobs[$i]->com_info)?$student_jobs[$i]->com_info:0;
                $company=Company_model::get_company_info($com_id);
                $logo=$company?$company->logo:'';
            ?>
            @if(!empty($logo) && is_file_exist($logo))
            <a href="{{ $base_url }}job/job_list/single/{{ $student_jobs[$i]->id }}">
                <img alt="{{ $student_jobs[$i]->post_name }}" src="{{ $logo }}" width="56"></img>
            </a>
            @else
            <a href="{{ $base_url }}job/job_list/single/{{ $student_jobs[$i]->id }}">
                <img alt="{{ $student_jobs[$i]->post_name }}" src="{{ $base_url }}asset/frontend/img/blank_logo.png" width="56"></img>
            </a>
            @endif
            <h2>
                <a href="{{ $base_url }}job/job_list/single/{{ $student_jobs[$i]->id }}">
                    {{ $student_jobs[$i]->company_name }}
                </a>
            </h2>
            <p>
                {{ $student_jobs[$i]->post_name }}
                <br>
                    No Of Vacancy ({{ $student_jobs[$i]->vacancy_no>0?$student_jobs[$i]->vacancy_no:0 }})
                </br>
            </p>
        </div>
    </div>
    @endfor
</div>
@else
<p style='text-align:center;font-size:17px;padding-top:10px;padding-bottom:10px;'>No Student Job Available Now</p>
@endif
