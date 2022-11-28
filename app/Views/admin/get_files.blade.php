<div class="dropzone" id="dropzone">
</div>

<div>
    <div class="file-box">
        {{ $files }}
    </div>
</div>

<link rel="stylesheet" href="{{$base_url}}asset/vendor/dropzone/dropzone.css">
<script type="text/javascript" src="{{$base_url}}asset/vendor/dropzone/dropzone.js"></script>
<script type="text/javascript">
$(document).ready(function() {
     var myDropzone = new Dropzone("div#dropzone", { 
        url: "{{$base_url}}admin/news/load_image",
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
        text:                   'Drop files here to upload',    
        // uploadMode:             'single',                       
        // progressContainer:      '',                             
        // src:                    '',                             
        dropzoneWraper:         'nniicc-dropzoneParent',     
        // files:                  [],                             
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

function reload_files()
{
    $.ajax({
        url: '{{$base_url}}admin/news/reload_files',
        type: 'GET'
    })
    .done(function(res) {
        $('#myModal .file-box').html(res);
    });
}
</script>