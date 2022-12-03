@extends('job.front_master.master')

@section('content')

<section class="box-wrapper">
    <div class="wrapper-counts-job-box">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-sm-8 xs-12">
                     <form method="post" action="{{ $base_url }}job/job_list/search" class="form-inline">
                       <input type="text" name="term" id="term" class="form-control" style='width:50%' value="{{ $term }}">
                       <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
                       <br><br>
                     </form>
                        <br>
                            <div class="full-border-box">
                                <div class="inner-border-box">
                                    <div class="col-md-6 col-sm-6 xs-12">
                                        <div class="box-layout">
                                            <ul>
                                                <li>
                                                    <span>
                                                        <span class="job-count">
                                                           {{-- {{ count($jobs) }} --}}
                                                        </span>
                                                        Jobs
                                                    </span>
                                                </li>
                                                <li>
                                                    <a class="btn btn-default cat-btn" href="#">
                                                        Get new jobs by email
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 xs-12">
                                        <div class="box-right">
                                            <ul>
                                                <li class="label">
                                                    Sort order :
                                                </li>
                                                <li>
                                                    Relevance
                                                </li>
                                                <li>
                                                    Date
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="clear-fix">
                                </div>
                                <div id="job-excerpt">
                                     @if($jobs)
                                     
                                      @foreach($jobs as $row)
                                          <?php 
                                            $com_id=!empty($row->com_info)?$row->com_info:0;
                                            $company=Company_model::get_company_info($com_id);
                                            $logo=$company?$company->logo:'';
                                          ?>
                                        <div class="item-media">
                                          <a class="job_excerpt" href="{{ $base_url }}job/job_list/single/{{ $row->id }}">
                                            @if(!empty($logo))
                                            <div class="thumb-box">
                                                <img width="56" src="{{ $logo }}" alt=''/>
                                            </div>
                                            @endif
                                             <h4 class="organization_name">{{ $row->title  }}</h4>
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

                                      @endforeach
                                    @else
                                    <p>No Job Found !</p>
                                     @endif

                                 </div>
                                <!-- End Item media -->
                            </div>
                        </br>
                    </div>
                    <div class="col-md-4 col-sm-4 xs-12">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('style')
<style>
  body{
    background: #f7f7f7;
}
.job_excerpt 
{

}
.job_excerpt h2{
  font-size: 24px !important;
}
.job_excerpt h4{
  font-size: 20px !important;
}
.job_excerpt p,.job_excerpt .date{
  color: #444 !important;
}
.footer-list li a{
  text-decoration: none;
  font-size: 14px;
  line-height: 32px;
  color: #fff;
}
</style>
@stop


@section('script')
<script type="text/javascript">
    $(document).ready(function() {
  //get_job_excerpt();
  // $('#cat').change(function(event) {
  //   get_job_excerpt();
  // });

});

// function get_job_excerpt()
// {
//   var cat=$('#cat').val();
//   $.ajax({
//     url: '{{ $base_url }}job/job_list/get_job_excerpt_list',
//     type: 'POST',
//     data: {cat: cat}
//   })
//   .done(function(res) {
//     $('#job-excerpt').html(res);
//   });
// }
</script>
@stop
