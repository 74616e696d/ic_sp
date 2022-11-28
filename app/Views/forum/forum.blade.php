@extends('front_master.master')
@section('content')
<div class="row">
    <!-- <div class="col-lg-12"> -->
    <div class="col-sm-7 right-zero-pad">
        <div class="bx">
            <div class="bx-header">
                <h4 class="bx-title">Iconpreparation Forum</h4>
            </div>
            <div class="bx bx-body">
                <div id='msg'>

                </div>
                <form action="{{$base_url}}forum/forum/save_post" method='post'>
                    <div class="form-inline">
                    
                            <select class="form-control" name="category" id="category">
                                <option value="">Select Category</option>
                                @if($category)
                                @foreach($category as $c)
                                <option value="{{$c->id}}">{{$c->name}}</option>
                                @endforeach
                                @endif
                            </select> &nbsp;&nbsp;
                            <select class='form-control' name="subcategory" id="subcategory">
                                <option value="">Select Subcategory</option>
                            </select>
                    </div>
                        <br>
                        <input type="text" class="form-control" name="title" id="title" placeholder='Title'>
                        <br>
                        <textarea class="form-control" name="post" id="post" cols="30" rows="3" placeholder='Write your question or discussion details'></textarea>
                        <br>
                        <a href="{{$base_url}}forum/forum/posts" class="btn btn-danger btn-sm">Cancel</a>
                        <button id='btn_post' class="btn btn-info btn-sm">Save</button>
                    </form>
            </div>
        </div>
        <div class="col-sm-5"></div>
        <div class="clearfix"></div>
        <!-- </div> -->
    </div>
    @stop
    @section('script')
    <script type="text/javascript">
    var baseurl='{{$base_url}}';
    </script>
    <script type="text/javascript" src="{{$base_url}}asset/member/js/forum.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
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