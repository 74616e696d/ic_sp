<div class="container circular">
    <h2>
        <i class="fa fa-briefcase"></i><br/>
        JOB CIRCULAR
    </h2>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <h3>Deadline Tomorrow</h3>
            @if($news_with_deadline)
            <ul class="list-unstyled">
                @foreach($news_with_deadline as $row)
                <li>
                    <img src="{{$base_url}}asset/job/{{$row->logo_img}}" alt="{{$row->title}}">
                    <div class='circular-body'>
                        <h5><a href="{{$base_url}}index/news_details/{{$row->id}}">{{$row->title}}</a></h5>
                        <p>Published Date:{{date_short($row->publish_date)}}</p>
                        <div>{{$row->post_name}}</div>
                    </div>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <h3>Recently Published Job</h3>
           @if($news)
           <ul class="list-unstyled">
               @foreach($news as $row)
               <li>
                   <img src="{{$base_url}}asset/job/{{$row->logo_img}}" alt="{{$row->title}}">
                   <div class='circular-body'>
                       <h5><a href="{{$base_url}}index/news_details/{{$row->id}}">{{$row->title}}</a></h5>
                       <p>Published Date:{{date_short($row->publish_date)}}</p>
                       <div>{{$row->post_name}}</div>
                   </div>
               </li>
               @endforeach
           </ul>
           @endif
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
           <img src="{{$base_url}}asset/frontend/img/ad.jpg" alt="Studypress">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
      <a href='{{$base_url}}index/news_details' class="btn btn-default btn-job">
          View All Jobs
      </a>
    </div>
    <div class="clearfix">

    </div>
    <div class="spacer"></div>
</div>
