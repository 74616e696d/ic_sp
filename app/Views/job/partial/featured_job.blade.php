    @if(isset($featured_job) && $featured_job)
        <div class="row">
            <?php
              $ttl=count($featured_job);
              $max_columns=4;
              $lines=ceil($ttl/$max_columns);
             ?>
            @for($i = 0; $i < $ttl; $i ++)
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="hot-box">
                    <?php 
                        $com_id=!empty($featured_job[$i]->com_info)?$featured_job[$i]->com_info:0;
                        $company=Company_model::get_company_info($com_id);
                        $logo=$company->logo;
                    ?>
                    @if(!empty($logo))
                    <img width='66' src="{{ $logo }}" alt="{{ $featured_job[$i]->post_name }}">
                    @else
                    <img width='66' src="{{ $base_url }}asset/frontend/img/blank_logo.png" class='thumbnail' alt="{{ $featured_job[$i]->post_name }}">
                    @endif    
                 
                    <h2>
                        <a href="{{ $base_url }}job/job_list/single/{{ $featured_job[$i]->id }}">
                            {{ $featured_job[$i]->company_name }}
                        </a>
                    </h2>
                    <p>
                        {{ $featured_job[$i]->post_name }}
                        <br>
                        No Of Vacancy ({{ $featured_job[$i]->vacancy_no>0?$featured_job[$i]->vacancy_no:"N/A" }})
                    </p>
                </div>
            </div>
            @endfor
        </div>
    @endif
