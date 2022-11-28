<style>
ul{
	width:350px;
	margin:0 auto;
	margin-top:10%;
}
.head
{
    /*line-height:25px;*/
    background:#0177BF;
    padding:1px !important;
}
ul li
{
	list-style: none;
	line-height:30px;
	padding-top:5px;
    padding-left:10px;
    padding-right:10px;
}

ul li input[type='text']
{
	width:280px;
	height:30px;
	 background-color: #FFFFFF;
    border: 1px solid #CCCCCC;
    padding-left:4px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    transition: border 0.2s linear 0s, box-shadow 0.2s linear 0s;
}

ul li input[type='text']:focus
{
	border:1px solid #f6f6f6;
}

ul li input[type='submit']
{
	 -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-image: none;
    border-radius: 4px;
    border-style: solid;
    border-width: 1px;
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
    color: #333333;
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    line-height: 20px;
    margin-bottom: 0;
    padding: 4px 12px;
    text-align: center;
    text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
    vertical-align: middle;

     background-color: #49AFCD;
    background-image: linear-gradient(to bottom, #5BC0DE, #2F96B4);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #FFFFFF;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
}
#msg
{
	min-height:40px;
}
</style>

<form method='post' action="<?php echo base_url(); ?>retrieve_password/send">
<input type="hidden" name="hdn_key" value="<?php echo $key; ?>">
<ul>
    <li class="head"><h1><img src="<?php echo base_url(); ?>asset/frontend/img/logo.png" alt=""></h1></li>
	<li>
     <?php if($this->session->flashdata('msg'))
     {echo $this->session->flashdata('msg');
     }   
     ?>
    </li>
    <li>Password</li>
	<li><input type='password' name='pass' id='pass' required='required' placeholder='Password'/></li>
	
    <li>Password Again</li>
    <li><input type="password" name="pass_again" id="pass_again" placeholder='Password Again'></li>
    <li><input type="submit" value="Change"></li>
</ul>

</form>

<div id='footer'>

</div>