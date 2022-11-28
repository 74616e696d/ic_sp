<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/jquery-ui-1.8.14.custom.css">
<style>
		.list-group 
		{
			width:200px;
		  padding-left: 0;
		  margin-bottom: 20px;
		}

		.list-group-item {
		  position: relative;
		  display: block;
		  padding: 10px 15px;
		  /*margin-bottom: -1px;*/
		  background-color: #ffffff;
		  border: 1px solid #dddddd;
		  font-size:15px;
		  font-weight:bold;
		}

		.list-group-item:first-child {
		  border-top-right-radius: 4px;
		  border-top-left-radius: 4px;
		}

	.list-group-item:last-child 
	{
		margin-bottom: 0;
		border-bottom-right-radius: 4px;
		border-bottom-left-radius: 4px;
	}

	.list-group-item > .badge 
	{
		 float: right;
	}

	.list-group-item > .badge + .badge 
	{
		 margin-right: 5px;
	}

.container {
	margin-left:25px;
	width: 500px;
	/*background-color:#000000;*/
	border-bottom-color:#003366;
}
.draggable-list {
	/*background-color: #0066FF;*/
	list-style: none;
	margin: 0;
	min-height: 70px;
	padding: 10px;
}
.draggable-item {
	background-color: #FFF;
	border: 1px dotted #000;
	cursor: move;
	display: block;
	font-weight: bold;
	color:#CC0033;
	padding-bottom:  70px;
	margin: 5px;
}
#left
{
	border:1px solid #FB9337;
}
#selected_exam
{
	border:1px solid #66A54C;
	background:#66A54C;
}
#msg
{
	height:20px;
	padding:5px 5px;
	font-size:18px;
	color:#66A54C;
	border:1px solid #66A54C;
}

.list-group-item span{
	display:none;
}
</style>
<div class="pageheader">
    <h1 class="pagetitle">Choose Your Exam</h1>
    <span class="pagedesc"></span>
</div>
<div class="contentwrapper">
<div id='msg-container'></div>
	<div class="datatables_wrapper">

	</div>

<div class="container">
<h4>Drag an exam from the left side and drop to green box<hr/></h4>
  <ul id='left' class="draggable-list list-group" style="float:left;">
  <?php if($exams)
  {
	  	foreach ($exams as $exm) 
	  	{
	  		echo "<li class='list-group-item'><span>{$exm->id}</span><span>{$exm->test_type}</span>{$exm->test_name}</li>";
	  	}
  	} ?>
  </ul> <!-- end of exam list -->

  <ul id="selected_exam" class="draggable-list list-group" style="float:right;">
  	<?php
  		if(count($exam_list)>0){
  			foreach ($exam_list as $e) {
  				echo "<li class='list-group-item'><span>{$e['exam_id']}</span><span>{$e['exam_type']}</span>{$e['exam_text']}</li>";
  			}
  			
  		}
  	 ?>
  </ul><!-- end of selected exam -->

</div> <!-- end draggable -->

</div>
<table>
	
</table>


<script type="text/javascript">
$(document).ready(function() {
	var newList,oldList;
	$('.container .draggable-list').sortable({
		connectWith: '.container .draggable-list',
		start:function(event,ui){
			newList=oldList=ui.item.parent();
		},
		stop:function(event,ui){
			//alert("newList:"+newList.attr('id')+"\nOldList:"+oldList.attr('id'));
		},
		change:function(event,ui){
			if(ui.sender)newList=ui.placeholder.parent();
		},
		receive:function(event,ui){
			var eid=ui.item.children('span').first().text(),
				etype=ui.item.children('span').last().text();
				action_url='';
			if(newList.attr('id')=='selected_exam')
			{
				action_url="<?php echo base_url(); ?>member/choose_exam/save_user_exam_list";
			}
			else if(newList.attr('id')=='left')
			{
				action_url="<?php echo base_url(); ?>member/choose_exam/remove_user_exam";
			}
			
			$.ajax({
				url:action_url,
				type: 'post',
				data: {eid:eid,etype:etype},
			})
			.done(function(msg) {
				$('#msg-container').html("<p id='msg'>"+msg+"</p>");
			});
			
			}
	});
});	
</script>