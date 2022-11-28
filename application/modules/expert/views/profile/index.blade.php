@extends('master.master')

@section('content')
<div class="col-lg-8 col-md-7">
 @include('profile.details')

 @include('profile.education')
</div>
<div class="col-lg-4 col-md-5">
    <div class="card card-user">
        <div class="image">
            <img src="{{ $base_url }}asset/expert/theme/img/background.jpg" alt="..."/>
        </div>
        <div class="content">
            <div class="author">
              <img class="avatar border-white" src="{{ $base_url }}asset/expert/theme/img/faces/face-2.jpg" alt="..."/>
              <h4 class="title">{{ $username }}</h4>
            </div>
            <p class="description text-center">
                {{ $title }}
            </p>
        </div>
        <hr>
        <div class="text-center">
            <div class="row">
                <div class="col-md-3 col-md-offset-1">
                    <h5>12<br /><small>Files</small></h5>
                </div>
                <div class="col-md-4">
                    <h5>2GB<br /><small>Used</small></h5>
                </div>
                <div class="col-md-3">
                    <h5>24,6$<br /><small>Spent</small></h5>
                </div>
            </div>
        </div>
    </div>
  
    @include('profile.tags')

</div>
@stop


@section('style')
<link rel="stylesheet" type="text/css" href="{{ $base_url }}asset/css/jquery-ui-1.8.14.custom.css">
<style>

</style>
@stop

@section('script')
<script type="text/javascript" src="{{ $base_url }}asset/js/jquery-ui-1.10.0.custom.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

   disable_all('expert_details_content');

   load_educations();

   load_tags();

   $('#new-education').on('hidden.bs.modal', function (e) {
        $(this).removeData('bs.modal');
        load_educations();
   });

   $('#editEducationModal').on('hidden.bs.modal', function (e) {
        $(this).removeData('bs.modal');
        load_educations();
   });

   $('.btnDeleteEdu').click(function(e){
         e.preventDefault();
         var id=$(this).data('id');
         var conf=confirm('Are you sure to delete ?');
        if(conf)
        {
            $.ajax({
                url: '{{ $base_url }}expert/profile/delete_education',
                type: 'POST',
                data: {id: id}
            })
            .done(function(res) {
                console.log(res);
                load_educations();
            });
        }
   });

   /**
    * jquery autocomplete for tags
    */
   $("#expert_tags").autocomplete({
       source: "{{ $base_url }}expert/profile/get_tags",
       minLength: 2,//search after two characters
       select: function(event,ui){
           $('#expert_tags').val(ui.item.value);
           $('#tag_id').val(ui.item.id);
        }
   });

   $('#btnAddTags').click(function(){
        var tag=$('#expert_tags').val();
        $.ajax({
            url: '{{ $base_url }}expert/profile/save_tags',
            type: 'POST',
            data: {tag:tag}
        })
        .done(function(res) {
            $('#expert_tags').val('');
            load_tags();
        });
   });


});

/**
 * load educations of expert
 */
function load_educations()
{
    $.ajax({
        url: '{{ $base_url }}expert/profile/get_education_details',
        type: 'GET',
    })
    .done(function(res) {
        $('.expert_education_content').html(res);
    });
}

function disable_all(el)
{
    $("."+el+" input[type='text']").attr('disabled','disabled');
    $("."+el+" textarea").attr('disabled','disabled');
    $("."+el+" select").attr('disabled','disabled');
    $("."+el+" checkbox").attr('disabled','disabled');
}

function enable_edit(el)
{
    var frm=$(el);
    frm.find('.btn-enable-edit').addClass('hide');
    frm.find("input[type='text']").removeAttr('disabled');
    frm.find("textarea").removeAttr('disabled');
    frm.find("select").removeAttr('disabled');
    frm.find("checkbox").removeAttr('disabled');
    frm.find(".btn-action").removeClass('hide');
}

function cancel_edit(el)
{
    var frm=$(el);
     frm.find('.btn-enable-edit').removeClass('hide');
    frm.find("input[type='text']").attr('disabled','disabled');
    frm.find("textarea").attr('disabled','disabled');
    frm.find("select").attr('disabled','disabled');
    frm.find("checkbox").attr('disabled','disabled');
    frm.find(".btn-action").addClass('hide');
}

/**
 * load tags
 */
function load_tags()
{
    $.ajax({
        url: '{{ $base_url }}expert/profile/get_expert_tags',
        type: 'GET'
    })
    .done(function(res) {
        $('#tagList').html(res);
    });
}
</script>
@stop