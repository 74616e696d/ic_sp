@extends('admin_master.layout')

@section('content')
<a href="#myModal" role="button" class="btn pull-left" data-toggle="modal">Upload New Image</a>

 <div class="btn-group pull-right" style='z-index:1000;'>
      <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-filter"></i>Quick Filter
        <span class="caret"></span>
      </a>
      <ul class="dropdown-menu filter">
	       <li><a href="" data-term='1'>Last One Week</a></li>
	       <li><a href="" data-term='2'>Last One Month</a></li>
	       <li><a href="" data-term='3'>All before One Month</a></li>
	       <li><a href="" data-term='4'>Size&lt;500 KB</a></li>
	       <li><a href="" data-term='5'>Size between 500 KB &amp; 1MB</a></li>
	       <li><a href="" data-term='6'>Size&gt;1 MB</a></li>
	       <li><a href="" data-term='10'>All</a></li>
      </ul>
 </div>
 <div class="clearfix"></div>
 <br><br>
<div id="file-content">
<p class='alert'><i class="fa fa-info-circle"></i> Click to copy image name</p>
{{ $files }}
</div>
<!-- </div> -->

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h3 id="myModalLabel">Upload Files</h3>
	</div>
	<div class="modal-body">
		<div class="dropzone" id="dropzone">
		</div>
	</div>
	<div class="modal-footer">
	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>

</div>
@stop


@section('style')
<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="<?php echo $base_url(); ?>asset/vendor/dropzone/dropzone.css">
<style>
	.thumbnail { margin-bottom: 5px; }
	#file-content{min-height: 300px;}
	.ripplelink{
	  display:block;
	  text-align:center;
	  position:relative;
	  -webkit-transition: all 0.2s ease;
	  -moz-transition: all 0.2s ease;
	  -o-transition: all 0.2s ease;
	  transition: all 0.2s ease;
	  z-index:0;
	}

	.ripplelink:hover{
		z-index:1000;
	  box-shadow:rgba(0, 0, 0, 0.3) 0 16px 16px 0;
	  -webkit-box-shadow:rgba(0, 0, 0, 0.3) 0 16px 16px 0;
	  -moz-box-shadow:rgba(0, 0, 0, 0.3) 0 16px 16px 0;
	}

	.ink {
	  display: block;
	  position: absolute;
	  background:rgba(176, 219, 138, 0.3);
	  border-radius: 100%;
	  -webkit-transform:scale(0);
	     -moz-transform:scale(0);
	       -o-transform:scale(0);
	          transform:scale(0);
	}

	.animate {
		-webkit-animation:ripple 0.65s linear;
	   -moz-animation:ripple 0.65s linear;
	    -ms-animation:ripple 0.65s linear;
	     -o-animation:ripple 0.65s linear;
	        animation:ripple 0.65s linear;
	}

	@-webkit-keyframes ripple {
	    100% {opacity: 0; -webkit-transform: scale(2.5);}
	}
	@-moz-keyframes ripple {
	    100% {opacity: 0; -moz-transform: scale(2.5);}
	}
	@-o-keyframes ripple {
	    100% {opacity: 0; -o-transform: scale(2.5);}
	}
	@keyframes ripple {
	    100% {opacity: 0; transform: scale(2.5);}
	}


	.cyan{
	  background:#00bcd4;
	}

	.lightgreen{
	  background:#8bc34a;
	}

	.amber{
	  background:#ffc107;
	}

	.orange{
	  background:#ff9800;
	}
</style>
@stop

@section('script')
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<script type="text/javascript" src="<?php echo $base_url(); ?>asset/vendor/dropzone/dropzone.js"></script>
<script type="text/javascript" src="<?php echo $base_url(); ?>asset/js/clipboard.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(document).ready(function() {
		     var myDropzone = new Dropzone("div#dropzone", { 
		        url: "<?php echo $base_url(); ?>admin/manage_media/send",
		        progressBarWidth:       '100%',                            
		        filesName:              'files',                     
		        margin:                 0,                              
		        border:                 '2px dashed #ccc',              
		        background:             '',
		        zIndex:                 10000,                        
		        textColor:              '#ccc',                         
		        textAlign:              'center',                       
		        text:                   'Drop files here to upload',    
		        // uploadMode:             'single',                       
		        dropzoneWraper:         'nniicc-dropzoneParent',     
		        maxFileSize:            '5MB',                         
		        allowedFileTypes:       '*',                            
		        clickToUpload:          true,                           
		        showTimer:              true,                           
		        removeComplete:         true,                           
		        preview:                true,                          
		        uploadOnPreview:        true,                          
		        uploadOnDrop:           true, 
		        success:                function(){reload_files();}
		    });
		});

		$('.thumbnail').hover(function() {
			$(this).children('.btn-delete').show(400);
		}, function() {
			$(this).children('.btn-delete').hide(400);
		});
	
		$('.filter li a').click(function(e){
			e.preventDefault();
			var term=$(this).data('term');
			$.ajax({
				url: '{{ $base_url }}admin/manage_media/reload_files',
				type: 'POST',
				data: {term: term}
			})
			.done(function(res) {
				$('#file-content').html(res);
				var clipboard = new Clipboard('.thumbnail');
			});
		});

	});

	$(function(){
		var ink, d, x, y;
			$(".ripplelink").click(function(e){
		    if($(this).find(".ink").length === 0){
		        $(this).prepend("<span class='ink'></span>");
		    }
		         
		    ink = $(this).find(".ink");
		    ink.removeClass("animate");
		     
		    if(!ink.height() && !ink.width()){
		        d = Math.max($(this).outerWidth(), $(this).outerHeight());
		        ink.css({height: d, width: d});
		    }
		     
		    x = e.pageX - $(this).offset().left - ink.width()/2;
		    y = e.pageY - $(this).offset().top - ink.height()/2;
		     
		    ink.css({top: y+'px', left: x+'px'}).addClass("animate");
			var clipboard = new Clipboard('.thumbnail');
		});
	});

	function reload_files()
	{
	    $.ajax({
	        url: '<?php echo $base_url(); ?>admin/manage_media/reload_files',
	        type: 'GET'
	    })
	    .done(function(res) {
	        $('#file-content').html(res);
	        var clipboard = new Clipboard('.thumbnail');
	    });
	}
</script>
@stop