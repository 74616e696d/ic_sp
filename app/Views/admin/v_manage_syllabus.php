<div>
	<?php render_message();
		$this->my_validation->display_message();
	 ?>
</div>

<table class="table table-triped">
	<thead>
		<tr>
			<th>Exam</th>
			<th>Subject</th>
			<th>Details</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php echo $syllabus; ?>
	</tbody>
</table>

<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/readmore.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.more').readmore({
			speed:50,
			maxHeight:60,
			moreLink:'<a style="width:70px;" class="btn btn-mini btn-info" href="#"><i class="icon icon-plus-sign icon-white"></i>&nbsp;&nbsp;Read More</a>',
			lessLink:'<a style="width:70px;" class="btn btn-mini btn-info" href="#"><i class="icon icon-minus-sign icon-white"></i>&nbsp;&nbsp;Close</a>'
		});
	});
</script>