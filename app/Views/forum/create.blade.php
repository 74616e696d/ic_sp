@extends('front_master.master')

@section('content')
@if($is_auth)
<div class="container" style="padding-top:15px;padding-bottom:15px;">

<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title panel-post-title">Ask Your Question</h3>
        </div>
        <div class="panel-body panel-post">
            <p>আপনার তথ্য/মতামত/আলোচনা/সমালোচনা পোষ্ট করুন</p>
            <div id='msg'>
            {{render_message()}}
            </div>
            {{ form_open_multipart("{$base_url}forum/forum/save_post") }}
                @if(!$is_member)
                <div class="form-inline">
                    <select class="form-control" name="category" id="category">
                        <option value="">Select Category</option>
                        @if($category)
                        @foreach($category as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                        @endif
                    </select>
                    <select class='form-control' name="subcategory" id="subcategory">
                        <option value="">Select Subcategory</option>
                    </select>
                </div><br>
                @endif
                <input type="text" class="form-control" required="required" name="title" id="title" placeholder='Title'>
                <br>
                <textarea class="form-control" name="post" id="post" cols="30" rows="3" placeholder='Write your question or discussion details'></textarea>
                <br>

               <input type="file" name="userfile" id="userfile">
                <br>
                <button type="submit" id='btn_post' class="btn btn-default"><i class="fa fa-save"></i> Save </button>
                <a href="{{ $base_url }}forum/forum/posts" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a>
                <br>
            {{ form_close() }}
        </div>
    </div>
  
</div>

<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">How To Post</h3>
        </div>
        <div class="panel-body">
            <ul class="list-unstyled">
                 <li>1.) Select Category</li>
                 <li>2.) Select Subcategory</li>
                 <li>3.) Write a title</li>
                 <li>4.) Write post details</li>
                 <li>5.) Save</li>
             </ul> 
        </div>
    </div>
</div>

     
</div>
	
@else
<div style='min-height: 400px;display:flex;align-items: center;justify-content: center;'>
    <h2>You must login to post !</h2>
</div>
@endif

@stop


@section('style')
<style>
    .panel-post-title{font-size: 17px;}
    .panel{
        border:none;
        box-shadow: none;
    }
    .panel .panel-heading{
        background-color: #fff;
        border:none;
    }
    .panel-post{
        padding:20px;
    }
</style>
@stop

@section('script')
<script type="text/javascript" src="{{ $base_url }}asset/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    CKEDITOR.replace('post',{customConfig: '{{ $base_url }}asset/ckeditor/config-member.js'});
    $('#category').change(function() {
        var id=$(this).val();
        $.ajax({
            url: '{{$base_url}}forum/forum/get_sub_cat',
            type: 'GET',
            data: {id:id},
        })
        .done(function(data) {
            $('#subcategory').html(data);
        });
    });
});
</script>
@stop