<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>asset/css/chosen.css"/>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>-->
<script src="<?php echo base_url(); ?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<fieldset class="form-horizontal input-form">
	<legend>Add Comprehension</legend>
	<form  action="<?php echo base_url(); ?>admin/manage_comprehension/edit" method="post">
		<label for="txt_title">Title:</label>
		<input type="text" name="txt_title" id="txt_title" value="<?php echo $item->title; ?>">
        <input type="hidden" name="hdn_id" value="<?php echo $item->id; ?>">
		<label for="txt_comprehension">Details:</label>
		<?php echo $this->ckeditor->editor("txt_comprehension","{$item->details}"); ?>
		<br/>
		<button type="submit" class='btn btn-default'><i class="fa fa-save"></i>&nbsp;&nbsp;Update</button>
        <button type="reset" class='btn btn-info'><i class="fa fa-refresh"></i>&nbsp;&nbsp;Reset</button>
	</form>
</fieldset>

<script type="text/javascript">
    $(document).ready(function(){

    });
</script>