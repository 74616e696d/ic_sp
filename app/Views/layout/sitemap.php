<div id='sitemap' class='row'>
        <ul>
         <li><a href="">You are</a>&nbsp;&nbsp;</li>
        	<?php 
        	if($sitemap){
        	$i=0;
        	foreach ($sitemap as $stmp) {
	       		$i++;
	       		if(count($sitemap)==$i)
	       		{
	       			echo "<li><a href=''>{$stmp}</a>&nbsp;&nbsp;</li>";
	       		}
	       		else
	       		{
	       			  echo "<li><a href=''>{$stmp}</a>&nbsp;&nbsp;>&nbsp;&nbsp;</li>";
	       		}
        	}} 
        	?>
        </ul>
</div>