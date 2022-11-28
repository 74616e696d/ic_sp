@extends('master.layout')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="bx">
            <div class="bx bx-header">
                <h4 class="bx-title">Read &amp; agree the following terms &amp; conditions</h4>
            </div>
            <div class="bx bx-body">
                    <!-- <h5 class="box-title">Term &amp; conditions</h5> -->
                        <ol class="lst-ol">
                            <li>You must not sell, rent or sub-license material from the website</li>
                            <li>You must not reproduce, duplicate, copy or otherwise exploit material on this website for a commercial purpose</li>
                            <li>You must ensure that the user ID and password are kept confidential.</li>
                            <li>This site is not the substitute of text book. </li>
                            <li>There is no link between this site authority and competitive examination authority. </li>
                            <li>You must take a plan to be a regular member and get benefited from the site. </li>
                        </ol>

                        <p><a class="btn btn-info" href="{{$url}}"><i class='fa fa-thumbs-o-up'></i>&nbsp;&nbsp;I agree</a>
                            <a class='btn btn-danger' href="{{$base_url}}member/take_exam"><i class='fa fa-thumbs-o-down'></i>&nbsp;&nbsp;I do not
                                agree</a>
                    </p>
            </div>
        </div>
    </div>
</div>
        
@stop

@section('style')
    <style>
        h4 {
            border-bottom: 1px solid #f8f8f8;
            padding-bottom: 5px;
        }

        .subcontent {
            padding-left: 10px;
        }
    </style>
@stop

@section('script')
@stop

