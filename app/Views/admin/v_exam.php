<style>
	.modal.fade.in
	{
		top:3%;
	}
</style>
<div>
	<?php render_message(); ?>
</div>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Exam Category</th>
			<!-- <th>Consist Of</th> -->
			<th>Test Type</th>
			<th>Test Name</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php echo $exams; ?>
	</tbody>
</table>
<div id="edit_dlg" class="modal hide fade">
	<form method="POST" action="<?php echo base_url(); ?>admin/exam/edit">
		<div class="modal-header">
   	 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    	<h3 id="myModalLabel">Edit  Exam</h3>
  	</div>
  	<div class="modal-body" style='max-height:500px;'>
   	 <p>One fine body…</p>
 	 </div>
  	<div class="modal-footer">
    	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    	<button type="submit" class="btn btn-info pull-left"><i class='icon icon-ok-circle'></i>Save</button>
  </div>
  </form>
	</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#edit_dlg').on('hidden', function () {
  		$(this).removeData('modal');
		});
	});
</script>