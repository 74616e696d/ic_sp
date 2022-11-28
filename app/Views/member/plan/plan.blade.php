    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 frm-choice">
        <select class="form-control" name="category" id="category">
            <option value="">Select Category</option>
            @if($exam_cat)
            @foreach($exam_cat as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
            @endif
        </select>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 frm-choice">
        <select class='form-control' name="subject" id="subject">
            <option value="">Select Subject</option>
        </select>
    </div>
 
 <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 frm-choice">
    <select class='form-control' name="chapter" id="chapter">
        <option value="">Select Chapter</option>
    </select>
 </div>

 <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 frm-choice">
 <input type="text" name="dtpick" id="dtpick" class="form-control" placeholder='Date'>
 </div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<button id='plan_save' class="btn btn-primary">Save</button>
</div>
<div id='choice_list' class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    {{ $choice_list }}
</div>
<div class="clearfix"></div>
