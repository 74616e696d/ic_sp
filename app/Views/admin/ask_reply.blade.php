
 <div class="control-group">
    <input type="hidden" name="hdn_id" value="{{ $ques->id }}">
  <input type="hidden" name="hdn_ans_id" value="{{ $answer?$answer->id:0 }}">

    <label for="txt_reply" class="control-label"><strong>Question</strong></label>
    <div class="controls">
      {{ strip_tags($ques->ques,"<img><i><b><u><sup><sub>") }}
      <br>
      <img src="{{ $base_url }}asset/images/upload/{{ $ques->img }}" alt="">
    </div>
  </div>

  <div class="control-group">
    <label for="txt_reply" class="control-label"><strong>Answer</strong></label>
    <div class="controls">
      <textarea style='width:90%;' name="txt_reply" id="txt_reply" cols="60" rows="10">{{ $answer?$answer->ans:'' }}</textarea>
    </div>
  </div>


  <script src="<?php echo base_url(); ?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      //CKEDITOR.replace( 'txt_reply' );
    });
  </script>



