@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx bx-header">
				<div class="bx-title">
				Post a question 

				</div>
			</div>
			<div class="bx bx-body">
				<p>
					কোন প্রশ্নের উত্তর জানা না  থাকে, তবে আমাদের জিজ্ঞেস করতে পারেন, আমরা অতিসত্বর প্রশ্নটির উত্তর দেওয়ার চেষ্টা করব।<br>
					আপনার প্রশ্নটি নিচের বক্সে লিখুন, আপনি চাইলে প্রশ্নের ছবি তুলে আপলোড করতে পারেন।
				</p>
				<form method='post' action="{{ $base_url }}member/ask_question/make" class="form-horizontal" enctype="multipart/form-data">
					<div class="form-group">
						<label for="tag" class="col-sm-2 control-label">Tag/Category</label>
						<div class="col-sm-5">
							<input class='form-control' type="text" name="tag" id="tag" required='required' placeholder='example: geometry, ত্রিভুজ,'>
						</div>
					</div>

					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">Question Title 
						<!-- (<i title='dfdfd' data-toolti class="fa fa-question-circle"></i>) -->
						</label>
						<div class="col-sm-5">
							<input class='form-control' type="text" name="title" id="title" required='required'>

						</div>
					</div>

					<div class="form-group">
						<label for="question" class="col-sm-2 control-label">Question Details</label>
						<div class="col-sm-5">
							
							<textarea name="question" id="question" cols="30" rows="10"></textarea>
							
						</div>
					</div>
					
					
					<div class="form-group">
						<label for="question" class="col-sm-2 control-label">Image Upload (If any)</label>
						<div class="col-sm-5">
							<input type="file" name="userfile" id="userfile">
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-5 col-sm-offset-2">
							<button class='btn btn-info' type="submit">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@stop


@section('style')
<link rel="stylesheet" href="{{ $base_url }}asset/css/jquery-ui-1.8.14.custom.css">
<!-- <link rel="stylesheet" href="{{ $base_url }}asset/frontend/css/bootstrap-tokenfield.min.css"> -->
<link rel="stylesheet" href="{{ $base_url }}asset/vendor/tag-input/bootstrap-tagsinput.css">
@stop

@section('script')
<script src="<?php echo base_url(); ?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<!-- <script type="text/javascript" src="{{ $base_url }}asset/frontend/js/bootstrap-tokenfield.js"></script>
<script type="text/javascript" src="{{ $base_url }}asset/js/jquery-ui-1.10.0.custom.min.js"></script> -->
<script type="text/javascript" src="{{ $base_url }}asset/vendor/tag-input/bootstrap-tagsinput.min.js"></script>
<script type="text/javascript" src="{{ $base_url }}asset/js/typeahead.bundle.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		 CKEDITOR.replace( 'question',{toolbarStartupExpanded : true} );
		 //$('#tag').tokenfield();
		// $('#tag').tokenfield({
		//  	autocomplete: {
		//  	    source: ['red','blue','green','yellow','violet','brown','purple','black','white'],
		//  	    delay: 100
		//  	  },
		//  	 showAutocompleteOnFocus: true
		//  });
		

	});
</script>

<script type='text/javascript'>
var cities = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: '{{ $base_url }}asset/cities.json'
});
cities.initialize();

var elt = $('#tag');
// elt.tagsinput({
//   itemValue: 'value',
//   itemText: 'text',
//   typeaheadjs: {
//     name: 'cities',
//     displayKey: 'text',
//     source: cities.ttAdapter()
//   }
// });
// elt.tagsinput('add', { "value": 1 , "text": "Amsterdam"   , "continent": "Europe"    });
// elt.tagsinput('add', { "value": 4 , "text": "Washington"  , "continent": "America"   });
// elt.tagsinput('add', { "value": 7 , "text": "Sydney"      , "continent": "Australia" });
// elt.tagsinput('add', { "value": 10, "text": "Beijing"     , "continent": "Asia"      });
// elt.tagsinput('add', { "value": 13, "text": "Cairo"       , "continent": "Africa"    });


var items=[{"value":1,"text":"Amsterdam","continent":"Europe"},{"value":4,"text":"Washington","continent":"America"},{"value":7,"text":"Sydney","continent":"Australia"},{"value":10,"text":"Beijing","continent":"Asia"},{"value":13,"text":"Cairo","continent":"Africa"}];
</script>
@stop
