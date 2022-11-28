<div>
	<input type="hidden" name="hdn_user" value='{{$user}}'>
	<input type="hidden" name="hdn_cat" value="{{$cat}}">
	<label for="ddl_status">Status:</label>
	<select name="ddl_status" id="ddl-status">
		<option value="2">Approved</option>
		<option value="1">Pending</option>
		<option value="0">Not Requested</option>
	</select>
</div>