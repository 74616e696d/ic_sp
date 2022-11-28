<!DOCTYPE html>
<html>
<head>
	<title>Demo Question</title>
	<style type="text/css">
		body{
		padding:0px;
		margin:0px;
		background-color:#444;
		
		}
		#wrraper{
		width:70%;
		background-color:#fff;
		display:block;
		margin:0px auto;
		border-radius:20px;
		-webkit-box-shadow:  1px 4px 1px 2px rgba(0, 0, 0, .50);
        box-shadow:  1px 4px 1px 2px rgba(0, 0, 0, .50);
		padding:1px;
		
		}
		#wrraper h1{
		border-bottom:2px red solid;
		}
		#wrraper p{
		margin:2px 2px 5px 32px;
		}
	</style>
			<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#examtype").change(function(){
 var item=$("#examtype").val();
$.ajax({
url:'<?php echo base_url(); ?>Exam/home/get_parent_text',
type:'post',
data:{parent_id:item},
success:function(data){
$("#viewbox").html(data);
}
});
});
});
</script>
</head>
<body>
<div id="wrraper">
		<h1>Demo Question Paper:</h1>
		<select name="examtype" id="examtype" style='width:60%;height:50px;border-radius:7px;background-color:#cdcdcd;font-size:14px'>
			<option>---Select Exam type---</option>
		
		<?php echo form_open_multipart(base_url()."admin/add_question/add");?>
			<?php
			
			foreach($question as $q_list)
			{
			?>
			<?php echo"<option value='{$q_list->id}'>".$q_list->name."</option>";?>
			<?php
			}
?>
</select>
</form>
<div id="viewbox">
</div>
</div>
</body>
</html>