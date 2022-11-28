@extends('master.master')

@section('summery')
  <div class="row">
      <div class="col-lg-3 col-sm-6">
          <div class="card">
              <div class="content">
                  <div class="row">
                      <div class="col-xs-5">
                          <div class="icon-big icon-warning text-center">
                              <i class="ti-help-alt"></i>
                          </div>
                      </div>
                      <div class="col-xs-7">
                          <div class="numbers">
                              <p>New Questions</p>
                              10
                          </div>
                      </div>
                  </div>
                  <div class="footer">
                      <hr />
                      <div class="stats">
                          <i class="ti-pencil-alt2"></i> Answer Now
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-lg-3 col-sm-6">
          <div class="card">
              <div class="content">
                  <div class="row">
                      <div class="col-xs-5">
                          <div class="icon-big icon-success text-center">
                              <i class="ti-check"></i>
                          </div>
                      </div>
                      <div class="col-xs-7">
                          <div class="numbers">
                              <p>Answered</p>
                              20
                          </div>
                      </div>
                  </div>
                  <div class="footer">
                      <hr />
                      <div class="stats">
                          <i class="ti-zoom-in"></i> View
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-lg-3 col-sm-6">
          <div class="card">
              <div class="content">
                  <div class="row">
                      <div class="col-xs-5">
                          <div class="icon-big icon-danger text-center">
                              <i class="ti-pulse"></i>
                          </div>
                      </div>
                      <div class="col-xs-7">
                          <div class="numbers">
                              <p>Errors</p>
                              23
                          </div>
                      </div>
                  </div>
                  <div class="footer">
                      <hr />
                      <div class="stats">
                          <i class="ti-timer"></i> In the last hour
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-lg-3 col-sm-6">
          <div class="card">
              <div class="content">
                  <div class="row">
                      <div class="col-xs-5">
                          <div class="icon-big icon-info text-center">
                              <i class="ti-twitter-alt"></i>
                          </div>
                      </div>
                      <div class="col-xs-7">
                          <div class="numbers">
                              <p>Followers</p>
                              +45
                          </div>
                      </div>
                  </div>
                  <div class="footer">
                      <hr />
                      <div class="stats">
                          <i class="ti-reload"></i> Updated now
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
@stop


@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="header">
            <h4 class="title">{{ isset($title)?$title:'Dashboard' }}</h4>
        </div>
        <div class="content" style='min-height: 400px;'>
        
        </div>
    </div>
</div>
@stop

@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $.notify({
            icon: 'ti-gift',
            message: "Welcome to <b>Iconpreparation Expert Zone</b>"

          },{
              type: 'success',
              timer: 4000
          });

    });
</script>
@stop