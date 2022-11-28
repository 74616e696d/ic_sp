<!Doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Online Exam</title>
		<link href="<?php echo base_url(); ?>asset/css/bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>asset/css/custom/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>asset/css/jquery-ui-1.10.0.custom.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>asset/admin/css/style.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script>
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

function viewme(id)
{
alert(id);
$.ajax({
url:'<?php echo base_url(); ?>Exam/home/set_question_paper',
type:'get',
data:{sl:id},
success:function(data){
alert(data);
}
});
}
</script>

		<!-- HTML5 shim for IE backwards compatibility -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
        <script src="<?php echo base_url(); ?>asset/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	</head>
	<body>
	
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Online Ex@m</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
          <form class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>
	<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
			<select name="examtype" id="examtype" style='width:60%;height:40px;border-radius:2px;margin:10px 0px 0px 0px'>
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
<div id="viewbox">
</div>
<div id="qs">
</div>
      </div>
    </div>
	
	</body>
</html>