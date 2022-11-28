<style>
	#middle
	{
		max-width:300px;
	}
</style>
<div>
    <div>
        <?php render_message(); ?>
    </div>
    <p><a class="btn btn-info pull-right" href="<?php echo base_url(); ?>admin/manage_comprehension/add_comprehension">
    <i class="icon icon-plus-sign icon-white"></i>&nbsp;Add Comprehension</a></p>
    <br/><br/>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Questions</th>
				<th>Comprehension</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $comp_list; ?>
		</tbody>
	</table>

</div>

<div id="assign_dlg" class="modal hide fade" style='width:63%;'>
	<form method="POST" action="<?php echo base_url(); ?>admin/ques_to_comprehension/assign">
	<div class="modal-header">
	 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h3 id="myModalLabel">Assign Question To Comprehension</h3>
	</div>
	<div class="modal-body">
	 <p>One fine body…</p>
	 </div>
	<div class="modal-footer">
	<button class="btn pull-left" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i>&nbsp;Close</button>
	<button type="submit" class="btn btn-info"><i class="fa fa-save"></i>&nbsp;Save</button>
	</div>
	</form>
</div>


<div id="edit_assign_dlg" class="modal hide fade" style='width:70%;'>
	<!-- <form method="POST" action="<?php echo base_url(); ?>admin/ques_to_comprehension/edit_assigned_ques"> -->
	<div class="modal-header">
	 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h3 id="myModalLabel">Edit Question To Comprehension</h3>
	</div>
	<div class="modal-body">
	 <p>One fine body…</p>
	 </div>
	<div class="modal-footer">
	<button class="btn pull-right" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i>&nbsp;Close</button>
	<!-- <button type="submit" class="btn btn-info"><i class="fa fa-save"></i>&nbsp;Save</button> -->
	</div>
	<!-- </form> -->
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/readmore.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#assign_dlg').on('hidden', function () {
            $(this).removeData('modal');
        });

        $('#edit_assign_dlg').on('hidden', function () {
            $(this).removeData('modal');
        });
		$('.more').readmore({
			speed:50,
			maxHeight:60,
			moreLink:'<a style="width:65px;" class="btn btn-mini btn-info" href="#"><i class="icon icon-plus-sign icon-white"></i>&nbsp;More</a>',
			lessLink:'<a style="width:65px;" class="btn btn-mini btn-info" href="#"><i class="icon icon-minus-sign icon-white"></i>&nbsp;Close</a>'
		});
	});
</script>
