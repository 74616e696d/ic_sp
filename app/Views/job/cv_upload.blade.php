@extends('job.front_master.master')

@section('content')
	<section class="wrapper-header-box">
	    <div class="container-fluid">
	        <div class="container">
	            <div class="row">
	                <div class="col-md-6 col-sm-6 col-xs-12">
	                </div>
	                <div class="col-md-6 col-sm-6 col-xs-12">
	                    <div class="header-top-part">
	                        <h2>
	                            Companies like your profile!
	                            <br/>
	                            <b>
	                                Let employers find you.
	                            </b>
	                        </h2>
	                        <div class="box">
	                            <p>
	                                Receive attractive job offers from employers.
	                            </p>
	                            <a id='lnkCvUplaod' class="btn btn-default custom-btn" href="">
	                                Upload your CV now !
	                            </a>
	                        </div>
	                        <div class="box file-box hide">
	                        	@auth
	                        	<div class="dropzone" id='dropzone'>
	                        		
	                        	</div>
	                        	@endauth
                            @guest
	                        	<div class="alert alert-danger">
	                        		Please ! <a class='btn btn-outline' href="/login">Login</a> To Upload Your CV
	                        	</div>
	                        	@endguest
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</section>
	<section class="wrapper-lock-box">
	    <div class="container-fluid">
	        <div class="container">
	            <div class="row">
	                <div class="col-md-4 col-sm-4 col-xs-12">
	                    <div class="lock-box">
	                        <div class="media">
	                            <a class="pull-left" href="#">
	                                <img class="media-object" src="/asset/job/theme/images/lock-box.png">
	                            </a>
	                            <div class="media-body">
	                                <h4 class="media-heading">
	                                    Confidential
	                                </h4>
	                                <p>
	                                    You decide if your CV is anonymous or public
	                                </p>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-md-4 col-sm-4 col-xs-12">
	                    <div class="lock-box">
	                        <div class="media">
	                            <a class="pull-left" href="#">
	                                <img class="media-object" src="/asset/job/theme/images/hand.png">
	                            </a>
	                            <div class="media-body">
	                                <h4 class="media-heading">
	                                    Simple
	                                </h4>
	                                <p>
	                                    Easily created thanks to the CV import tool.
	                                </p>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-md-4 col-sm-4 col-xs-12">
	                    <div class="lock-box">
	                        <div class="media">
	                            <a class="pull-left" href="#">
	                                <img class="media-object" src="/asset/job/theme/images/arrow-life.png">
	                                </img>
	                            </a>
	                            <div class="media-body">
	                                <h4 class="media-heading">
	                                    Confidential
	                                </h4>
	                                <p>
	                                    You decide if your CV is anonymous or public
	                                </p>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</section>
	<section class="wrapper-job-search-box">
	    <div class="container-fluid">
	        <div class="container">
	            <div class="row">
	                <div class="col-md-12 col-sm-12 col-xs-12">
	                    <div class="job-search-layout">
	                        <h2>
	                            Become visible for top companies.
	                        </h2>
	                        <p>
	                            More than 3000 recruiters from leading companies are looking for the right candidate. With an active CV, you
	                            <br/>
	                            also can be found.
	                        </p>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</section>
	<section class="wrapper-scan-search-box">
	    <div class="container-fluid">
	        <div class="container">
	            <div class="row">
	                <div class="col-md-6 col-sm-6 col-xs-12">
	                    <div class="job-scan-layout">
	                        <h2>
	                            Scan the appropriate jobs in a few
	                            <br/>
	                            seconds.
	                        </h2>
	                        <p>
	                            With CV Check, you can see at a glance if a position fits you. Your  professional experience, your education, your language skills and your age are compared with listed search results.
	                        </p>
	                    </div>
	                </div>
	                <div class="col-md-6 col-sm-6 col-xs-12">
	                    <div class="job-scan-picture-layout">
	                        <a class="pull-left" href="#">
	                            <img class="media-object img-responsive hide" src="/asset/job/theme/images/job-first-come.png">
	                            </img>
	                        </a>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</section>
@stop


@section('style')
<link rel="stylesheet" href="/asset/vendor/dropzone/dropzone.css">
@stop

@section('script')
<script type="text/javascript" src="/asset/vendor/dropzone/dropzone.js"></script>

<script type="text/javascript">
$(document).ready(function() {

	// $('.file-box').hide();
	$('#lnkCvUplaod').click(function(e) {
		e.preventDefault();
		$('.file-box').removeClass('hide');
		$(this).parent('.box').addClass('hide');
	});

	 var myDropzone = new Dropzone("div#dropzone", { 
	    url: "/job/job_list/upload_cv",
	    // width:                  300,   
	    // height:                 300,                         
	    progressBarWidth:       '100%',                            
	    // filesName:              'files',                        
	    margin:                 0,                              
	    border:                 '2px dashed #ccc',              
	    background:             '',
	    zIndex:                 10000,                        
	    textColor:              '#ccc',                         
	    textAlign:              'center',                       
	    text:                   'Drop Your CV Here',    
	    // uploadMode:             'single',                       
	    // progressContainer:      '',                             
	    // src:                    '',                             
	    dropzoneWraper:         'nniicc-dropzoneParent',     
	    // files:                  [],                             
	    maxFileSize:            '5MB',                         
	    allowedFileTypes:       '',                            
	    clickToUpload:          true,                           
	    showTimer:              true,                           
	    removeComplete:         true,                           
	    preview:                true,                          
	    uploadOnPreview:        true,                          
	    uploadOnDrop:           true, 
	    success:                function(){reload_files();}
	});
});

function reload_files()
{
	var str='';
	str+="<div class='alert alert-success'>";
	str+="Your CV Uploaded successfully !";
	str+="</div>";
	$('.file-box').html(str);
}
</script>
@stop