<div>
	<?php echo render_message(); ?>
</div>
<p><a class="btn btn-info pull-right" role="button" data-toggle="modal" data-target="#add_dlg" href="#"><i class="icon icon-plus"></i>Add</a></p>
<br/><br/>
<table class="table table-striped">
	<thead>
	<tr>
		<th>Membership Type</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>
	</thead>
	<tbody>
	<?php if($list){foreach ($list as $m) {
		echo "<tr>";
			$url=base_url().'admin/membership/edit_view/'.$m->id;
			echo "<td>{$m->name}</td>";
			echo "<td><a href='{$url}' data-role='button' data-target='#edit_dlg' data-toggle='modal'><i class='icon icon-edit'></i</a></td>";
			echo "<td><a onclick='return(confirm(\"are you sure to delete?\"));' href='#'><i class='icon icon-trash'></i></a></td>";
	
		echo "</tr>";
		}} ?>
	</tbody>
</table>


<!--Start Add Dialog-->	
<div id="add_dlg" class="modal hide fade">
	<form class="form-horizontal" method="POST" action="<?php echo base_url(); ?>admin/membership/add">
		<div class="modal-header">
   	 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    	<h3 id="myModalLabel">Add Membership</h3>
  	</div>
  	<div class="modal-body">
   	 	<label for="txt_membership">Membership Type:</label>
   	 	<input type="text" name="txt_membership" id="txt_membership_edit" required="required" placeholder="Membership Type"/>
 	 </div>
  	<div class="modal-footer">
    	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    	<button type="submit" class="btn btn-primary pull-left">Save changes</button>
  </div>
  </form>
</div><!--End Add Dialog-->

<!--Start Edit Dialog-->
<div id="edit_dlg" class="modal hide fade">
	<form class="form-horizontal" method="POST" action="<?php echo base_url(); ?>admin/membership/edit">
		<div class="modal-header">
   	 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    	<h3 id="myModalLabel">Edit Membership</h3>
  	</div>
  	<div class="modal-body">
   	 	
 	 </div>
  	<div class="modal-footer">
    	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    	<button type="submit" class="btn btn-primary pull-left">Update changes</button>
  </div>
  </form>
</div><!--End Edit Dialog-->



<script type="text/javascript">
	$(document).ready(function(){
		$('#add_dlg').on('hidden', function () {
  		$(this).removeData('modal');
		});

		$('#edit_dlg').on('hidden', function () {
  		$(this).removeData('modal');
		});
	});
</script>