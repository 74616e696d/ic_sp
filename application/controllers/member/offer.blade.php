<link rel="stylesheet" type="text/css" href="<?php echo $base_url(); ?>asset/vendor/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript" src="<?php echo $base_url(); ?>asset/vendor/fancybox/jquery.fancybox.js?v=2.1.5"></script>

<script type="text/javascript">
$(document).ready(function() {
	$.fancybox.open('<?php echo $base_url(); ?>asset/member/img/offer.jpg');
	setTimeout(function(){
	$.fancybox.close();
	},50000);
});
</script>