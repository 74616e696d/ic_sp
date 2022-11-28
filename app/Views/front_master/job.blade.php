<div class="container circular">
    <h2>
        <i class="fa fa-briefcase"></i><br/>
        JOB CIRCULAR
    </h2>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <h3>Student Jobs</h3>
            @if($student_jobs)
            <ul class="list-unstyled">
                @foreach($student_jobs as $row)
                  <?php 
                  $com_id1=!empty($row->com_info)?$row->com_info:0;
                  $company1=Company_model::get_company_info($com_id1);
                  $logo1=$company1?$company1->logo:'';
                ?>
                <li>
                    @if(!empty($logo1) && is_file_exist($logo1))
                    <img src="{{ $logo1 }}" alt="{{$row->title}}">
                    @else
                    <img src="{{ $base_url }}asset/frontend/img/blank_logo.png" alt="{{$row->title}}">
                    @endif
                    <div class='circular-body'>
                        <h5><a href="{{$base_url}}job/job_list/single/{{$row->id}}">{{$row->title}}</a></h5>
                        <p>Published Date:{{date_short($row->publish_date)}}</p>
                        <div>{{$row->post_name}}</div>
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <p>No Student Job Available Now</p>
            @endif
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <h3>Recently Published Jobs</h3>
           @if($jobs)
           <ul class="list-unstyled">
               @foreach($jobs as $row)
                <?php 
                  $com_id2=!empty($row->com_info)?$row->com_info:0;
                  $company2=Company_model::get_company_info($com_id2);
                  $logo2=$company2?$company2->logo:'';
                ?>
               <li>
                   @if(!empty($logo2) && is_file_exist($logo2))
                    <img src="{{ $logo2 }}" alt="{{$row->title}}">
                   @else
                   <img src="{{$base_url}}asset/frontend/img/blank_logo.png" alt="{{$row->title}}">
                   @endif
                   <div class='circular-body'>
                       <h5><a href="{{$base_url}}job/job_list/single/{{$row->id}}">{{$row->title}}</a></h5>
                       <p>Published Date:{{date_short($row->publish_date)}}</p>
                       <div>{{$row->post_name}}</div>
                   </div>
               </li>
               @endforeach
           </ul>
           @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
      <a href='{{$base_url}}job/job_list' class="btn btn-default btn-job">
          View All Jobs
      </a>
    </div>
    <div class="clearfix">

    </div>
    <div class="spacer"></div>
</div>
